<?php

declare(strict_types=1);

namespace Src\Domain\Order\Payment\Gateways;

use Illuminate\Http\JsonResponse;
use Src\Domain\Order\Contracts\PaymentGateway;
use Src\Domain\Order\Exceptions\PaymentProcessException;
use Src\Domain\Order\Payment\PaymentData;
use Src\Domain\Order\Services\UnitPayService;

class UnitPay implements PaymentGateway
{
    protected UnitPayService $client;

    protected PaymentData $paymentData;

    protected string $errorMessage;

    public function __construct(array $config)
    {
        $this->configure($config);
    }

    public function configure(array $config): void
    {
        $this->client = new UnitPayService(...$config);
    }

    public function url(): string
    {
        return $this->client->createPayment(
            $this->paymentData->id,
            $this->paymentData->amount->getPreparedValue(),
            $this->paymentData->description,
            $this->paymentData->amount->getCurrency(),
            [
                $this->client->cashItem(
                    $this->paymentData->description,
                    1,
                    $this->paymentData->amount->getPreparedValue()
                )
            ],
            $this->paymentData->meta->get('email', ''),
            $this->paymentData->returnUrl,
            $this->paymentData->returnUrl,
            $this->paymentData->meta->get('phone', ''),
        );
    }

    public function request(): array
    {
        return request()->all();
    }

    public function validate(): bool
    {
        return $this->client->handle(
            $this->paymentData->amount->getPreparedValue(),
            $this->paymentData->amount->getCurrency()
        )->isSuccess();
    }

    /**
     * @throws PaymentProcessException
     */
    public function paid(): bool
    {
        return $this->client->isPaySuccess();
    }

    public function errorMessage(): string
    {
        return $this->client->errorMessage();
    }

    public function response(): JsonResponse
    {
        return response()->json(
            $this->client->response()
        );
    }

    public function paymentId(): string
    {
        return $this->paymentData->id;
    }

    public function data(PaymentData $data): PaymentGateway
    {
        $this->paymentData = $data;

        return $this;
    }
}
