<?php

declare(strict_types=1);

namespace Src\Domain\Auth\DTOs;

readonly class LoginDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
