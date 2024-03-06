<?php
declare(strict_types=1);

namespace Src\Domain\Order\DTOs;

use App\Http\Requests\OrderFormRequest;

class CustomerDto
{
    public function __construct(
        private int     $order_id,
        private ?string $first_name,
        private ?string $last_name,
        private ?int    $phone,
        private ?string $email,
        private ?string $city,
        private ?string $address,
    ) {
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public static function fromRequest(OrderFormRequest $request, int $orderId): self
    {
        return new self(
            $orderId,
            $request->get('customer.first_name'),
            $request->get('customer.last_name'),
            $request->get('customer.phone'),
            $request->get('customer.email'),
            $request->get('customer.city'),
            $request->get('customer.address'),
        );
    }

}
