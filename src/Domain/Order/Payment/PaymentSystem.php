<?php

declare(strict_types=1);

namespace Src\Domain\Order\Payment;

use Closure;
use Src\Domain\Order\Contracts\PaymentGateway;
use Src\Domain\Order\Enums\PaymentStateEnum;
use Src\Domain\Order\Exceptions\PaymentProcessException;
use Src\Domain\Order\Exceptions\PaymentProviderException;
use Src\Domain\Order\Models\Payment;
use Src\Domain\Order\Models\PaymentHistory;
use Src\Domain\Order\States\Payment\CancelledPaymentState;
use Src\Domain\Order\States\Payment\PaidPaymentState;
use Src\Domain\Order\Traits\PaymentsEvents;

class PaymentSystem
{
    use PaymentsEvents;

    protected static PaymentGateway $provider;

    /**
     * @throws PaymentProviderException
     */
    public static function provider(PaymentGateway|Closure $provider): void
    {
        if (is_callable($provider)) {
            $provider = call_user_func($provider);
        }

        if (! $provider instanceof PaymentGateway) {
            throw PaymentProviderException::providerRequired();
        }

        self::$provider = $provider;
    }

    /**
     * @throws PaymentProviderException
     */
    public static function create(PaymentData $paymentData): PaymentGateway
    {
        if (! self::$provider instanceof PaymentGateway) {
            throw PaymentProviderException::providerRequired();
        }

        Payment::query()->create([
            'payment_id' => $paymentData->meta->get('payment_id_local'),
            'payment_gateway' => get_class(self::$provider),
            'meta' => $paymentData->meta,
            'state' => PaymentStateEnum::PENDING->value
        ]);

        if (isset(self::$onCreating) && is_callable(self::$onCreating)) {
            $paymentData = call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider->data($paymentData);
    }

    /**
     * @throws PaymentProviderException
     */
    public static function validate(): PaymentGateway
    {
        if (! self::$provider instanceof PaymentGateway) {
            throw PaymentProviderException::providerRequired();
        }
        PaymentHistory::create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider),
        ]);

        if (is_callable(self::$onValidating)) {
            call_user_func(self::$onValidating);
        }

        if (self::$provider->validate() && self::$provider->paid()) {

            $payment = Payment::where('payment_id', self::$provider->paymentId())
                ->firstOr(function () {
                    throw PaymentProcessException::paymentNotFound(self::$provider->paymentId());
                });

            try {
                if (is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }
                logger(sprintf('%s line: %s, id: %d, status: %s', __CLASS__, __LINE__, $payment->id, $payment->state->value()));
                $payment->state->transitionTo(new PaidPaymentState($payment));
                logger(sprintf('%s line: %s, id: %d, status: %s', __CLASS__, __LINE__, $payment->id, $payment->state->value()));
            } catch (PaymentProcessException $e) {
                $payment->state->transitionTo(new CancelledPaymentState($payment));

                if (is_callable(self::$onError)) {
                    call_user_func(
                        self::$onError,
                        self::$provider->errorMessage() ?? $e->getMessage()
                    );
                }
            }
        }

        return self::$provider;
    }
}
