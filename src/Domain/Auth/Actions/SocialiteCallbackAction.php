<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Actions;

use Src\Domain\Auth\DTOs\SocialiteCallbackDto;
use Src\Domain\Auth\Models\User;
use Src\Support\SessionRegenerateAction;

class SocialiteCallbackAction
{
    public function handle(SocialiteCallbackDto $dto)
    {
        $user = User::updateOrCreate([
            $dto->getDriver() . '_id' => $dto->getId(),
        ], [
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => $dto->getPassword()
        ]);

        SessionRegenerateAction::handle(fn () => auth()->login($user));

    }
}
