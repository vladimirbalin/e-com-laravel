<?php
declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

use Src\Support\ValueObjects\Email;
use Src\Support\ValueObjects\UserName;

readonly class RegisterDto
{
    public function __construct(
        private UserName $name,
        private Email    $email,
        private string   $password,
    ) {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): UserName
    {
        return $this->name;
    }
}
