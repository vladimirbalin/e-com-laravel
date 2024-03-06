<?php
declare(strict_types=1);

namespace Src\Domain\Order\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Src\Domain\Order\Payment\Payment;

class PaymentStateChangedEvent
{
    use Dispatchable;

    public function __construct(public Payment $payment)
    {
    }
}
