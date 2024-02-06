@extends('layouts.auth')
@section('title')
    {{ config('app.name') . ' - ' . 'Login mail' }}
@endsection
@section('content')
    <x-forms.auth-form title="Вход в аккаунт"
                       action="{{route('login-post')}}"
                       method="POST">

        <x-forms.text-input
            name="email"
            :isError="$errors->has('email')"
            type="email"
            placeholder="{{__('E-mail')}}"
            value="{{ old('email') }}"/>
        @error('email')
        <x-forms.error>{{ $message }}</x-forms.error>
        @enderror

        <x-forms.text-input
            name="password"
            :isError="$errors->has('password')"
            type="password"
            placeholder="{{__('Password')}}"/>
        @error('password')
        <x-forms.error>{{ $message }}</x-forms.error>
        @enderror

        <x-forms.primary-button>Войти</x-forms.primary-button>

        <x-slot:links>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{route('forgot-password')}}"
                                                    class="text-white hover:text-white/70 font-bold">Забыли
                        пароль?</a></div>
                <div class="text-xxs md:text-xs"><a href="{{route('register')}}"
                                                    class="text-white hover:text-white/70 font-bold">Регистрация</a>
                </div>
            </div>
        </x-slot:links>
        <x-slot:politics>
            <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-20">
                <li>
                    <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium"
                       target="_blank" rel="noopener">Пользовательское соглашение</a>
                </li>
                <li class="hidden md:block">
                    <div class="h-full w-[2px] bg-white/20"></div>
                </li>
                <li>
                    <a href="#" class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium"
                       target="_blank" rel="noopener">Политика конфиденциальности</a>
                </li>
            </ul>
        </x-slot:politics>

    </x-forms.auth-form>

@endsection
