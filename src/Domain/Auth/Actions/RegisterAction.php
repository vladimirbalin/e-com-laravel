<?php
declare(strict_types=1);

namespace Src\Domain\Auth\Actions;

use Illuminate\Auth\Events\Registered;
use Src\Domain\Auth\Contracts\Register;
use Src\Domain\Auth\DTO\RegisterDto;
use Src\Domain\Auth\Models\User;

class RegisterAction implements Register
{
    public function __invoke(RegisterDto $dto): void
    {
        $user = User::create([
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => bcrypt($dto->getPassword()),
        ]);

        event(new Registered($user));

        auth()->login($user);
    }
}
