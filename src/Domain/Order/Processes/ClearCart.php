<?php

declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\Models\Order;

class ClearCart implements OrderProcessPipe
{
    public function handle(Order $order, Closure $next)
    {
        cart()->truncate();

        return $next($order);
    }
}
