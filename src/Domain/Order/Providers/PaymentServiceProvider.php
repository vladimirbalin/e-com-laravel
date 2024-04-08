<?php

declare(strict_types=1);

namespace Src\Domain\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Order\Payment\Gateways\YooKassa;
use Src\Domain\Order\Payment\PaymentData;
use Src\Domain\Order\Payment\PaymentSystem;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        PaymentSystem::provider(new YooKassa(config('payment.providers.yookassa')));

        PaymentSystem::onSuccess(function () {
            cart()->truncate();
        });
        PaymentSystem::onCreating(function (PaymentData $paymentData) {
            return $paymentData;
        });
        PaymentSystem::onValidating(function () {
        });
    }
}
