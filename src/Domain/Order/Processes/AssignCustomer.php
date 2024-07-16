<?php

declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\DTOs\CustomerDto;
use Src\Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessPipe
{
    public function __construct(private CustomerDto $customerDto) {}

    public function handle(Order $order, Closure $next)
    {
        $order->orderCustomers()->create([
            'first_name' => $this->customerDto->first_name,
            'last_name' => $this->customerDto->last_name,
            'email' => $this->customerDto->email,
            'phone' => $this->customerDto->phone,
            'address' => $this->customerDto->address,
            'city' => $this->customerDto->city,
        ]);

        return $next($order);
    }
}
