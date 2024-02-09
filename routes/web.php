<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', HomeController::class)->name('home');
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/login-mail', 'loginMail')->name('login-mail');
    Route::post('/login', 'loginPost')->name('login-post');

    Route::get('/register', 'register')->name('register');
    Route::get('/register-mail', 'registerMail')->name('register-mail');
    Route::post('/register', 'registerPost')->name('register-post');

    Route::get('/forgot-password', 'forgotPassword')->name('forgot-password')->middleware('guest');
    Route::post('/forgot-password', 'forgotPasswordPost')->name('forgot-password-post')->middleware('guest');
    Route::get('/reset-password/{token}', 'resetPassword')->name('password.reset')->middleware('guest');
    Route::post('/reset-password', 'resetPasswordPost')->name('password.update')->middleware('guest');

    Route::get('/auth/github/redirect', 'socialiteGithub')->name('socialite.github');
    Route::get('/auth/github/callback', 'socialiteGithubCallback')->name('socialite.github.callback');

    Route::delete('/logout', 'logout')->name('logout');
});

Route::get('mail', function () {
    $user = \App\Models\User::factory()->create();

    return (new \App\Notifications\WelcomeUserNotification())->toMail(new stdClass());
});
