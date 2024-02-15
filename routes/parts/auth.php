<?php
declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginPage')->name('login.show');
        Route::get('/login-mail', 'showMailLoginPage')->name('login.mail.show');
        Route::post('/login', 'handle')->name('login.handle');

        Route::delete('/logout', 'logout')->name('logout')->withoutMiddleware('guest');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'showRegisterPage')->name('register.show');
        Route::get('/register-mail', 'showMailRegisterPage')->name('register.mail.show');
        Route::post('/register', 'handle')->name('register.handle');
    });

    Route::get('/forgot-password', [ForgotPasswordController::class, 'page'])->name('forgot-password.show');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'handle'])->name('forgot-password.handle');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'page'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'handle'])->name('password.update');

    Route::get('/auth/{driver}/redirect', [SocialAuthController::class, 'redirect'])->name('socialite.redirect');
    Route::get('/auth/{driver}/callback', [SocialAuthController::class, 'callback'])->name('socialite.callback');
});
