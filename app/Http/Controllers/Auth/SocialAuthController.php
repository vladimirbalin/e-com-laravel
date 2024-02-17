<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Src\Domain\Auth\Models\User;
use Throwable;

class SocialAuthController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable) {
            throw new DomainException("Драйвер $driver не поддерживается.");
        }
    }

    public function callback(string $driver)
    {
        try {
            $socialNetworkUser = Socialite::driver($driver)->user();
        } catch (Throwable) {
            throw new DomainException("Драйвер $driver не поддерживается.");
        }

        $user = User::updateOrCreate([
            'github_id' => $socialNetworkUser->getId(),
        ], [
            'name' => $socialNetworkUser->getName(),
            'email' => $socialNetworkUser->getEmail(),
            'password' => bcrypt(str()->random(20))
        ]);

        auth()->login($user);

        return to_route('home');
    }
}
