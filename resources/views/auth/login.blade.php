@extends('layouts.auth')
@section('title')
    {{ config('app.name') . ' - ' . 'Login' }}
@endsection
@section('content')

    <x-forms.auth-form title="Вход в аккаунт">
        <ul class="space-y-3">
            <li>
                <a href="{{ route('login-mail') }}"
                   class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5">
                    <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" xmlns="http://www.w3.org/2000/svg"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M15.833.833H4.167A4.172 4.172 0 0 0 0 5v10a4.172 4.172 0 0 0 4.167 4.167h11.666A4.172 4.172 0 0 0 20 15V5A4.172 4.172 0 0 0 15.833.833ZM4.167 2.5h11.666a2.5 2.5 0 0 1 2.317 1.572l-6.382 6.383a2.506 2.506 0 0 1-3.536 0L1.85 4.072A2.5 2.5 0 0 1 4.167 2.5Zm11.666 15H4.167a2.5 2.5 0 0 1-2.5-2.5V6.25l5.386 5.383a4.172 4.172 0 0 0 5.894 0l5.386-5.383V15a2.5 2.5 0 0 1-2.5 2.5Z"/>
                    </svg>
                    <span class="grow text-xxs md:text-xs font-bold text-center">Почта</span>
                </a>
            </li>
            <li>
                <x-forms.gh/>
            </li>
        </ul>

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
