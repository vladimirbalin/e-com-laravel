<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisteredListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(Registered $event): void
    {
        /**
         * @var User $user
         */
        $user = $event->user;

        $user->notify(new WelcomeUserNotification());
    }
}
