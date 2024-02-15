<?php

namespace App\Listeners;

use App\Notifications\PasswordUpdatedNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Src\Domain\Auth\Models\User;

class PasswordUpdatedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(PasswordReset $event): void
    {
        /**
         * @var User $user
         */
        $user = $event->user;

        $user->notify(new PasswordUpdatedNotification());
    }
}
