<?php

declare(strict_types=1);

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)
    ->name('home');

Route::get('/thumbnails/{dir}/{method}/{size}/{folder}/{file?}', ThumbnailController::class)
    ->name('thumbnail');

Route::get('/catalog/{category:slug?}', CatalogController::class)
    ->name('catalog.index')
    ->middleware(['catalog-view']);

Route::get('/products/{product:slug}', ProductController::class)
    ->name('products.show');

Route::controller(CartController::class)
    ->prefix('cart')
    ->name('cart.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{product}/add', 'add')->name('add');
        Route::post('/{cartItem}/quantity', 'quantity')->name('quantity');
        Route::delete('/{cartItem}', 'delete')->name('delete');
        Route::delete('/', 'truncate')->name('truncate');
    });

Route::controller(CheckoutController::class)
    ->prefix('checkout')
    ->name('checkout.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'handle')->name('handle');
    });

require __DIR__ . '/parts/auth.php';
