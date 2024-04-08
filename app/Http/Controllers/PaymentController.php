<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Src\Domain\Order\Payment\PaymentSystem;

class PaymentController extends Controller
{
    public function callback()
    {
        return PaymentSystem::validate()->response();
    }
}
