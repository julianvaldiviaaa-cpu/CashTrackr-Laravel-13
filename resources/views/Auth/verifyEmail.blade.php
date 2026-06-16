@extends('Layouts.auth')

@section('title')
    Verifica tu Email
@endsection

@section('subtitle')
    Casi listo, un paso más
@endsection

@section('authContents')
    <div class="flex flex-col items-center text-center py-4">
        <div
            class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-2xl mb-5">
            ✉️
        </div>
        <p class="text-white/60 text-sm leading-relaxed mb-8">
            Tu cuenta fue creada con éxito. Te enviamos un correo de confirmación —
            revisa tu bandeja de entrada y haz clic en el enlace para activarla.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button
                type="submit"
                class="w-full bg-amber-500 hover:bg-amber-400 py-3 rounded-xl text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-amber-500/20"
            >
                Reenviar correo de verificación
            </button>
        </form>

        <p class="text-white/20 text-xs mt-4">
            Revisa también tu carpeta de spam si no lo encuentras.
        </p>
    </div>
@endsection

@section('footerLink')
    ¿Correo incorrecto?
    <a href="{{ route('login') }}" class="text-purple-secondary/70 hover:text-purple-secondary transition-colors">
        Volver al inicio →
    </a>
@endsection
