<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/thumbnails/{dir}/{method}/{size}/{folder}/{file?}', ThumbnailController::class)
    ->name('thumbnail');


require __DIR__ . '/parts/auth.php';
