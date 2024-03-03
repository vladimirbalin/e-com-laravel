<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Src\Domain\Auth\Actions\LoginAction;
use Src\Domain\Auth\Actions\LogoutAction;
use Src\Domain\Auth\DTOs\LoginDto;

class LoginController extends Controller
{
    public function __construct(
        private LoginAction  $loginAction,
        private LogoutAction $logoutAction
    ) {
    }

    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function showMailLoginPage()
    {
        return view('auth.login-mail');
    }

    public function handle(LoginFormRequest $request)
    {
        $logined = $this->loginAction->handle(
            new LoginDto($request->input('email'), $request->input('password'))
        );

        if (! $logined) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('home'));
    }

    public function logout()
    {
        $this->logoutAction->handle();

        return redirect(route('home'));
    }
}
