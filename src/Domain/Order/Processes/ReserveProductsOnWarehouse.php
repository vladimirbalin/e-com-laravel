<?php

declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\Models\Order;

class ReserveProductsOnWarehouse implements OrderProcessPipe
{
    public function handle(Order $order, Closure $next)
    {
        foreach (cart()->getCartItems() as $cartItem) {
            $cartItem->product()->decrement('quantity', $cartItem->quantity);
        }

        return $next($order);
    }
}
