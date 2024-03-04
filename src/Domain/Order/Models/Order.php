<?php
declare(strict_types=1);

namespace Src\Domain\Order\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Domain\Auth\Models\User;
use Src\Domain\Order\OrderStatusEnum;

class Order extends Model
{
    use HasFactory;

    protected $casts = ['total' => PriceCast::class];
    protected $guarded = [];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function deliveryMethod(): BelongsTo
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => OrderStatusEnum::from($value)->toState($this),
        );
    }
}
