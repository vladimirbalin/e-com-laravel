<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guest();
    }

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
            'email' => str($this->email)
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
