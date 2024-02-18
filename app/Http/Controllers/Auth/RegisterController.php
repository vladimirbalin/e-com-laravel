<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use Src\Domain\Auth\Contracts\Register;

class RegisterController extends Controller
{
    public function __construct(
        private readonly Register $registerAction
    ) {
    }

    public function showRegisterPage()
    {
        return view('auth.register');
    }

    public function showMailRegisterPage()
    {
        return view('auth.register-mail');
    }

    public function handle(RegisterFormRequest $request)
    {
        $this->registerAction->handle($request->getDto());

        return redirect(route('home'));
    }
}
