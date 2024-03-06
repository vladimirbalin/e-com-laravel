<?php
declare(strict_types=1);

namespace Src\Support\ValueObjects;

use Illuminate\Support\Str;
use InvalidArgumentException;

readonly class UserName
{
    public function __construct(
        private string $name
    ) {
        if (Str::length($name) < 2) {
            throw new InvalidArgumentException("Name $name must have at least 2 symbols");
        }
    }

    public function value(): string
    {
        return $this->name;
    }
}
