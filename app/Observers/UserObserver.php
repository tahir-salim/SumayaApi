<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserProfile;

class UserObserver
{

    public function creating(User $user)
    {
        $userProfile = new UserProfile();
        $userProfile->date_of_birth = $user->date_of_birth;
        $userProfile->gender = $user->gender;
        $userProfile->marital_status = $user->marital_status;
        $userProfile->max_reminders_per_day = $user->max_reminders_per_day;
        $userProfile->min_reminders_per_day = $user->min_reminders_per_day;
        $userProfile->phone = $user->phone;
        $userProfile->start_time = $user->start_time;
        $userProfile->end_time = $user->end_time;
        $userProfile->country_id = optional($user->country)->id;
        $userProfile->income_level_id = optional($user->incomeLevel)->id;
        $userProfile->education_level_id = optional($user->educationLevel)->id;
        $userProfile->intention_id = optional($user->intention)->id;
        $userProfile->save();

        unset($user->date_of_birth);
        unset($user->gender);
        unset($user->marital_status);
        unset($user->max_reminders_per_day);
        unset($user->min_reminders_per_day);
        unset($user->phone);
        unset($user->start_time);
        unset($user->end_time);
        unset($user->country);
        unset($user->incomeLevel);
        unset($user->educationLevel);
        unset($user->intention);

    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        UserProfile::whereNull('user_id')->update(['user_id' => $user->id]);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        $userProfile = new UserProfile();
        $userProfile->date_of_birth = $user->date_of_birth;
        $userProfile->gender = $user->gender;
        $userProfile->marital_status = $user->marital_status;
        $userProfile->max_reminders_per_day = $user->max_reminders_per_day;
        $userProfile->min_reminders_per_day = $user->min_reminders_per_day;
        $userProfile->phone = $user->phone;
        $userProfile->start_time = $user->start_time;
        $userProfile->end_time = $user->end_time;
        $userProfile->save();

        unset($user->date_of_birth);
        unset($user->gender);
        unset($user->marital_status);
        unset($user->max_reminders_per_day);
        unset($user->min_reminders_per_day);
        unset($user->phone);
        unset($user->start_time);
        unset($user->end_time);
    }

    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
