<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NexTrace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Branding dinámico por empresa --}}
    @php
        $empresa = auth()->check()
            ? auth()->user()->empresa
            : (app()->bound('empresa.actual') ? app('empresa.actual') : null);
    @endphp
    @if($empresa)
    <style>
        :root {
            --color-primario:   {{ $empresa->color_primario   ?? '#0F4CDB' }};
            --color-secundario: {{ $empresa->color_secundario ?? '#3B6FF0' }};
            --color-sidebar:    {{ $empresa->color_sidebar    ?? '#0D1117' }};
        }
    </style>
    @else
    <style>
        :root {
            --color-primario:   #0F4CDB;
            --color-secundario: #3B6FF0;
            --color-sidebar:    #0D1117;
        }
    </style>
    @endif
</head>

<body class="h-full bg-surface font-body antialiased" x-data="{ sidebarOpen: false }">
<div class="min-h-screen flex">

    {{-- Global toast container --}}
    <div id="global-toast" role="status" aria-live="polite"
         class="fixed bottom-6 right-6 z-50 hidden max-w-sm w-full rounded-lg shadow-lg text-white px-4 py-3"
         style="display:none">
        <div id="global-toast-msg" class="text-sm"></div>
    </div>

    {{-- ═══════════════════════════════════
         SIDEBAR OVERLAY (mobile)
    ═══════════════════════════════════ --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-ink/60 backdrop-blur-sm lg:hidden"
        style="display:none;"
    ></div>

    {{-- ═══════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════ --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col
               bg-[var(--color-sidebar)] border-r border-white/8
               transform transition-transform duration-300 ease-in-out
               lg:relative lg:translate-x-0 lg:z-auto lg:shrink-0">

        {{-- Logo --}}
        <div class="h-16 flex items-center px-5 border-b border-white/8 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 min-w-0">
                @php $empresa = auth()->user()?->empresa; @endphp
                @if($empresa && $empresa->logo_url)
                    <img src="{{ $empresa->logoUrl() }}"
                         alt="{{ $empresa->nombre }}"
                         class="h-8 w-auto object-contain max-w-[140px]">
                @else
                    <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center shrink-0">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <span class="font-display font-extrabold text-white text-base tracking-tight truncate">
                        {{ $empresa->nombre ?? config('app.name', 'NexTrace') }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Nav links --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            @php
                $navItems = [
                    [
                        'route'  => 'dashboard',
                        'label'  => 'Dashboard',
                        'icon'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
                        'match'  => 'dashboard',
                    ],
                    [
                        'route'  => 'activos.index',
                        'label'  => 'Activos',
                        'icon'   => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
                        'match'  => 'activos.*',
                    ],
                    [
                        'route'  => 'scanner.index',
                        'label'  => 'Escáner QR',
                        'icon'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3"/><path d="M20 14v3h-3"/><path d="M14 20h3"/><path d="M20 20h.01"/>',
                        'match'  => 'scanner.*',
                    ],
                    [
                        'route'  => 'mantenimientos.index',
                        'label'  => 'Mantenimientos',
                        'icon'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
                        'match'  => 'mantenimientos.*',
                    ],
                    [
                        'route'  => 'reportes.index',
                        'label'  => 'Reportes',
                        'icon'   => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
                        'match'  => 'reportes.*',
                    ],
                    [
                        'route'  => 'activity-logs.index',
                        'label'  => 'Auditoría',
                        'icon'   => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
                        'match'  => 'activity-logs.*',
                    ],
                    [
                        'route'  => 'empresa.edit',
                        'label'  => 'Configuración',
                        'icon'   => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
                        'match'  => 'empresa.*',
                        'adminOnly' => true,
                    ],
                ];
            @endphp

            @foreach($navItems as $item)
                @if(!isset($item['adminOnly']) || (auth()->user() && (auth()->user()->esAdmin() || auth()->user()->esSuperAdmin())))
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                          {{ $active
                              ? 'bg-brand text-white shadow-[0_2px_8px_rgba(15,76,219,0.35)]'
                              : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                         stroke="{{ $active ? 'white' : 'currentColor' }}"
                         stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"
                         class="shrink-0 {{ $active ? 'opacity-100' : 'opacity-60 group-hover:opacity-100' }}">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['label'] }}
                    @if($active)
                    <span class="ml-auto w-1.5 h-1.5 bg-accent rounded-full"></span>
                    @endif
                </a>
                @endif
            @endforeach

            {{-- Super admin link --}}
            @if(auth()->user() && auth()->user()->esSuperAdmin())
            <div class="pt-3 mt-3 border-t border-white/8">
                <p class="px-3 mb-2 text-[10px] font-bold text-white/25 uppercase tracking-[0.1em]">Super Admin</p>
                <a href="{{ route('super-admin.dashboard') }}"
                   class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/55 hover:text-white hover:bg-white/8 transition-all duration-150">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 opacity-60 group-hover:opacity-100">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Panel Super Admin
                </a>
            </div>
            @endif
        </nav>

        {{-- User mini-card at bottom --}}
        <div class="shrink-0 px-3 py-4 border-t border-white/8">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-white/5">
                <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center shrink-0 text-white font-display font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-white text-xs font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-white/40 text-[11px] truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════════════════════
         MAIN WRAPPER
    ═══════════════════════════════════ --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- ─── TOP NAV ─── --}}
        @include('layouts.navigation')

        {{-- ─── PAGE HEADING ─── --}}
        @isset($header)
        <div class="bg-white border-b border-border px-4 sm:px-6 lg:px-8 py-5">
            <div class="max-w-7xl mx-auto">
                {{ $header }}
            </div>
        </div>
        @endisset

        {{-- ─── MAIN CONTENT ─── --}}
        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

</div>
</body>
<script>
    window.showToast = function(message, type = 'success', timeout = 4000) {
        const el = document.getElementById('global-toast');
        const msg = document.getElementById('global-toast-msg');
        if (!el || !msg) return;
        msg.textContent = message;
        el.style.display = 'block';
        el.classList.remove('bg-green-500','bg-red-500','bg-blue-500');
        if (type === 'error') el.classList.add('bg-red-500');
        else if (type === 'info') el.classList.add('bg-blue-500');
        else el.classList.add('bg-green-500');
        el.animate([{ opacity: 0, transform: 'translateY(8px)' }, { opacity: 1, transform: 'translateY(0)' }], { duration: 240, easing: 'ease-out' });
        setTimeout(() => {
            el.animate([{ opacity: 1, transform: 'translateY(0)' }, { opacity: 0, transform: 'translateY(8px)' }], { duration: 240, easing: 'ease-in' });
            setTimeout(() => el.style.display = 'none', 240);
        }, timeout);
    };

    // Show server-flashed success/error on load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            window.showToast(@json(session('success')),'success');
        @endif
        @if(session('error'))
            window.showToast(@json(session('error')),'error');
        @endif
    });
</script>
</html>