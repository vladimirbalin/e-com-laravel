<?php

declare(strict_types=1);

namespace Src\Domain\Order\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $casts = ['payload' => 'collection'];

    protected $guarded = [];
}
