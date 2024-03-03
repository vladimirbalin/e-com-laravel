<?php
declare(strict_types=1);

namespace Src\Domain\Cart\Collections;

use Illuminate\Database\Eloquent\Collection;
use Src\Domain\Cart\Models\CartItem;

class CartItemCollection extends Collection
{
    public function totalPrice(): int
    {
        return $this->sum(fn (CartItem $cartItem) => $cartItem->totalPrice);
    }
}
