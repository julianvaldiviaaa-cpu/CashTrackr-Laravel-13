@extends('Layouts.app')

@section('title')
    Administrador de Presupuestos impulsado por IA
@endsection

@section('contents')

    {{-- ══════════════════════════════════════════════
         HERO
    ══════════════════════════════════════════════ --}}
    <section class="relative bg-[#0A0A0F] overflow-hidden min-h-screen flex items-center">

        <div class="absolute inset-0 pointer-events-none"
             style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 60px 60px;">
        </div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[500px] rounded-full pointer-events-none"
             style="background: radial-gradient(ellipse at center, rgba(54,37,92,0.5) 0%, transparent 70%); filter: blur(60px);">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 py-24 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div class="space-y-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/[0.07]">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        <span class="text-amber-400 text-xs font-medium tracking-widest uppercase">Impulsado por IA</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight">
                        Controla tus gastos.<br>
                        Alcanza tus
                        <span style="background: linear-gradient(to right, #f59e0b, #a855f7);
                                 -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                                 background-clip: text;">
                        metas.
                    </span>
                    </h1>

                    <p class="text-white/45 text-lg leading-relaxed max-w-md">
                        CashTrackr te ayuda a gestionar tus presupuestos, registrar gastos con IA
                        y tomar mejores decisiones financieras — todo en un solo lugar.
                    </p>

                    <div class="flex flex-col sm:flex-row items-start gap-3">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-purple-principal hover:bg-purple-principal-hover text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-purple-principal/25">
                            Crear cuenta gratis
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-6 py-3 border border-white/[0.08] text-white/50 hover:text-white hover:border-white/20 text-sm rounded-xl transition-all duration-200">
                            Ya tengo cuenta
                        </a>
                    </div>

                    <div class="flex items-center gap-8 pt-4 border-t border-white/[0.06]">
                        <div>
                            <p class="text-white font-bold text-2xl tabular-nums">$0</p>
                            <p class="text-white/30 text-xs mt-0.5">Para comenzar</p>
                        </div>
                        <div class="w-px h-8 bg-white/[0.06]"></div>
                        <div>
                            <p class="text-white font-bold text-2xl tabular-nums">IA</p>
                            <p class="text-white/30 text-xs mt-0.5">Integrada</p>
                        </div>
                        <div class="w-px h-8 bg-white/[0.06]"></div>
                        <div>
                            <p class="text-white font-bold text-2xl tabular-nums">∞</p>
                            <p class="text-white/30 text-xs mt-0.5">Presupuestos</p>
                        </div>
                    </div>
                </div>

                {{-- Right — app screenshot + floating cards --}}
                <div class="relative hidden lg:block h-[560px]">

                    <div class="absolute left-0 top-1/2 -translate-y-1/2 z-10">
                        <img src="{{ asset('img/1.png') }}" alt="CashTrackr App" class="w-72 drop-shadow-2xl">
                    </div>

                    <div class="absolute right-0 top-8 z-20 w-64 rounded-2xl border border-white/[0.07] bg-[#0A0A0F]/80 backdrop-blur-md p-5 shadow-2xl">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-sm">🤖</div>
                            <span class="text-white/60 text-xs font-medium">Asistente IA</span>
                        </div>
                        <p class="text-white/70 text-xs leading-relaxed">
                            Estoy analizando tus gastos y encontré 3 formas de ahorrar este mes...
                        </p>
                    </div>

                    <div class="absolute right-4 bottom-8 z-20 w-64 rounded-2xl border border-white/[0.07] bg-[#0A0A0F]/80 backdrop-blur-md p-5 shadow-2xl">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-7 h-7 rounded-lg bg-amber-500/20 border border-amber-500/30 flex items-center justify-center text-sm">🎯</div>
                            <div>
                                <p class="text-white/60 text-xs font-medium">Meta · Remodelación</p>
                                <p class="text-amber-400 text-[10px]">En progreso</p>
                            </div>
                        </div>
                        <p class="text-white font-bold text-lg tabular-nums mb-2">$300 <span class="text-white/25 text-xs font-normal">/ $500</span></p>
                        <div class="h-1 w-full bg-white/[0.06] rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width:60%"></div>
                        </div>
                        <p class="text-right text-white/25 text-[10px] mt-1">60%</p>
                    </div>

                    <div class="absolute inset-0 pointer-events-none"
                         style="background: radial-gradient(ellipse at 60% 50%, rgba(54,37,92,0.35) 0%, transparent 65%); filter: blur(40px); z-index: 0;">
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         FEATURES
    ══════════════════════════════════════════════ --}}
    <section class="bg-[#0A0A0F] py-28 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="max-w-xl mb-16">
                <p class="text-purple-secondary/60 text-xs font-medium tracking-widest uppercase mb-3">Por qué CashTrackr</p>
                <h2 class="text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight mb-4">
                    Todo lo que necesitas para controlar tu dinero
                </h2>
                <p class="text-white/35 text-base leading-relaxed">
                    Desde presupuestos simples hasta análisis con IA — sin complicaciones.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $features = [
                        [
                            'icon'   => 'img/icon_01.svg',
                            'border' => 'border-amber-500/20',
                            'bg'     => 'bg-amber-500/[0.04]',
                            'title'  => 'text-amber-400',
                            'label'  => 'IA Avanzada',
                            'desc'   => 'Conversa en lenguaje natural para agregar gastos, consultar tu presupuesto y obtener insights personalizados.',
                        ],
                        [
                            'icon'   => 'img/icon_02.svg',
                            'border' => 'border-purple-secondary/20',
                            'bg'     => 'bg-purple-secondary/[0.06]',
                            'title'  => 'text-purple-secondary',
                            'label'  => 'Presupuestos',
                            'desc'   => 'Crea presupuestos generales o por meta. Visualiza en tiempo real cuánto llevas gastado y cuánto te queda.',
                        ],
                        [
                            'icon'   => 'img/icon_03.svg',
                            'border' => 'border-pink-500/20',
                            'bg'     => 'bg-pink-500/[0.04]',
                            'title'  => 'text-pink-400',
                            'label'  => 'Categorías',
                            'desc'   => 'Organiza cada gasto en su categoría. Comida, transporte, salud, entretenimiento y más.',
                        ],
                        [
                            'icon'   => 'img/icon_04.svg',
                            'border' => 'border-green-500/20',
                            'bg'     => 'bg-green-500/[0.04]',
                            'title'  => 'text-green-400',
                            'label'  => '100% Seguro',
                            'desc'   => 'Tus datos están protegidos y cifrados. Tu privacidad es nuestra prioridad absoluta.',
                        ],
                    ];
                @endphp

                @foreach($features as $f)
                    <div class="rounded-2xl border {{ $f['border'] }} {{ $f['bg'] }} p-6 flex flex-col gap-5">
                        <div class="w-14 h-14">
                            <img src="{{ asset($f['icon']) }}" alt="{{ $f['label'] }}" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-semibold {{ $f['title'] }} text-sm mb-1.5">{{ $f['label'] }}</h3>
                            <p class="text-white/35 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         FEATURE SPOTLIGHT — imagen 2 + lista
    ══════════════════════════════════════════════ --}}
    <section class="bg-[#0A0A0F] py-28 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- Imagen --}}
                <div class="relative">
                    <div class="absolute inset-0 pointer-events-none rounded-3xl"
                         style="background: radial-gradient(ellipse at 30% 50%, rgba(54,37,92,0.4) 0%, transparent 70%); filter: blur(50px);">
                    </div>
                    <img src="{{ asset('img/2.png') }}" alt="CashTrackr Dashboard" class="relative z-10 w-full rounded-2xl shadow-2xl border border-white/[0.06]">
                </div>

                {{-- Contenido --}}
                <div class="space-y-10">
                    <div>
                        <p class="text-purple-secondary/60 text-xs font-medium tracking-widest uppercase mb-3">Visualiza, entiende, decide</p>
                        <h2 class="text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight mb-4">
                            Todo en <span style="background: linear-gradient(to right, #f59e0b, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">un solo lugar</span>
                        </h2>
                        <p class="text-white/35 text-base leading-relaxed">
                            Organiza tus finanzas, visualiza tus gastos por categorías y mantén el control de tu presupuesto en tiempo real.
                        </p>
                    </div>

                    <div class="space-y-6">
                        @php
                            $spotlight = [
                                [
                                    'color' => '#a855f7',
                                    'bg'    => 'bg-purple-500/10 border-purple-500/20',
                                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>',
                                    'title' => 'Gráficas claras',
                                    'desc'  => 'Visualiza tus gastos con gráficos intuitivos por categoría, período y presupuesto.',
                                ],
                                [
                                    'color' => '#f97316',
                                    'bg'    => 'bg-orange-500/10 border-orange-500/20',
                                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
                                    'title' => 'Presupuestos flexibles',
                                    'desc'  => 'Crea presupuestos por categoría o meta y ajústalos cuando lo necesites.',
                                ],
                                [
                                    'color' => '#ec4899',
                                    'bg'    => 'bg-pink-500/10 border-pink-500/20',
                                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                                    'title' => 'Inteligencia Artificial',
                                    'desc'  => 'Agrega gastos, consulta tu presupuesto o registra tickets de compra con IA.',
                                ],
                                [
                                    'color' => '#84cc16',
                                    'bg'    => 'bg-lime-500/10 border-lime-500/20',
                                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>',
                                    'title' => 'Sincroniza todo',
                                    'desc'  => 'Tus datos siempre seguros y disponibles en todos tus dispositivos.',
                                ],
                            ];
                        @endphp

                        @foreach($spotlight as $item)
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-9 h-9 rounded-xl border {{ $item['bg'] }} flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="{{ $item['color'] }}" viewBox="0 0 24 24">
                                        {!! $item['icon'] !!}
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold text-sm mb-0.5">{{ $item['title'] }}</h3>
                                    <p class="text-white/35 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         HOW IT WORKS
    ══════════════════════════════════════════════ --}}
    <section class="bg-[#0A0A0F] py-28 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="max-w-xl mb-16">
                <p class="text-purple-secondary/60 text-xs font-medium tracking-widest uppercase mb-3">Así de simple</p>
                <h2 class="text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight">
                    Empieza en minutos
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $steps = [
                        ['n' => '01', 'title' => 'Crea tu presupuesto',  'desc' => 'Define un presupuesto general o por meta con el monto que quieras controlar.'],
                        ['n' => '02', 'title' => 'Registra tus gastos',  'desc' => 'Escríbele al asistente, sube un ticket o agrégalos manualmente en segundos.'],
                        ['n' => '03', 'title' => 'Toma el control',      'desc' => 'Visualiza en tiempo real cuánto llevas gastado y cuánto te queda disponible.'],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                    <div class="relative rounded-2xl border border-white/[0.06] bg-white/[0.02] p-6">
                        @if($i < count($steps) - 1)
                            <div class="hidden md:block absolute top-8 -right-2 z-10 text-white/10">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </div>
                        @endif
                        <p class="text-white/10 font-bold text-4xl tabular-nums mb-4 leading-none">{{ $step['n'] }}</p>
                        <h3 class="text-white font-semibold text-sm mb-2">{{ $step['title'] }}</h3>
                        <p class="text-white/35 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         PRICING TEASER
    ══════════════════════════════════════════════ --}}
    <section class="bg-[#0A0A0F] py-28 border-t border-white/[0.04]">
        <div class="max-w-7xl mx-auto px-6">

            <div class="max-w-xl mb-16">
                <p class="text-purple-secondary/60 text-xs font-medium tracking-widest uppercase mb-3">Planes</p>
                <h2 class="text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight mb-4">
                    Gratis para empezar.<br>Pro cuando lo necesites.
                </h2>
                <p class="text-white/35 text-base leading-relaxed">
                    Comienza sin costo y desbloquea el asistente IA cuando estés listo.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Free --}}
                <div class="rounded-2xl border border-white/[0.06] bg-white/[0.02] p-6 flex flex-col gap-4">
                    <div>
                        <p class="text-white/30 text-xs tracking-widest uppercase mb-2">Gratis</p>
                        <p class="text-white font-bold text-3xl">$0 <span class="text-white/25 text-sm font-normal">/ siempre</span></p>
                    </div>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Presupuestos ilimitados', 'Registro manual de gastos', 'Categorías', 'Sin tarjeta de crédito'] as $f)
                            <li class="flex items-center gap-2 text-white/45 text-sm">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-2.5 rounded-xl border border-white/[0.08] text-white/60 hover:text-white hover:border-white/20 text-sm font-medium text-center transition-all duration-200">
                        Comenzar gratis
                    </a>
                </div>

                {{-- Pro mensual --}}
                <div class="rounded-2xl border border-purple-secondary/25 bg-purple-secondary/[0.05] p-6 flex flex-col gap-4">
                    <div>
                        <p class="text-purple-secondary/70 text-xs tracking-widest uppercase mb-2">Pro Mensual</p>
                        <p class="text-white font-bold text-3xl">$99 <span class="text-white/25 text-sm font-normal">/ mes</span></p>
                    </div>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Todo lo del plan gratis', 'Asistente IA ilimitado', 'Escaneo de tickets', 'Cancela cuando quieras'] as $f)
                            <li class="flex items-center gap-2 text-white/60 text-sm">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-2.5 rounded-xl bg-purple-principal hover:bg-purple-principal-hover text-white text-sm font-medium text-center transition-all duration-200 shadow-lg shadow-purple-principal/20">
                        Comenzar mensual
                    </a>
                </div>

                {{-- Pro anual --}}
                <div class="relative rounded-2xl border border-amber-500/25 bg-amber-500/[0.04] p-6 flex flex-col gap-4">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500 text-white text-[11px] font-semibold shadow-lg shadow-amber-500/25 whitespace-nowrap">
                        ✦ 2 meses gratis
                    </span>
                    </div>
                    <div class="mt-2">
                        <p class="text-amber-400/70 text-xs tracking-widest uppercase mb-2">Pro Anual</p>
                        <p class="text-white font-bold text-3xl">$999 <span class="text-white/25 text-sm font-normal">/ año</span></p>
                        <p class="text-amber-400/60 text-xs mt-1">Equivale a $83/mes · Ahorras $189</p>
                    </div>
                    <ul class="space-y-2.5 flex-1">
                        @foreach(['Todo lo del plan mensual', '2 meses completamente gratis', 'Soporte prioritario', 'Mejor precio garantizado'] as $f)
                            <li class="flex items-center gap-2 text-white/60 text-sm">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $f }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-white text-sm font-medium text-center transition-all duration-200 shadow-lg shadow-amber-500/20">
                        Comenzar anual
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         CTA FINAL
    ══════════════════════════════════════════════ --}}
    <section class="bg-[#0A0A0F] py-24 border-t border-white/[0.04]">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/[0.07] mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                <span class="text-amber-400 text-xs font-medium tracking-widest uppercase">Comienza gratis</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-white tracking-tight leading-tight mb-4">
                Tu dinero, bajo control.
            </h2>
            <p class="text-white/35 text-base leading-relaxed mb-8">
                Crea tu cuenta gratis y empieza a registrar tus gastos hoy.
                Sin tarjeta de crédito, sin compromisos.
            </p>
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2 px-8 py-3.5 bg-purple-principal hover:bg-purple-principal-hover text-white font-semibold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-purple-principal/25">
                Crear cuenta gratis
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════════ --}}
    <footer class="bg-[#0A0A0F] border-t border-white/[0.04] py-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-white/20 text-xs">© {{ date('Y') }} CashTrackr. Todos los derechos reservados.</p>
            <div class="flex items-center gap-6">
                <a href="{{ route('login') }}" class="text-white/25 hover:text-white/50 text-xs transition-colors">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="text-white/25 hover:text-white/50 text-xs transition-colors">Crear cuenta</a>
                <a href="{{ route('plans') }}" class="text-white/25 hover:text-white/50 text-xs transition-colors">Planes</a>
            </div>
        </div>
    </footer>

@endsection
