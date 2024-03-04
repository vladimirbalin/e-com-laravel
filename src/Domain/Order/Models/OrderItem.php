<?php
declare(strict_types=1);

namespace Src\Domain\Order\Models;

use App\Casts\PriceCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Src\Domain\Order\Collections\OrderItemCollection;
use Src\Domain\Product\Models\OptionValue;
use Src\Domain\Product\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['price' => PriceCast::class];

    public function newCollection($models = []): OrderItemCollection
    {
        return new OrderItemCollection($models);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    protected function totalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => $this->price->getValue() * $this->quantity,
        );
    }
}
