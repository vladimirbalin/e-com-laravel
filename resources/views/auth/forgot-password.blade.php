@extends('layouts.auth')
@section('title')
    {{ config('app.name') . ' - ' . __('titles.forgot_password') }}
@endsection
@section('content')
    @if($message = flash()->get())
        <div class="{{ $message->getClass() }} p-5">
            {{ $message->getMessage() }}
        </div>
    @endif
    <x-forms.auth-form title="Восстановить пароль"
                       action="{{route('forgot-password-post')}}"
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

        <x-forms.primary-button>Отправить</x-forms.primary-button>

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
