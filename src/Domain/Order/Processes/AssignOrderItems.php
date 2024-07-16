<?php

declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\Models\Order;

class AssignOrderItems implements OrderProcessPipe
{
    public function handle(Order $order, Closure $next)
    {
        $order->orderItems()->createMany(
            cart()->getCartItems()->map(function ($cartItem) {
                return [
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price
                ];
            })->toArray());

        return $next($order);
    }
}
