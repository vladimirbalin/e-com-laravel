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

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return OrderStatusEnum::PENDING->value;
    }

    public function humanValue(): string
    {
        return 'В ожидании';
    }
}
