<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use Src\Domain\Order\Actions\OrderCreateAction;
use Src\Domain\Order\Models\DeliveryMethod;
use Src\Domain\Order\Models\PaymentMethod;

class CheckoutController extends Controller
{
    public function __construct(
        private OrderCreateAction $orderCreateAction
    )
    {
    }

    public function index()
    {
        $cartItems = cart()->getCartItems();

        if ($cartItems->isEmpty()) {
            throw new BusinessException('Корзина пуста');
        }

        $paymentMethods = PaymentMethod::select(['id', 'title', 'redirect_to_pay'])->get();
        $deliveryMethods = DeliveryMethod::select(['id', 'title', 'price', 'with_address'])->get();

        return view('order.checkout', compact('cartItems', 'paymentMethods', 'deliveryMethods'));
    }

    public function handle(OrderFormRequest $request)
    {
        $order = $this->orderCreateAction->handle($request);
        dd($request->all());
        // принять данные с формы

        // способ доставки,
        // delivery-method[] = delivery-method-pickup/delivery-method-address

        // способ оплаты
        // payment-method[] = payment-method-1(nalichnimi)/payment-method-2(card)

        // создать заказ

        return to_route('home');
    }
}
