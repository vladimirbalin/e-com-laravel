<?php
declare(strict_types=1);

namespace Src\Domain\Order\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_numeric($value)) {
            $fail(__('validation.phone', ['attribute' => __('validation.attributes.phone')]));
        }
    }
}
