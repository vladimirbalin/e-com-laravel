<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Override;
use Src\Domain\Order\Enums\PaymentStateEnum;

class PaidPaymentState extends PaymentState
{
    protected array $allowedTransitions = [CancelledPaymentState::class];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return PaymentStateEnum::PAID->value;
    }

    public function humanValue(): string
    {
        return 'Оплачен';
    }
}
