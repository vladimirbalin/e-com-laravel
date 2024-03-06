<?php

declare(strict_types=1);

namespace Src\Domain\Order\States\Payment;

use Src\Domain\Order\Events\PaymentStateChangedEvent;
use Src\Support\State\State;

abstract class PaymentState extends State
{
    public function getStateColumnName(): string
    {
        return 'state';
    }

    public function stateChangedEvent(): string
    {
        return PaymentStateChangedEvent::class;
    }
}
