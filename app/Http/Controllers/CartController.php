<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CartQuantityChangeRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Src\Domain\Cart\CartManager;
use Src\Domain\Cart\Contracts\CartIdentityStorageContract;
use Src\Domain\Cart\Models\Cart;
use Src\Domain\Cart\Models\CartItem;
use Src\Domain\Product\Models\Product;
use Src\Support\ValueObjects\Price;

class CartController extends Controller
{
    public function __construct(
        private CartManager $cartManager
    ) {
    }

    public function index()
    {
        $cart = $this->cartManager->get();
        $totalPrice = $this->cartManager->getTotalPrice();

        return view('cart.index', compact('cart', 'totalPrice'));
    }

    public function add(Product $product)
    {
        $this->cartManager->add($product);

        flash()->info("$product->title added to cart");

        return to_route('cart.index');
    }

    public function quantity(CartItem $cartItem, CartQuantityChangeRequest $request)
    {
        $this->cartManager->quantity($cartItem, $request->input('quantity'));

        return to_route('cart.index');
    }

    public function delete(CartItem $cartItem)
    {
        $this->cartManager->delete($cartItem);

        flash()->info("$cartItem->id removed to cart");
        return to_route('cart.index');
    }

    public function truncate(Cart $cart)
    {
        $this->cartManager->truncate();

        return to_route('cart.index');
    }
}
