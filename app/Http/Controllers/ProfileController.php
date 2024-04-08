<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Src\Domain\Order\Models\Order;

class ProfileController extends Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->with('orderItems.product')->get();

        return view('profile.orders', compact('orders'));
    }
}
