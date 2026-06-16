@extends('Layouts.auth')

@section('title')
    Iniciar Sesión
@endsection

@section('authContents')
    @if (session('error'))
        <x-alert type="error" :message="session('error')"/>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5" novalidate>
        @csrf

        <div class="flex flex-col gap-1.5">
            <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="email">
                Email
            </label>
            <input
                id="email"
                type="email"
                placeholder="tu@email.com"
                name="email"
                tabindex="1"
                value="{{ old('email') }}"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
            <x-input-error field="email"/>
        </div>

        <div class="flex flex-col gap-1.5">
            <div class="flex items-center justify-between">
                <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="password">
                    Contraseña
                </label>
                <a href="#" tabindex="3"
                   class="text-purple-secondary/60 hover:text-purple-secondary text-xs transition-colors duration-200">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
            <input
                id="password"
                type="password"
                placeholder="••••••••"
                name="password"
                tabindex="2"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
            <x-input-error field="password"/>
        </div>

        <button
            type="submit"
            tabindex="4"
            class="w-full bg-purple-principal hover:bg-purple-principal-hover py-3 rounded-xl text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-purple-principal/20 mt-2"
        >
            Iniciar Sesión
        </button>
    </form>
@endsection
