<?php
declare(strict_types=1);

namespace Src\Domain\Order\States;

use Src\Domain\Order\OrderStatusEnum;

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    #[\Override] public function canBeChanged(): bool
    {
        return true;
    }

    #[\Override] public function value(): string
    {
        return OrderStatusEnum::NEW->value;
    }

    #[\Override] public function humanValue(): string
    {
        return 'Новый';
    }
}
