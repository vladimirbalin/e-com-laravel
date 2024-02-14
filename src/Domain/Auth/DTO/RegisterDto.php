<?php
declare(strict_types=1);

namespace Src\Domain\Auth\DTO;

class RegisterDto
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
