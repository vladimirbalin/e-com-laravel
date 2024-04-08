<?php

declare(strict_types=1);

namespace Src\Domain\Order\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Domain\Order\Enums\PaymentStateEnum;

class Payment extends Model
{
    use HasFactory;
    use HasUuids;

    protected $guarded = [];

    protected $casts = ['meta' => 'array'];

    public function uniqueIds(): array
    {
        return ['payment_id'];
    }

    protected function state(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => PaymentStateEnum::from($value)->toState($this),
        );
    }
}
