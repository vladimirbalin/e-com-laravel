<?php

declare(strict_types=1);

namespace Src\Domain\Order\Enums;

use Src\Domain\Order\Models\Payment;
use Src\Domain\Order\States\Payment\CancelledPaymentState;
use Src\Domain\Order\States\Payment\PaidPaymentState;
use Src\Domain\Order\States\Payment\PendingPaymentState;
use Src\Support\State\State;

enum PaymentStateEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';

    public function toState(Payment $payment): State
    {
        return match ($this) {
            self::PENDING => new PendingPaymentState($payment),
            self::PAID => new PaidPaymentState($payment),
            self::CANCELLED => new CancelledPaymentState($payment),
        };
    }
}
