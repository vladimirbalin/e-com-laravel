<?php

declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\Models\Order;
use Src\Domain\Order\States\Order\PendingOrderState;

class ChangeStateToPending implements OrderProcessPipe
{
    public function handle(Order $order, Closure $next)
    {
        $order->status->transitionTo(new PendingOrderState($order));

        return $next($order);
    }
}
