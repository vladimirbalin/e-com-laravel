@extends('layouts.auth')
@section('title')
    {{ config('app.name') . ' - ' . __('titles.reset_password') }}
@endsection
@section('content')
    @if($message = flash()->get())
        <div class="{{ $message->getClass() }} p-5">
            {{ $message->getMessage() }}
        </div>
    @endif
    <x-forms.auth-form title="Обновить пароль"
                       action="{{route('password.update')}}"
                       method="POST">

        <x-forms.text-input
            name="token"
            :isError="$errors->has('email')"
            hidden
            type="text"
            value="{{request('token')}}"/>

        <x-forms.text-input
            name="email"
            :isError="$errors->has('email')"
            type="email"
            placeholder="{{__('E-mail')}}"
            value="{{request('email')}}"/>
        @error('email')
        <x-forms.error>{{ $message }}</x-forms.error>
        @enderror
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <x-forms.text-input
                    name="password"
                    :isError="$errors->has('password')"
                    type="password"
                    placeholder="{{__('Password')}}"/>
                @error('password')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror
            </div>
            <div>
                <x-forms.text-input
                    name="password_confirmation"
                    :isError="$errors->has('password_confirmation')"
                    type="password"
                    placeholder="{{__('Password confirmation')}}"/>
                @error('password_confirmation')
                <x-forms.error>{{ $message }}</x-forms.error>
                @enderror
            </div>
        </div>

        <x-forms.primary-button>Обновить</x-forms.primary-button>

        <x-slot:links>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('register') }}"
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
