<?php
declare(strict_types=1);

namespace Src\Support\ValueObjects;

use InvalidArgumentException;

readonly class Email
{
    public function __construct(
        private string $email
    ) {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email $email is invalid email address");
        }
    }

    public static function create(string $email): static
    {
        return new static($email);
    }

    public function value(): string
    {
        return $this->email;
    }
}
