<?php

declare(strict_types=1);

namespace Src\Domain\Order\Payment;

use Illuminate\Support\Collection;
use Src\Support\ValueObjects\Price;

class PaymentData
{
    public function __construct(
        public string     $id,
        public string     $description,
        public string     $returnUrl,
        public Price      $amount,
        public Collection $meta,
    ) {
    }
}
