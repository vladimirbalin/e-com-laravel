<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\OrderFormRequest;
use Exception;
use Illuminate\Support\Str;
use Src\Domain\Order\Actions\OrderCreateAction;
use Src\Domain\Order\DTOs\CustomerDto;
use Src\Domain\Order\Models\DeliveryMethod;
use Src\Domain\Order\Models\PaymentMethod;
use Src\Domain\Order\Payment\PaymentData;
use Src\Domain\Order\Payment\PaymentSystem;
use Src\Domain\Order\Processes\AssignCustomer;
use Src\Domain\Order\Processes\AssignOrderItems;
use Src\Domain\Order\Processes\ChangeStateToPending;
use Src\Domain\Order\Processes\CheckRemainingProducts;
use Src\Domain\Order\Processes\OrderProcessesHandler;

class CheckoutController extends Controller
{
    public function __construct(
        private OrderCreateAction $orderCreateAction,
    ) {
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        $cartItems = cart()->getCartItems();

        if ($cartItems->isEmpty()) {
            throw new Exception('Корзина пуста');
        }

        $paymentMethods = PaymentMethod::select(['id', 'title', 'redirect_to_pay'])->get();
        $deliveryMethods = DeliveryMethod::select(['id', 'title', 'price', 'with_address'])->get();

        return view('order.checkout',
            compact('cartItems', 'paymentMethods', 'deliveryMethods')
        );
    }


    public function handle(OrderFormRequest $request)
    {
        $order = $this->orderCreateAction->handle($request);

        $paymentIdLocal = (string) Str::uuid();
        $meta = collect(['email' => $request->input('customer.email'), 'payment_id_local' => $paymentIdLocal]);

        $paymentData = new PaymentData(
            $paymentIdLocal,
            'descr',
            route('home'),
            $order->total,
            $meta
        );

        (new OrderProcessesHandler($order))
            ->processes([
                new CheckRemainingProducts(),
                new AssignCustomer(CustomerDto::fromRequest($request, $order->id)),
                new AssignOrderItems(),
                new ChangeStateToPending(),
                new CheckRemainingProducts(),
            ])
            ->handle();

        return redirect(PaymentSystem::create($paymentData)->url());
    }
}
