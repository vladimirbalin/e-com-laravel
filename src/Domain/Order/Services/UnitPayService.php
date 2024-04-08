<?php

declare(strict_types=1);

namespace Src\Domain\Order\Services;

use CashItem;
use Src\Domain\Order\Exceptions\PaymentProcessException;
use UnitPay;

class UnitPayService
{
    public UnitPay $client;
    public string $publicKey;
    public array $data;

    public function __construct(
        $domain, $secretKey, $publicKey
    ) {
        $this->client = new UnitPay($domain, $secretKey);

        $this->publicKey = $publicKey;
    }

    public function createPayment(
        $id,
        $amount,
        string $description,
        string $currency,
        array $cashItems,
        string $email,
        $returnUrl,
        $returnUrlSecond,
        $phone
    ): string {
        $this->client->setCashItems($cashItems)
            ->setCustomerPhone($phone)
            ->setBackUrl($returnUrl)
            ->setCustomerEmail($email);

        return $this->client->form(
            $this->publicKey,
            $amount,
            $id,
            $description,
            $currency,
        );
    }

    public function cashItem(
        $description,
        $count,
        $amount
    ): CashItem {
        return new CashItem(
            $description, $count, $amount
        );
    }

    public function response(): string
    {
        if ($this->client->checkHandlerRequest()) {
//        if success return
            return $this->client->getSuccessHandlerResponse('success');
        } else {
//        if error return
            return $this->client->getErrorHandlerResponse('error');
        }
    }

    /**
     * @throws PaymentProcessException
     */
    public function isPaySuccess(): bool
    {
        if (! isset($_GET['params']['method'])) {
            throw PaymentProcessException::paymentNotFound();
        }

        return $_GET['params']['method'] === 'pay';
    }

    public function errorMessage(): string
    {
        return 'error msg here';
    }

    public function handle(int $value, string $currency): static
    {
        $this->data = ['value' => $value, 'currency' => $currency];
        return $this;
    }

    public function isSuccess(): bool
    {
        if (isset($_GET['params']['orderSum']) && isset($_GET['params']['orderCurrency'])) {
            $orderSum = $_GET['params']['orderSum'];
            $orderCurrency = $_GET['params']['orderCurrency'];

            if ($orderSum != $this->data['value'] || $orderCurrency != $this->data['currency']) {
                return false;
            }
        }
//
//        if (isset($_GET['method']) && $_GET['method'] == 'pay') {
//            return true;
//        }

        return false;

//        $response = $this->client->api('getPayment', ['paymentId' => ]);
//
//        foreach ($response as $k => $v) {
//            logger(sprintf("key: %s - value: %s", $k, $v));
//        }
//
//        if ($response->status == 'success') {
//            return true;
//        }
//
//        return false;
    }
}
