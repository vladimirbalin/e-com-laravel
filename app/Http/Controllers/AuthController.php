<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function registerMail()
    {
        return view('auth.register-mail');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(LoginFormRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));

    }

    public function registerPost(RegisterFormRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect(route('home'));
    }

    public function loginMail()
    {
        return view('auth.login-mail');
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect(route('home'));
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordPost(ForgotPasswordFormRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            flash()->alert(__($status));
            return back();
        }

        flash()->info(__($status));
        return back();
    }

    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPasswordPost(ResetPasswordFormRequest $request)
    {
        $status = Password::reset(
            $request->only( 'email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        if ($status !== Password::PASSWORD_RESET) {
            flash()->alert(__($status));
            return back();
        }

        flash()->info(__($status));
        return to_route('login');
    }

    public function socialiteGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function socialiteGithubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(20))
        ]);

        auth()->login($user);

        return to_route('home');
    }
}
