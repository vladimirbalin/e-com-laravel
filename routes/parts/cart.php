<?php

declare(strict_types=1);

use App\Http\Controllers\CartController;

Route::controller(CartController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{product}/add', 'add')->name('add');
        Route::post('/{cartItem}/quantity', 'quantity')->name('quantity');
        Route::delete('/{cartItem}', 'delete')->name('delete');
        Route::delete('/', 'truncate')->name('truncate');
    });
