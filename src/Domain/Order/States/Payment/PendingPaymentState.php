<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Override;
use Src\Domain\Order\Enums\PaymentStateEnum;
use Src\Support\State\State;

class PendingPaymentState extends PaymentState
{
    #[Override] public function canBeChanged(): bool
    {
        return true;
    }

    #[Override] public function value(): string
    {
        return PaymentStateEnum::PENDING->value;
    }

    #[Override] public function humanValue(): string
    {
        return 'В ожидании';
    }
}
