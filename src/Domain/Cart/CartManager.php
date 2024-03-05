<?php
declare(strict_types=1);

namespace Src\Domain\Cart;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Src\Domain\Cart\Contracts\CartIdentityStorageContract;
use Src\Domain\Cart\Models\Cart;
use Src\Domain\Cart\Models\CartItem;
use Src\Domain\Cart\StorageIdentities\FakeSessionIdentityStorage;
use Src\Domain\Product\Models\Product;
use Src\Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        private readonly CartIdentityStorageContract $cartIdentityStorage
    ) {
    }

    public static function fake(): void
    {
        app()->bind(CartIdentityStorageContract::class, FakeSessionIdentityStorage::class);
    }

    public function add(Product $product, int $quantity = 1, array $optionValues = []): Model|Cart|Builder
    {
        $storageId = $this->cartIdentityStorage->get();
        $cart = Cart::updateOrCreate(['storage_id' => $storageId], [
            'user_id' => auth()->id()
        ]);

//        $cartItem = $cart->cartItems()->updateOrCreate([
//            'product_id' => $product->getKey(),
//            'string_option_values' => $this->sortedOptionValuesString($optionValues)
//        ], [
//            'quantity' => DB::raw('quantity + ' . $quantity),
//            'price' => $product->price,
//        ]);

        // надо дернуть карт айтем, у которого все оптион вэльюс находятся в $optionValues

        // либо создать новый карт айтем
        $cartItemQuery = $cart->cartItems()->where('product_id', $product->getKey());

        foreach ($optionValues as $optionValue) {
            $cartItemQuery->whereRelation('optionValues', 'option_values.id', $optionValue);
        };

        $cartItem = $cartItemQuery->first();

        if ($cartItem?->exists) {
            $cartItem->update(['price' => $product->price->getValue(), 'quantity' => $cartItem->quantity + $quantity]);
        } else {
            $cartItem = $cart->cartItems()->create([
                'product_id' => $product->getKey(),
                'quantity' => $quantity,
                'price' => $product->price->getValue()
            ]);
        }
        $cartItem->optionValues()->sync($optionValues);

        Cache::forget($this->cacheKey());

        return $cart;
    }

    public function updateId($old, $current): void
    {
        $toUpdate = ['storage_id' => $current];
        if (auth()->check()) {
            $toUpdate['user_id'] = auth()->id();
        }
        Cart::where('storage_id', $old)
            ->update($toUpdate);
    }

    private function sortedOptionValuesString(array $optionValues = []): string
    {
        sort($optionValues);
        return implode(';', $optionValues);
    }

    public function quantity(CartItem $cartItem, string $quantity): void
    {
        if ((int) $quantity < 1) {
            $this->delete($cartItem);
        }

        $cartItem->update(['quantity' => $quantity]);

        Cache::forget($this->cacheKey());
    }

    public function delete(CartItem $cartItem): void
    {
        $cartItem->delete();

        Cache::forget($this->cacheKey());
    }

    public function truncate(): void
    {
        if (! $this->getCart()) {
            return;
        }

        $cart = $this->getCart();
        $cart->cartItems()->delete();

        Cache::forget($this->cacheKey());
    }

    public function getCart(): Cart|false
    {
        return Cache::rememberForever($this->cacheKey(),
            fn () => Cart::with(['cartItems.optionValues.option', 'cartItems.product.properties'])
                ->when(auth()->check(),
                    fn (Builder $query) => $query->where('user_id', auth()->id()),
                    fn (Builder $query) => $query->where('storage_id', $this->cartIdentityStorage->get()))
                ->first() ?? false);
    }

    /**
     * Get the cart items.
     *
     * @return Collection<CartItem>
     */
    public function getCartItems(): Collection
    {
        if (! $this->getCart()) {
            return Collection::make();
        }

        return $this->getCart()->cartItems;
    }

    public function count(): int
    {
        if (! $this->getCart()) {
            return 0;
        }

        return $this->getCart()->cartItems->count();
    }

    public function getTotalPrice(): Price
    {
        if ($this->getCartItems()->isEmpty()) {
            return Price::make(0);
        }

        $totalPrice = $this->getCartItems()->totalPrice();

        return Price::make($totalPrice);
    }

    private function cacheKey(): string
    {
        if (auth()->check()) {
            return 'cart_' . auth()->id();
        }

        return 'cart_' . $this->cartIdentityStorage->get();
    }

    public function getAuth(): string
    {
        return $this->cartIdentityStorage->get();
    }
}
