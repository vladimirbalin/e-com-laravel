<?php
declare(strict_types=1);

use App\Http\Controllers\PaymentController;

Route::post('/listen', [PaymentController::class, 'callback'])->name('payments.listener');
