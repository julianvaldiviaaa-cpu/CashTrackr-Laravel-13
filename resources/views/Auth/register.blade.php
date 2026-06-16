@extends('Layouts.auth')

@section('title')
    Crear Cuenta
@endsection

@section('subtitle')
    Empieza a gestionar tus finanzas hoy
@endsection

@section('authContents')
    <form method="POST" action="{{ route('register.store') }}" class="mt-8 space-y-5" novalidate>
        @csrf

        <div class="flex flex-col gap-1.5">
            <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="name">
                Nombre
            </label>
            <input
                id="name"
                type="text"
                placeholder="Tu nombre"
                name="name"
                value="{{ old('name') }}"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
            <x-input-error field="name"/>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="email">
                Email
            </label>
            <input
                id="email"
                type="email"
                placeholder="tu@email.com"
                name="email"
                value="{{ old('email') }}"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
            <x-input-error field="email"/>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="password">
                Contraseña
            </label>
            <input
                id="password"
                type="password"
                placeholder="••••••••"
                name="password"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
            <x-input-error field="password"/>
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-white/50 text-xs font-medium tracking-widest uppercase" for="password_confirmation">
                Repetir Contraseña
            </label>
            <input
                id="password_confirmation"
                type="password"
                placeholder="••••••••"
                name="password_confirmation"
                class="w-full bg-white/[0.03] border border-white/[0.08] focus:border-purple-principal/60 focus:ring-1 focus:ring-purple-principal/30 rounded-xl px-4 py-3 text-white text-sm placeholder-white/20 outline-none transition-all duration-200"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-purple-principal hover:bg-purple-principal-hover py-3 rounded-xl text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-purple-principal/20 mt-2"
        >
            Crear Cuenta
        </button>
    </form>
@endsection

@section('footerLink')
    ¿Ya tienes cuenta?
    <a href="{{ route('login') }}" class="text-purple-secondary/70 hover:text-purple-secondary transition-colors">
        Iniciar sesión →
    </a>
@endsection
