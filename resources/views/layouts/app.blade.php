<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="180x180"
          href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/apple-touch-icon.png')}})">
    <link rel="icon" type="image/png" sizes="32x32"
          href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16"
          href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/favicon-16x16.png')}}">
    <link rel="mask-icon" color="#1E1F43"
          href="{{\Illuminate\Support\Facades\Vite::asset('resources/images/safari-pinned-tab.svg')}}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body class="antialiased"  x-data="{ 'showTaskUploadModal': false, 'showTaskEditModal': false }" x-cloak>
@include('parts.header')

@yield('content')

@include('parts.footer')
@include('parts.mobile-menu')
@include('parts.modals')
</body>
</html>
