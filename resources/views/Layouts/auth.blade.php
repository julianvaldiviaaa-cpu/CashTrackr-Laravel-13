@extends('Layouts.base')

@section('contents')
    <main class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-xl">

            {{-- Card --}}
            <div class="rounded-2xl border border-white/[0.06] bg-white/[0.02] px-8 py-10">

                {{-- Header --}}
                <div class="mb-8">
                    <h1 class="text-white font-bold text-xl lg:text-3xl tracking-tight mb-1">
                        @yield('title')
                    </h1>
                    <p class="text-white/30 text-xs">
                        @yield('subtitle', 'Bienvenido de nuevo a CashTrackr')
                    </p>
                </div>

                @yield('authContents')
            </div>

            {{-- Footer link --}}
            <p class="text-center text-white/25 text-xs mt-5">
                @yield('footerLink')
            </p>

        </div>
    </main>
@endsection
