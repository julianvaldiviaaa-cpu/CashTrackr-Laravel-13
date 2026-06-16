<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>{{ config('app.name', 'CashTrackr') }} - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/.vite/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
</head>

<body class="bg-[#0E0E0E] text-purple-secondary">
<header class="bg-[#36255C] py-5 ">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center lg:justify-between">
        <div class="w-full max-w-100">
            <img src="{{ asset('Img/logo.svg') }}" alt="logo" class="w-full block"/>
        </div>
        <nav>

            @auth
                <div class="flex flex-col items-center lg:flex-row gap-4">
                    <x-subscription-badge/>
                    <x-dropdown-menu/>
                </div>
            @else
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-white font-bold uppercase p-2 ">Iniciar Sesion</a>
                    <a href="{{ route('register') }}"
                       class="font-bold uppercase border-2 border-amber-500 px-5 py-2 text-amber-500 ">Crear Cuenta</a>
                @endif
            @endauth
        </nav>
    </div>
</header>

@if (session("success"))
    <div class="max-w-5xl mx-auto">
        <x-alert :message="session('success')"/>
    </div>
@endif

@yield('contents')
</body>

</html>
