<?php
declare(strict_types=1);

use App\Http\Controllers\CatalogController;
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


require __DIR__ . '/parts/auth.php';
