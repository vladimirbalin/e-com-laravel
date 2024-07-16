<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Src\Domain\Auth\DTOs\RegisterDto;
use Src\Support\ValueObjects\Email;
use Src\Support\ValueObjects\UserName;

class RegisterFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'email' => 'required|email:dns|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            'email' => str($this->input('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
