<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Src\Domain\Order\DTOs\CustomerDto;
use Src\Domain\Order\Rules\PhoneRule;

class OrderFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer.first_name' => ['required'],
            'customer.last_name' => ['required'],
            'customer.email' => ['required', 'email:dns'],
            'customer.phone' => ['required', new PhoneRule()],
            'customer.address' => ['sometimes'],
            'customer.city' => ['sometimes'],
            'create_account' => ['bool'],
            'password' => request()->boolean('create_account')
                ? ['required', 'confirmed', Password::defaults()]
                : ['sometimes'],
            'delivery_method' => ['required', 'exists:delivery_methods,id'],
            'payment_method' => ['required', 'exists:payment_methods,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'customer.first_name' => 'Имя',
            'customer.last_name' => 'Фамилия',
            'customer.email' => 'E-mail',
            'customer.phone' => 'Телефон',
            'customer.address' => 'Адрес',
            'customer.city' => 'Город',
            'customer.country' => 'Страна',
            'password' => 'Пароль',
            'delivery_method' => 'Способ доставки',
            'payment_method' => 'Способ оплаты',
        ];
    }
}
