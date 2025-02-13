<?php

namespace App\Jobs;

use App\Models\Affirmation;
use App\Models\Letter;
use App\Models\UserLetter;
use App\Models\UserAffirmation;
use App\Models\UserProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateUsersLettersAndAffirmations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        UserProfile::has('intention')->lazy()->each(function($userProfile){

            /**
             * Create new letter Job
             */
            $letter_ids = UserLetter::where('user_id', $userProfile->user_id)->pluck('letter_id')->all();

            $letter = Letter::whereNotIn('id', $letter_ids)->whereHas('intention', function($q) use($userProfile){
                $q->where('intentions.id', $userProfile->intention_id);
            })->first();

            $new_letter = new UserLetter();
            $new_letter->user_id =  $userProfile->user_id;
            $new_letter->letter_id =  $letter->id;
            $new_letter->date_time = now()->setTimeFromTimeString('12:00:00');
            $new_letter->save();

            /**
             * Create new affirmation job
             */
            $affirmation_ids = UserAffirmation::where('user_id', $userProfile->user_id)->pluck('affirmation_id')->all();

            $affirmation = Affirmation::whereNotIn('id', $affirmation_ids)->whereHas('intention', function($q) use($userProfile){
                $q->where('intentions.id', $userProfile->intention_id);
            })->first();

            $new_affirmation = new UserAffirmation();
            $new_affirmation->user_id =  $userProfile->user_id;
            $new_affirmation->affirmation_id =  $affirmation->id;
            $new_affirmation->date_time = now()->setTimeFromTimeString('12:00:00');
            $new_affirmation->save();

        });
    }
}
