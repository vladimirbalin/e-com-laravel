<?php

declare(strict_types=1);

namespace Src\Domain\Order\Payment\Gateways;

use Exception;
use Illuminate\Http\JsonResponse;
use Src\Domain\Order\Contracts\PaymentGateway;
use Src\Domain\Order\Exceptions\PaymentProviderException;
use Src\Domain\Order\Payment\PaymentData;
use Src\Support\ValueObjects\Price;
use Throwable;
use YooKassa\Client;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Payment\Payment;
use YooKassa\Model\Payment\PaymentInterface;
use YooKassa\Model\Payment\PaymentStatus;
use YooKassa\Request\Payments\PaymentResponse;

class YooKassa implements PaymentGateway
{
    protected Client $client;

    protected PaymentData $paymentData;

    protected string $errorMessage;

    public function __construct(array $config)
    {
        $this->client = new Client();

        $this->configure($config);
    }

    public function paymentId(): string
    {
        return $this->paymentData->meta->get('payment_id_local');
    }

    public function configure(array $config): void
    {
        $this->client->setAuth(...$config);
    }

    public function data(PaymentData $data): self
    {
        $this->paymentData = $data;

        return $this;
    }

    public function request(): mixed
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    /**
     * @throws PaymentProviderException
     */
    public function response(): JsonResponse
    {
        try {
            $response = $this->client
                ->capturePayment(
                    $this->payload(),
                    $this->paymentObject()->getId(),
                    $this->idempotenceKey()
                );
        } catch (Throwable $e) {
            $this->errorMessage = $e->getMessage();

            throw new PaymentProviderException($e->getMessage());
        }

        return response()->json($response);
    }

    public function url(): string
    {
        try {
            $response = $this->client->createPayment(
                $this->payload(),
                $this->idempotenceKey()
            );

            return $response
                ->getConfirmation()
                ->getConfirmationUrl();
        } catch (Exception $e) {
            throw new PaymentProviderException($e->getMessage());
        }
    }

    /**
     * @throws PaymentProviderException
     */
    public function validate(): bool
    {
        $meta = $this->paymentObject()->getMetadata()->toArray();

        $this->data(new PaymentData(
                $this->paymentObject()->getId(),
                $this->paymentObject()->getDescription(),
                '',
                Price::make(
                    $this->paymentObject()->getAmount()->getIntegerValue(),
                    $this->paymentObject()->getAmount()->getCurrency(),
                ),
                collect($meta)
            )
        );

        return $this->paymentObject()->getStatus() === PaymentStatus::WAITING_FOR_CAPTURE;
    }

    /**
     * @throws PaymentProviderException
     */
    public function paid(): bool
    {
        return $this->paymentObject()->getPaid();
    }

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }

    private function payload(): array
    {
        return [
            'amount' => [
                'value' => $this->paymentData->amount->getPreparedValue(),
                'currency' => $this->paymentData->amount->getCurrency(),
            ],
            'capture' => false,
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $this->paymentData->returnUrl,
            ],
            'description' => $this->paymentData->description,
            'receipt' => [
                'customer' => [
                    'email' => $this->paymentData->meta->get('email') ?? 'test@mail.com'
                ],
                'items' => [
                    [
                        'quantity' => 1, // количество
                        'amount' => [
                            'value' => $this->paymentData->amount->getPreparedValue(),
                            'currency' => $this->paymentData->amount->getCurrency(),
                        ],
                        'vat_code' => 1,
                        'description' => $this->paymentData->description,
                        'payment_subject' => 'intellectual_activity',
                        'payment_mode' => 'full_payment'
                    ]
                ],
                'tax_system_code' => 1,
                'email' => $this->paymentData->meta->get('email'),
            ],
            'metadata' => $this->paymentData->meta->toArray(),
        ];
    }

    /**
     * @throws PaymentProviderException
     */
    private function paymentObject(): PaymentResponse|Payment|PaymentInterface
    {
        $request = $this->request();

        try {
            $notification = ($request['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                ? new NotificationSucceeded($request)
                : new NotificationWaitingForCapture($request);
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();

            throw new PaymentProviderException($e->getMessage());
        }

        return $notification->getObject();
    }

    private function idempotenceKey(): string
    {
        return uniqid('', true);
    }
}
