<?php

declare(strict_types=1);

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::controller(CheckoutController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'handle')->name('handle');
    });
