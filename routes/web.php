<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/thumbnails/{dir}/{method}/{size}/{file}', ThumbnailController::class)->name('thumbnail');
Route::get('/products', function (){
    $product = \App\Models\Product::inRandomOrder()->first();

    return $product->makeThumbnail('150x150');
})->name('products');

require __DIR__ . '/parts/auth.php';
