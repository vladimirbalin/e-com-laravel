<?php
declare(strict_types=1);

namespace Src\Domain\Order\Collections;

use Illuminate\Database\Eloquent\Collection;
use Src\Domain\Order\Models\OrderItem;

class OrderItemCollection extends Collection
{
    public function totalPrice(): int
    {
        return $this->sum(fn (OrderItem $orderItem) => $orderItem->totalPrice);
    }
}
