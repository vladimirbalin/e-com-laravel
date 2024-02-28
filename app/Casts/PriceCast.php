<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Src\Support\ValueObjects\Price;

class PriceCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (
            str(request()->fullUrl())->contains(['admin', 'livewire'])
        ) {
            return $value;
        }

        return new Price($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (
            str(request()->fullUrl())->contains(['admin', 'livewire'])
        ) {
            return $value;
        }

        if (! $value instanceof Price) {
            $value = new Price((int) $value);
        }

        return $value->getValue();
    }
}
