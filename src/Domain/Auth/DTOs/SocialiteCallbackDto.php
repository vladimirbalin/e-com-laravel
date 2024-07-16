<?php

declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

readonly class SocialiteCallbackDto
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $email,
        public string $password,
        public string $driver,
    ) {}
}
