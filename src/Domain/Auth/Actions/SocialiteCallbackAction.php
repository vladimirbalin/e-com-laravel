<?php

declare(strict_types=1);

namespace Src\Domain\Auth\Actions;

use Src\Domain\Auth\DTOs\SocialiteCallbackDto;
use Src\Domain\Auth\Models\User;
use Src\Support\SessionRegenerateAction;

class SocialiteCallbackAction
{
    public function handle(SocialiteCallbackDto $dto): void
    {
        $user = User::updateOrCreate([
            $dto->driver . '_id' => $dto->id,
        ], [
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);

        SessionRegenerateAction::handle(fn () => auth()->login($user));
    }
}
