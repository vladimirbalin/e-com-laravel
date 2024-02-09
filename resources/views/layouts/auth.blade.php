<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180" href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/apple-touch-icon.png')}})">
    <link rel="icon" type="image/png" sizes="32x32" href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/favicon-16x16.png')}}">
    <link rel="mask-icon" href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/safari-pinned-tab.svg')}}" color="#1E1F43">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body class="antialiased">
<main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
    <div class="container">

        <!-- Page heading -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-block" rel="home">
                <img src="{{\Illuminate\Support\Facades\Vite::images('logo.svg')}}"
                     class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]"
                     alt="CutCode">
            </a>
        </div>

        <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
            @yield('content')
        </div>
    </div>
</main>
</body>
</html>
