<?php

declare(strict_types=1);

namespace Src\Support\ValueObjects;

use InvalidArgumentException;

readonly class Email
{
    public function __construct(
        public string $value
    ) {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email $value is invalid email address");
        }
    }

    public static function fromString(string $email): static
    {
        return new static($email);
    }
}
