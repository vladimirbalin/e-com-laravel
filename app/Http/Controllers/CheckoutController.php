<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\BusinessException;
use App\Http\Requests\OrderFormRequest;
use Exception;
use Illuminate\Http\Request;
use Src\Domain\Order\Actions\OrderCreateAction;
use Src\Domain\Order\DTOs\CustomerDto;
use Src\Domain\Order\Models\DeliveryMethod;
use Src\Domain\Order\Models\PaymentMethod;
use Src\Domain\Order\Processes\AssignCustomer;
use Src\Domain\Order\Processes\AssignOrderItems;
use Src\Domain\Order\Processes\ChangeStateToPending;
use Src\Domain\Order\Processes\CheckRemainingProducts;
use Src\Domain\Order\Processes\ClearCart;
use Src\Domain\Order\Processes\OrderProcessesHandler;

class CheckoutController extends Controller
{
    public function __construct(
        private OrderCreateAction $orderCreateAction,
    ) {
    }

    public function index()
    {
        $cartItems = cart()->getCartItems();

        if ($cartItems->isEmpty()) {
            throw new Exception('Корзина пуста');
        }

        $paymentMethods = PaymentMethod::select(['id', 'title', 'redirect_to_pay'])->get();
        $deliveryMethods = DeliveryMethod::select(['id', 'title', 'price', 'with_address'])->get();

        return view('order.checkout', compact('cartItems', 'paymentMethods', 'deliveryMethods'));
    }

    public function handle(OrderFormRequest $request)
    {
        $order = $this->orderCreateAction->handle($request);

        (new OrderProcessesHandler($order))
            ->processes([
                // чекнуть что все товары есть в наличии
                new CheckRemainingProducts(),

                // добавить order customers записи в таблицу order customers
                // там доп инфа о покупателе(first name, last name, email, phone, address ...)
                new AssignCustomer(CustomerDto::fromRequest($request, $order->id)),
                new AssignOrderItems(),
                new ChangeStateToPending(),
                new CheckRemainingProducts(),
                new ClearCart()
            ])
            ->handle();

        return to_route('home');
    }
}
