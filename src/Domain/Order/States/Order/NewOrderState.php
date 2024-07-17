<?php
declare(strict_types=1);

namespace Src\Domain\Order\States\Order;

use Src\Domain\Order\Enums\OrderStatusEnum;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatusEnum::NEW->value;
    }

    public function humanValue(): string
    {
        return 'Новый';
    }
}
