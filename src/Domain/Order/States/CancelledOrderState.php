<?php
declare(strict_types=1);

namespace Src\Domain\Order\States;

use Src\Domain\Order\OrderStatusEnum;

class CancelledOrderState extends OrderState
{
    protected array $allowedTransitions = [];

    #[\Override] public function canBeChanged(): bool
    {
        return false;
    }

    #[\Override] public function value(): string
    {
        return OrderStatusEnum::CANCELLED->value;
    }

    #[\Override] public function humanValue(): string
    {
        return 'Отменен';
    }
}
