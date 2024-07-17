<?php
declare(strict_types=1);

namespace Src\Domain\Order\States\Order;

use Src\Domain\Order\Enums\OrderStatusEnum;

class CancelledOrderState extends OrderState
{
    protected array $allowedTransitions = [];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return OrderStatusEnum::CANCELLED->value;
    }

    public function humanValue(): string
    {
        return 'Отменен';
    }
}
