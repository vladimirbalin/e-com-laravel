<?php

namespace App\Listeners;

use App\Notifications\WelcomeUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Domain\Auth\Models\User;

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
