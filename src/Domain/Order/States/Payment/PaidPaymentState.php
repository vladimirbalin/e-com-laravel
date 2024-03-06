<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Override;
use Src\Domain\Order\Enums\PaymentStateEnum;

class PaidPaymentState extends PaymentState
{
    #[Override] public function canBeChanged(): bool
    {
        return false;
    }

    #[Override] public function value(): string
    {
        return PaymentStateEnum::PAID->value;
    }

    #[Override] public function humanValue(): string
    {
        return 'Оплачен';
    }
}
