<?php
declare(strict_types=1);

namespace Src\Domain\Order\Contracts;

use Src\Domain\Order\Payment\PaymentData;

interface PaymentGateway
{
    public function paymentId(): string;

    public function configure(array $config): void;

    /**
     * Данные о платеже
     */
    public function data(PaymentData $data): PaymentGateway;

    /**
     *  Redirect url
     */
    public function url(): string;

    /**
     * Данные запроса, который приходит на эндпоинт-слушатель с сервера платежной системы
     */
    public function request(): mixed;

    public function response();

    /**
     * Проверка оплачен ли платеж
     */
    public function paid(): bool;

    /**
     * Провалидировать данные пришедшие с сервера платежной системы
     */
    public function validate(): bool;

    public function errorMessage(): string;
}
