<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Src\Domain\Auth\DTO\RegisterDto;

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
            'email' => str($this->get('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }

    public function getDto(): RegisterDto
    {
        return new RegisterDto(
            $this->get('name'),
            $this->get('email'),
            $this->get('password'),
        );
    }
}
