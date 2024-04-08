<?php

declare(strict_types=1);

namespace Src\Domain\Order\Exceptions;

class PaymentProcessException extends \Exception
{
    public static function paymentNotFound($id): self
    {
        return new self('Payment with id: ' . $id . ' was not found');
    }
}
