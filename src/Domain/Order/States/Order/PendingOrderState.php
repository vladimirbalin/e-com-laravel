<?php
declare(strict_types=1);

namespace Src\Domain\Order\States\Order;

use Override;
use Src\Domain\Order\Enums\OrderStatusEnum;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    #[Override] public function canBeChanged(): bool
    {
        return true;
    }

    #[Override] public function value(): string
    {
        return OrderStatusEnum::PENDING->value;
    }

    #[Override] public function humanValue(): string
    {
        return 'В ожидании';
    }
}
