<?php
declare(strict_types=1);

namespace Src\Domain\Order\States\Order;

use Src\Domain\Order\Events\OrderStatusChangedEvent;
use Src\Support\State\State;

abstract class OrderState extends State
{
    public function getStateColumnName(): string
    {
        return 'status';
    }

    public function stateChangedEvent(): ?string
    {
        return OrderStatusChangedEvent::class;
    }

    public function color(): string
    {
        return match (static::class) {
            NewOrderState::class => 'white',
            PendingOrderState::class => 'purple',
            PaidOrderState::class => 'green',
            CancelledOrderState::class => 'pink',
        };
    }
}
