<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Src\Support\ValueObjects\Price;

class PriceCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param array<string, mixed> $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Price
    {
        if (is_null($value)) {
            return null;
        }
        // Product price 10000
        return new Price($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (! $value instanceof Price) {
            $value = new Price((int) ($value * 100));
        }

        return $value->getValue();
    }
}
