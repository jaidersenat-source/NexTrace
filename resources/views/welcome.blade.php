<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexTrace — Gestión Inteligente de Activos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-ink font-body antialiased">

{{-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ --}}
<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-border/80 transition-all duration-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 shrink-0">
            <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <span class="font-display font-extrabold text-lg text-ink tracking-tight">NexTrace</span>
        </a>

        {{-- Desktop links --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="#caracteristicas" class="text-sm font-medium text-ink-muted hover:text-brand transition-colors">Características</a>
            <a href="#como-funciona"   class="text-sm font-medium text-ink-muted hover:text-brand transition-colors">Cómo funciona</a>
        </div>

        {{-- Desktop auth --}}
        <div class="hidden md:flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all duration-200 hover:-translate-y-px shadow-[0_2px_8px_rgba(15,76,219,0.25)]">
                    Ir al panel
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-ink-muted hover:text-brand transition-colors px-3 py-2">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all duration-200 hover:-translate-y-px shadow-[0_2px_8px_rgba(15,76,219,0.25)]">
                    Comenzar
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endauth
        </div>

        {{-- Mobile hamburger --}}
        <button id="hamburger" aria-label="Abrir menú"
                class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg border border-border bg-transparent cursor-pointer shrink-0">
            <svg id="icon-menu"  width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg id="icon-close" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="hidden">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden md:hidden flex-col bg-white border-t border-border px-4 pb-5 pt-2">
        <a href="#caracteristicas" class="mobile-close block py-3 text-sm font-medium text-ink-muted border-b border-border hover:text-brand transition-colors">Características</a>
        <a href="#como-funciona"   class="mobile-close block py-3 text-sm font-medium text-ink-muted border-b border-border hover:text-brand transition-colors">Cómo funciona</a>
        <div class="flex flex-col gap-3 mt-4">
            @auth
                <a href="{{ route('dashboard') }}" class="flex justify-center items-center gap-2 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl">
                    Ir al panel
                </a>
            @else
                <a href="{{ route('login') }}" class="flex justify-center items-center py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-colors">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}" class="flex justify-center items-center py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl">
                    Comenzar gratis
                </a>
            @endauth
        </div>
    </div>
</nav>


{{-- ═══════════════════════════════════════════
     HERO
═══════════════════════════════════════════ --}}
<section class="relative min-h-screen flex items-center overflow-hidden pt-16
                bg-[radial-gradient(ellipse_70%_60%_at_10%_20%,rgba(15,76,219,0.10)_0%,transparent_60%),radial-gradient(ellipse_50%_50%_at_90%_80%,rgba(0,212,170,0.09)_0%,transparent_60%),#FFFFFF]
                bg-grid-dots bg-grid">

    {{-- Soft orbs --}}
    <div class="absolute -top-24 -right-24 w-[480px] h-[480px] rounded-full bg-brand/5 blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-28 -left-20 w-96 h-96 rounded-full bg-accent/5 blur-3xl pointer-events-none"></div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 py-20 lg:py-28 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- ── Left: copy ── --}}
            <div class="text-center lg:text-left">

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-brand/8 border border-brand/18 rounded-full text-xs font-semibold text-brand tracking-widest uppercase animate-fade-up-1">
                    <span class="w-1.5 h-1.5 bg-accent rounded-full animate-pulse-dot"></span>
                    Plataforma de activos empresariales
                </div>

                <h1 class="font-display font-extrabold text-ink leading-[1.05] tracking-[-0.03em]
                            text-4xl sm:text-5xl xl:text-[4.25rem]
                            mt-5 mb-5 animate-fade-up-2">
                    Control inteligente de activos con
                    <span class="bg-gradient-to-br from-brand via-brand-light to-accent bg-clip-text text-transparent">
                        trazabilidad en tiempo real
                    </span>
                </h1>

                <p class="text-ink-muted text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-up-3">
                    NexTrace centraliza tu inventario, automatiza auditorías y controla el uso de cada activo mediante QR — con roles, multiempresa y branding propio.
                </p>

                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 mt-8 justify-center lg:justify-start animate-fade-up-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-brand text-white font-display font-semibold text-base rounded-xl
                                  hover:bg-brand-light transition-all duration-200 hover:-translate-y-0.5
                                  shadow-[0_4px_16px_rgba(15,76,219,0.30)]">
                            Ir al panel
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-brand text-white font-display font-semibold text-base rounded-xl
                                  hover:bg-brand-light transition-all duration-200 hover:-translate-y-0.5
                                  shadow-[0_4px_16px_rgba(15,76,219,0.30)]">
                            Probar ahora — Es gratis
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#como-funciona"
                           class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-transparent text-ink font-display font-semibold text-base rounded-xl
                                  border border-border hover:border-brand hover:text-brand hover:bg-brand/4
                                  transition-all duration-200 hover:-translate-y-0.5">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                            Ver demo
                        </a>
                    @endauth
                </div>

                {{-- Stats pills --}}
                <div class="flex flex-wrap gap-3 mt-6 justify-center lg:justify-start animate-fade-up-4">
                    @foreach([
                        ['#00D4AA', 'M22 11.08V12a10 10 0 1 1-5.93-9.14M22 4 12 14.01 9 11.01', '100%',      'Multiempresa'],
                        ['#0F4CDB', 'M3 11h18v11H3zM7 11V7a5 5 0 0 1 10 0v4',                   'Auditado',  'Cada cambio'],
                        ['#7C3AED', 'M23 6 13.5 15.5 8.5 10.5 1 18M17 6h6v6',                   'Tiempo real','Dashboard vivo'],
                    ] as [$color, $path, $val, $label])
                    <div class="flex items-center gap-2.5 px-3.5 py-2 bg-white border border-border rounded-xl shadow-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $color }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="{{ $path }}"/>
                        </svg>
                        <span class="font-display font-bold text-sm text-ink">{{ $val }}</span>
                        <span class="text-xs text-ink-muted">{{ $label }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Right: dashboard mockup ── --}}
            <div class="relative w-full animate-fade-up-3">
                <div class="bg-white rounded-2xl border border-border shadow-[0_32px_80px_rgba(13,17,23,0.12)] overflow-hidden">
                    {{-- Titlebar --}}
                    <div class="flex items-center gap-2 px-4 py-3 bg-white border-b border-border">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FF5F57]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#FEBC2E]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#28C840]"></span>
                        <div class="flex-1 ml-2 h-5 bg-surface rounded-md max-w-[180px]"></div>
                    </div>

                    <div class="p-4 bg-surface space-y-3">
                        {{-- Stat cards --}}
                        <div class="grid grid-cols-3 gap-2.5">
                            @foreach([
                                ['Activos totales', '248', 'text-brand'],
                                ['En préstamo',     '37',  'text-violet-600'],
                                ['Disponibles',     '211', 'text-accent'],
                            ] as [$label, $val, $color])
                            <div class="bg-white rounded-xl p-3 border border-border">
                                <p class="text-[10px] font-semibold text-ink-muted uppercase tracking-wider mb-1 leading-tight">{{ $label }}</p>
                                <p class="font-display font-extrabold text-2xl {{ $color }} leading-none">{{ $val }}</p>
                            </div>
                            @endforeach
                        </div>

                        {{-- Mini table --}}
                        <div class="bg-white rounded-xl border border-border overflow-hidden">
                            <div class="flex items-center justify-between px-4 py-2.5 border-b border-border">
                                <span class="font-display font-bold text-xs text-ink">Activos recientes</span>
                                <span class="text-[10px] font-semibold text-brand">Ver todos →</span>
                            </div>
                            @foreach([
                                ['Laptop Dell XPS 15', 'NXT-0041', 'Disponible', 'bg-accent/10 text-accent'],
                                ['Proyector Epson',    'NXT-0038', 'En uso',     'bg-amber-100 text-amber-600'],
                                ['iPad Pro 12.9"',     'NXT-0035', 'Disponible', 'bg-accent/10 text-accent'],
                            ] as [$name, $code, $status, $badge])
                            <div class="flex items-center justify-between px-4 py-2.5 border-b border-surface last:border-0 gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-7 h-7 rounded-lg bg-brand/8 flex items-center justify-center shrink-0">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2">
                                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                                            <line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[11px] font-semibold text-ink truncate">{{ $name }}</p>
                                        <p class="text-[10px] text-ink-faint font-mono">{{ $code }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $badge }}">{{ $status }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Floating QR chip --}}
                <div class="absolute -bottom-5 -left-4 sm:-left-6 flex items-center gap-3 bg-white border border-border rounded-2xl px-4 py-3 shadow-[0_8px_32px_rgba(13,17,23,0.10)]">
                    <div class="w-9 h-9 rounded-xl bg-ink flex items-center justify-center shrink-0">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round">
                            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 14v3h3"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-sm text-ink leading-none mb-0.5">QR generado</p>
                        <p class="text-xs text-ink-muted">NXT-0042 · Ahora mismo</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     CARACTERÍSTICAS
═══════════════════════════════════════════ --}}
<section id="caracteristicas" class="py-20 sm:py-24 bg-surface px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.1em] uppercase text-brand mb-3">
                <span class="block w-5 h-0.5 bg-accent rounded-sm"></span>
                Características
            </span>
            <h2 class="font-display font-extrabold text-ink text-3xl sm:text-4xl xl:text-[2.75rem] tracking-tight leading-tight mb-4">
                Todo lo que tu empresa necesita
            </h2>
            <p class="text-ink-muted text-base sm:text-lg leading-relaxed max-w-xl mx-auto">
                Diseñado para equipos que gestionan activos físicos con seriedad y necesitan visibilidad total.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @php
                $features = [
                    [
                        'icon'  => '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
                        'title' => 'Gestión Multiempresa',
                        'desc'  => 'Cada empresa opera en su propio entorno aislado. Datos completamente separados, sin mezclas entre organizaciones.',
                        'slot'  => 'stats',
                        'data'  => [['∞','Empresas'],['3','Roles'],['100%','Aislado']],
                    ],
                    [
                        'icon'  => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 14v3h3"/>',
                        'title' => 'Control por Código QR',
                        'desc'  => 'Cada activo tiene su QR único. Escanea, registra préstamos y controla el uso en segundos desde cualquier dispositivo.',
                        'slot'  => 'pill',
                        'data'  => 'Registro instantáneo al escanear',
                    ],
                    [
                        'icon'  => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        'title' => 'Historial y Reportes',
                        'desc'  => 'Trazabilidad completa de cada movimiento. Quién tomó qué, cuándo y por cuánto tiempo. Exportable en cualquier momento.',
                        'slot'  => 'checklist',
                        'data'  => ['Historial de préstamos','Auditoría de cambios','Reportes exportables'],
                    ],
                    [
                        'icon'  => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
                        'title' => 'Roles y Permisos',
                        'desc'  => 'Super admin, administrador y empleado. Cada rol ve y puede hacer exactamente lo que le corresponde.',
                        'slot'  => 'tags',
                        'data'  => [['Super Admin','brand'],['Admin','violet'],['Empleado','accent']],
                    ],
                    [
                        'icon'  => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
                        'title' => 'Auditoría Automática',
                        'desc'  => 'Cada acción queda registrada: quién realizó el cambio, qué modificó y exactamente cuándo ocurrió.',
                        'slot'  => 'alert',
                        'data'  => 'Inmutable y a prueba de manipulación',
                    ],
                    [
                        'icon'  => '<circle cx="13.5" cy="6.5" r="1.5"/><path d="M17.5 3H21l-6 6 1.5 5.5L12 12l-5 6-1-5L1 9l5.5 1.5L13 4.5z"/>',
                        'title' => 'Branding Propio',
                        'desc'  => 'Logo, colores y nombre propios en tu panel. Tu empresa mantiene su identidad visual en todo momento.',
                        'slot'  => 'colors',
                        'data'  => ['#0F4CDB','#7C3AED','#00D4AA','#F59E0B','#EF4444','#0D1117'],
                    ],
                ];
            @endphp

            @foreach($features as $f)
            <div class="group relative bg-white border border-border rounded-2xl p-6 overflow-hidden
                        transition-all duration-300 hover:-translate-y-1
                        hover:shadow-[0_16px_48px_rgba(15,76,219,0.10)] hover:border-brand/15">

                {{-- Top accent bar --}}
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-brand to-accent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-t-2xl"></div>

                {{-- Icon --}}
                <div class="w-12 h-12 rounded-[14px] bg-gradient-to-br from-brand/10 to-accent/8 border border-brand/12 flex items-center justify-center mb-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        {!! $f['icon'] !!}
                    </svg>
                </div>

                <h3 class="font-display font-bold text-[1.0625rem] text-ink tracking-tight mb-2.5">{{ $f['title'] }}</h3>
                <p class="text-sm text-ink-muted leading-relaxed">{{ $f['desc'] }}</p>

                <div class="mt-5 pt-5 border-t border-border">
                    @if($f['slot'] === 'stats')
                        <div class="flex gap-5">
                            @foreach($f['data'] as $stat)
                            <div>
                                <p class="font-display font-extrabold text-xl text-brand leading-none">{{ $stat[0] }}</p>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-ink-muted mt-0.5">{{ $stat[1] }}</p>
                            </div>
                            @endforeach
                        </div>

                    @elseif($f['slot'] === 'pill')
                        <div class="flex items-center gap-2.5 bg-surface rounded-xl px-3.5 py-2.5">
                            <span class="w-2 h-2 bg-accent rounded-full animate-pulse-dot shrink-0"></span>
                            <span class="text-sm font-medium text-ink">{{ $f['data'] }}</span>
                        </div>

                    @elseif($f['slot'] === 'checklist')
                        <div class="flex flex-col gap-2">
                            @foreach($f['data'] as $item)
                            <div class="flex items-center gap-2 text-sm text-ink-muted">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                                {{ $item }}
                            </div>
                            @endforeach
                        </div>

                    @elseif($f['slot'] === 'tags')
                        <div class="flex flex-wrap gap-2">
                            @foreach($f['data'] as [$label, $color])
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold font-display
                                @if($color==='brand')  bg-brand/10   text-brand       border
                                @elseif($color==='violet') bg-violet-100 border-violet-200
                                @else border-accent/20
                                @endif">{{ $label }}</span>
                            @endforeach
                        </div>

                    @elseif($f['slot'] === 'alert')
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5" stroke-linecap="round">
                                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                            <span class="text-sm text-ink-muted">{{ $f['data'] }}</span>
                        </div>

                    @elseif($f['slot'] === 'colors')
                        <div class="flex gap-1.5 flex-wrap">
                            @foreach($f['data'] as $hex)
                            <span class="w-6 h-6 rounded-md border-2 border-white shadow-sm inline-block" style="background:{{ $hex }}"></span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     CÓMO FUNCIONA
═══════════════════════════════════════════ --}}
<section id="como-funciona" class="py-20 sm:py-24 bg-white px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">

        <div class="text-center mb-14">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold tracking-[0.1em] uppercase text-brand mb-3">
                <span class="block w-5 h-0.5 bg-accent rounded-sm"></span>
                Cómo funciona
            </span>
            <h2 class="font-display font-extrabold text-ink text-3xl sm:text-4xl xl:text-[2.75rem] tracking-tight leading-tight mb-4">
                De cero a control total en minutos
            </h2>
            <p class="text-ink-muted text-base sm:text-lg leading-relaxed max-w-lg mx-auto">
                Tres pasos simples para tener visibilidad completa de todos tus activos.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">

            @php
                $steps = [
                    [
                        'n'    => '01',
                        'icon' => '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
                        'title'=> 'Registra tus activos',
                        'desc' => 'Añade cada activo con su nombre, código, categoría, valor y ubicación. El sistema organiza todo automáticamente en tu inventario.',
                        'pill' => 'Importación masiva disponible',
                    ],
                    [
                        'n'    => '02',
                        'icon' => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3M17 14v3h3"/>',
                        'title'=> 'Genera QR automáticamente',
                        'desc' => 'NexTrace crea un código QR único por cada activo. Imprímelo y colócalo. Sin apps adicionales, funciona desde el navegador.',
                        'pill' => 'Imprimible en segundos',
                    ],
                    [
                        'n'    => '03',
                        'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        'title'=> 'Controla el uso en tiempo real',
                        'desc' => 'Escanea el QR para registrar préstamos y devoluciones. El dashboard muestra el estado de cada activo al instante.',
                        'pill' => 'Historial completo y exportable',
                    ],
                ];
            @endphp

            @foreach($steps as $i => $step)
            <div class="relative bg-white border border-border rounded-2xl p-7
                        transition-all duration-300 hover:-translate-y-1
                        hover:shadow-[0_16px_48px_rgba(15,76,219,0.08)]">

                {{-- Arrow connector — visible only on md+ between cards --}}
                @if($i < count($steps) - 1)
                <div class="hidden md:flex absolute top-8 -right-3.5 z-10
                            w-7 h-7 items-center justify-center
                            bg-white border border-border rounded-full shadow-sm">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.5" stroke-linecap="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </div>
                @endif

                {{-- Decorative number --}}
                <p class="font-display font-extrabold text-[3.5rem] leading-none tracking-[-0.05em] mb-4 select-none
                           bg-gradient-to-br from-brand/12 to-accent/8 bg-clip-text text-transparent">
                    {{ $step['n'] }}
                </p>

                {{-- Icon --}}
                <div class="w-12 h-12 rounded-[14px] bg-gradient-to-br from-brand/10 to-accent/8 border border-brand/12 flex items-center justify-center mb-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        {!! $step['icon'] !!}
                    </svg>
                </div>

                <h3 class="font-display font-bold text-[1.0625rem] text-ink tracking-tight mb-3">{{ $step['title'] }}</h3>
                <p class="text-sm text-ink-muted leading-relaxed mb-5">{{ $step['desc'] }}</p>

                <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand bg-brand/7 border border-brand/15 px-3 py-1.5 rounded-full">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $step['pill'] }}
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════
     CTA FINAL
═══════════════════════════════════════════ --}}
<section class="relative py-24 sm:py-32 px-4 sm:px-6 bg-ink overflow-hidden">
    {{-- Glow layers --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_70%_at_20%_50%,rgba(15,76,219,0.35)_0%,transparent_60%)] pointer-events-none"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_50%_60%_at_80%_50%,rgba(0,212,170,0.20)_0%,transparent_60%)] pointer-events-none"></div>

    <div class="relative max-w-3xl mx-auto text-center">

        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-accent/15 border border-accent/30 rounded-full text-[11px] font-bold text-accent tracking-[0.08em] uppercase mb-6">
            <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>
            Sin tarjeta de crédito
        </span>

        <h2 class="font-display font-extrabold text-white text-4xl sm:text-5xl xl:text-[3.25rem] tracking-tight leading-[1.08] mb-5">
            ¿Listo para tener<br class="hidden sm:block">
            el control total?
        </h2>

        <p class="text-white/60 text-base sm:text-lg leading-relaxed max-w-md mx-auto mb-10">
            Configura tu empresa, registra tus activos y empieza a gestionar con trazabilidad real. Todo en menos de 5 minutos.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch sm:items-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4
                      bg-white text-brand font-display font-bold text-base rounded-2xl
                      hover:bg-accent hover:text-ink transition-all duration-200 hover:-translate-y-0.5
                      shadow-[0_4px_24px_rgba(0,0,0,0.3)]">
                Crear cuenta gratis
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-8 py-4
                      bg-transparent text-white/85 font-display font-semibold text-base rounded-2xl
                      border border-white/25 hover:border-white/60 hover:text-white
                      transition-all duration-200 hover:-translate-y-0.5">
                Ya tengo cuenta
            </a>
        </div>

        <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 mt-8">
            @foreach(['Configuración en minutos','Sin tarjeta de crédito','Soporte incluido'] as $item)
            <div class="flex items-center gap-1.5 text-xs text-white/40">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $item }}
            </div>
            @endforeach
        </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ --}}
<footer class="bg-[#070C14] border-t border-white/5 px-4 sm:px-6 py-8">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        <a href="/" class="flex items-center gap-2 group">
            <div class="w-6 h-6 bg-brand rounded-md flex items-center justify-center">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <span class="font-display font-bold text-sm text-white/70 tracking-tight group-hover:text-white/90 transition-colors">NexTrace</span>
        </a>
        <p class="text-xs text-white/30 text-center sm:text-right">
            © {{ date('Y') }} NexTrace · Todos los derechos reservados
        </p>
    </div>
</footer>


<script>
    // ── Mobile menu ──────────────────────────
    const hamburger  = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconMenu   = document.getElementById('icon-menu');
    const iconClose  = document.getElementById('icon-close');

    hamburger.addEventListener('click', () => {
        const isOpen = mobileMenu.classList.contains('flex');
        mobileMenu.classList.toggle('hidden', isOpen);
        mobileMenu.classList.toggle('flex',  !isOpen);
        iconMenu.classList.toggle('hidden',  !isOpen);
        iconClose.classList.toggle('hidden',  isOpen);
    });

    document.querySelectorAll('.mobile-close').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
            iconMenu.classList.remove('hidden');
            iconClose.classList.add('hidden');
        });
    });

    // ── Navbar on scroll ─────────────────────
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.replace('bg-white/80', 'bg-white/96');
            navbar.classList.add('shadow-sm');
        } else {
            navbar.classList.replace('bg-white/96', 'bg-white/80');
            navbar.classList.remove('shadow-sm');
        }
    }, { passive: true });
</script>

</body>
</html>