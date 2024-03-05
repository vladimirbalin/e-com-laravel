<?php
declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Override;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\Exceptions\OrderProcessException;
use Src\Domain\Order\Models\Order;

class CheckRemainingProducts implements OrderProcessPipe
{
    #[Override] public function handle(Order $order, Closure $next)
    {
        foreach (cart()->getCartItems() as $cartItem) {
            if ($cartItem->product->quantity < $cartItem->quantity) {
                throw new OrderProcessException('Not enough products');
            }
        }

        return $next($order);
    }
}
