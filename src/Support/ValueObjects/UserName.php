<?php

declare(strict_types=1);

namespace Src\Support\ValueObjects;

use Illuminate\Support\Str;
use InvalidArgumentException;

readonly class UserName
{
    public function __construct(
        public string $value
    ) {
        if (Str::length($value) < 2) {
            throw new InvalidArgumentException("Name $name must have at least 2 symbols");
        }
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }
}
