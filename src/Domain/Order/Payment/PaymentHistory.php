<?php

declare(strict_types=1);

namespace Src\Domain\Order\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $casts = ['payload' => 'collection'];
}
