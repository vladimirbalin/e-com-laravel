<?php
declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

class SocialiteCallbackDto
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
        private readonly string $driver,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDriver()
    {
        return $this->driver;
    }
}
