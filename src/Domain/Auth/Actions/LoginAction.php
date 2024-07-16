<?php

declare(strict_types=1);

namespace Src\Domain\Auth\Actions;

use App\Events\SessionRegeneratedEvent;
use Src\Domain\Auth\DTOs\LoginDto;

class LoginAction
{
    public function handle(LoginDto $dto): bool
    {
        $oldId = request()->session()->getId();

        if (! auth()->attempt([
            'email' => $dto->email,
            'password' => $dto->password
        ])) {
            return false;
        }

        event(new SessionRegeneratedEvent($oldId, request()->session()->getId()));

        return true;
    }
}
