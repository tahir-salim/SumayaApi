<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserLetter;
use App\Models\UserAffirmation;
use Illuminate\Support\Str;

class SendLettersAndAffirmationsNotifications implements ShouldQueue
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
        UserLetter::whereNull('notification_id')->whereDate('date_time', now())->lazyById(200, $column = 'id')->each(function($userLetter){
            $notification = new Notification();
            $notification->user_id = $userLetter->user_id;
            $notification->title = "Your today's letter";
            $notification->body = Str::limit($userLetter->ar_text, 60);
            $notification->event = 'New Letter';
            $notification->event_id = $userLetter->letter_id;
            $notification->save();
            $userLetter->notification_id = $notification->id;
            $userLetter->save();
        });
        UserAffirmation::whereNull('notification_id')->whereDate('date_time', now())->lazyById(200, $column = 'id')->each(function($userAffirmation){
            $notification = new Notification();
            $notification->user_id = $userAffirmation->user_id;
            $notification->title = "Your today's affirmation";
            $notification->body = Str::limit($userAffirmation->ar_text, 60);
            $notification->event = 'New Affirmation';
            $notification->event_id = $userAffirmation->affirmation_id;
            $notification->save();
            $userAffirmation->notification_id = $notification->id;
            $userAffirmation->save();
        });
    }
}
