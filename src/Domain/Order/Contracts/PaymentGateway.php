<?php
declare(strict_types=1);

namespace Src\Domain\Order\Contracts;

interface PaymentGateway
{
    public function configure(array $config): void;

    public function url(): string;

    public function request(): mixed;

    public function response();

    public function paymentId(): string;

    public function paid(): bool;

    public function validate(): bool;

    public function errorMessage(): string;

    public function data(): PaymentGateway;
}
