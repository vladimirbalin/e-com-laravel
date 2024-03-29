<?php

namespace App\Providers;

use App\Events\SessionRegeneratedEvent;
use App\Listeners\PasswordUpdatedListener;
use App\Listeners\RegisteredListener;
use App\Listeners\SessionRegenerateListener;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            RegisteredListener::class
//            SendEmailVerificationNotification::class,
        ],
        PasswordReset::class => [
            PasswordUpdatedListener::class
        ],
        SessionRegeneratedEvent::class => [
            SessionRegenerateListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
