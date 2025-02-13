<?php

namespace App\Providers;

use App\Models\Background;
use App\Models\Intention;
use App\Observers\BackgroundObserver;
use App\Models\User;
use App\Observers\IntentionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Intention::observe(IntentionObserver::class);
        Background::observe(BackgroundObserver::class);
        User::observe(UserObserver::class);
    }
}
