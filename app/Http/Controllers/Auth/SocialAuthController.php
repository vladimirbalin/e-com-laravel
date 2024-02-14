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
        } catch (Throwable $e) {
            throw new DomainException('Драйвер не поддерживается. ' . $e->getMessage());
        }
    }

    public function callback(string $driver)
    {
        $socialNetworkUser = Socialite::driver($driver)->user();

        $user = User::updateOrCreate([
            'github_id' => $socialNetworkUser->id,
        ], [
            'name' => $socialNetworkUser->name,
            'email' => $socialNetworkUser->email,
            'password' => bcrypt(str()->random(20))
        ]);

        auth()->login($user);

        return to_route('home');
    }
}
