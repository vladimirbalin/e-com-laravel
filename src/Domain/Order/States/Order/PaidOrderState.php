<?php
declare(strict_types=1);

namespace Src\Domain\Order\States\Order;

use Src\Domain\Order\Enums\OrderStatusEnum;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    #[\Override] public function canBeChanged(): bool
    {
        return true;
    }

    #[\Override] public function value(): string
    {
        return OrderStatusEnum::PAID->value;
    }

    #[\Override] public function humanValue(): string
    {
        return 'Оплачен';
    }
}
