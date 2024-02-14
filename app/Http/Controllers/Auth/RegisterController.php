<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Src\Domain\Auth\Contracts\Register;

class RegisterController extends Controller
{
    public function showRegisterPage()
    {
        return view('auth.register');
    }

    public function showMailRegisterPage()
    {
        return view('auth.register-mail');
    }

    public function handle(RegisterFormRequest $request, Register $registerAction)
    {
        $registerAction($request->getDto());

        return redirect(route('home'));
    }
}
