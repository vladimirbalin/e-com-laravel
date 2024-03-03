<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use DomainException;
use Laravel\Socialite\Facades\Socialite;
use Src\Domain\Auth\Actions\SocialiteCallbackAction;
use Src\Domain\Auth\DTOs\SocialiteCallbackDto;
use Throwable;

class SocialAuthController extends Controller
{
    public function __construct(private SocialiteCallbackAction $socialiteCallbackAction)
    {
    }

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

        $this->socialiteCallbackAction->handle(new SocialiteCallbackDto(
            $socialNetworkUser->getId(),
            $socialNetworkUser->getName(),
            $socialNetworkUser->getEmail(),
            bcrypt(str()->random(20)),
            $driver
        ));

        return to_route('home');
    }
}
