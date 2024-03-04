<?php
declare(strict_types=1);

namespace Src\Domain\Order\Actions;

use App\Http\Requests\OrderFormRequest;
use Src\Domain\Auth\Contracts\Register;
use Src\Domain\Auth\DTOs\RegisterDto;
use Src\Domain\Order\Models\Order;

class OrderCreateAction
{
    public function handle(OrderFormRequest $orderFormRequest): Order
    {
        $registerAction = app(Register::class);

        $customer = $orderFormRequest->get('customer');
        if ($orderFormRequest->boolean('create_account')) {
            $registerAction->handle(
                new RegisterDto(
                    $customer->first_name,
                    $customer->email,
                    $orderFormRequest->get('password')
                )
            );
        }

        return  Order::create([
            'payment_method_id' => $orderFormRequest->get('payment_method'),
            'delivery_method_id' => $orderFormRequest->get('delivery_method'),

        ]);

    }
}
