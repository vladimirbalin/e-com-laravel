<?php
declare(strict_types=1);

namespace Src\Domain\Order\Processes;

use Closure;
use Override;
use Src\Domain\Order\Contracts\OrderProcessPipe;
use Src\Domain\Order\DTOs\CustomerDto;
use Src\Domain\Order\Models\Order;

class AssignCustomer implements OrderProcessPipe
{
    public function __construct(private CustomerDto $customerDto)
    {
    }

    #[Override] public function handle(Order $order, Closure $next)
    {
        $order->orderCustomers()->create([
            'first_name' => $this->customerDto->getFirstName(),
            'last_name' => $this->customerDto->getLastName(),
            'email' => $this->customerDto->getEmail(),
            'phone' => $this->customerDto->getPhone(),
            'address' => $this->customerDto->getAddress(),
            'city' => $this->customerDto->getCity(),
        ]);

        return $next($order);
    }
}
