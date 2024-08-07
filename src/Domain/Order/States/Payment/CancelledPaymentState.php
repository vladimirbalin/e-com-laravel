<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Override;
use Src\Domain\Order\Enums\PaymentStateEnum;
use Src\Support\State\State;

class CancelledPaymentState extends PaymentState
{
    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return PaymentStateEnum::CANCELLED->value;
    }

    public function humanValue(): string
    {
        return 'Отменен';
    }
}
