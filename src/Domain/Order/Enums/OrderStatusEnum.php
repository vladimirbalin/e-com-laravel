<?php
declare(strict_types=1);

namespace Src\Domain\Order\Enums;

use Src\Domain\Order\Models\Order;
use Src\Domain\Order\States\CancelledOrderState;
use Src\Domain\Order\States\NewOrderState;
use Src\Domain\Order\States\OrderState;
use Src\Domain\Order\States\PaidOrderState;
use Src\Domain\Order\States\PendingOrderState;

enum OrderStatusEnum: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function toState(Order $order): OrderState
    {
        return match ($this) {
            self::NEW => new NewOrderState($order),
            self::PENDING => new PendingOrderState($order),
            self::PAID => new PaidOrderState($order),
            self::CANCELLED => new CancelledOrderState($order),
        };
    }
}
