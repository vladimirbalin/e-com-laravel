<?php

declare(strict_types=1);

namespace Src\Domain\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domain\Order\Exceptions\PaymentProviderException;
use Src\Domain\Order\Models\Payment;
use Src\Domain\Order\Payment\Gateways\YooKassa;
use Src\Domain\Order\Payment\PaymentData;
use Src\Domain\Order\Payment\PaymentSystem;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    /**
     * @throws PaymentProviderException
     */
    public function boot(): void
    {
        PaymentSystem::provider(new YooKassa(config('payment.providers.yookassa')));

        PaymentSystem::onSuccess(function (Payment $payment) {
            logger('----------------------------------------------------------');
            cart()->truncate();
        });
        PaymentSystem::onCreating(function (PaymentData $paymentData) {
            return $paymentData;
        });
        PaymentSystem::onValidating(function () {
        });
    }
}
