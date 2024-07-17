<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Override;
use Src\Domain\Order\Enums\PaymentStateEnum;
use Src\Support\State\State;

class PendingPaymentState extends PaymentState
{
    protected array $allowedTransitions = [
        CancelledPaymentState::class,
        PaidPaymentState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return PaymentStateEnum::PENDING->value;
    }

    public function humanValue(): string
    {
        return 'В ожидании';
    }
}
