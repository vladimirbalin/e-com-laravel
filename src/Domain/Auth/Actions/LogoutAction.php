<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Actions;

use App\Events\SessionRegeneratedEvent;

class LogoutAction
{
    public function handle(): void
    {
        $oldId = request()->session()->getId();

        auth()->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        event(new SessionRegeneratedEvent($oldId, request()->session()->getId()));
    }
}
