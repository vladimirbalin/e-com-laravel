<?php

declare(strict_types=1);

namespace Src\Domain\Order\DTOs;

use App\Http\Requests\OrderFormRequest;

readonly class CustomerDto
{
    public function __construct(
        public int     $order_id,
        public ?string $first_name,
        public ?string $last_name,
        public ?int    $phone,
        public ?string $email,
        public ?string $city,
        public ?string $address,
    ) {}

    public static function fromRequest(OrderFormRequest $request, int $orderId): self
    {
        return new self(
            $orderId,
            $request->input('customer.first_name'),
            $request->input('customer.last_name'),
            $request->input('customer.phone'),
            $request->input('customer.email'),
            $request->input('customer.city'),
            $request->input('customer.address'),
        );
    }
}
