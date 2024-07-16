<?php

declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

readonly class SocialiteCallbackDto
{
    public function __construct(
        public int|string $id,
        public string     $name,
        public string     $email,
        public string     $password,
        public string     $driver,
    ) {}

    public static function from(
        int|string $id,
        string     $name,
        string     $email,
        string     $password,
        string     $driver
    ): self {
        return new self($id, $name, $email, $password, $driver);
    }
}
