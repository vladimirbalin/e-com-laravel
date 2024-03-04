<?php
declare(strict_types=1);

namespace Src\Domain\Order\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Src\Domain\Order\Models\Order;
use Src\Domain\Order\States\OrderState;

class OrderStatusChangedEvent
{
    use Dispatchable;

    public function __construct(
        public Order      $order,
        public OrderState $current,
        public OrderState $next
    ) {
    }
}
