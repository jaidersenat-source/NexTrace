<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight">Dashboard</h1>
                <p class="text-sm text-ink-muted mt-0.5">
                    {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                    <span class="mx-1.5 text-border">·</span>
                    <span class="font-medium text-ink">{{ auth()->user()->empresa->nombre }}</span>
                </p>
            </div>
            @can('create', App\Models\Activo::class)
            <a href="{{ route('activos.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5
                      bg-brand text-white font-display font-semibold text-sm rounded-xl
                      hover:bg-brand-light transition-all duration-200 hover:-translate-y-0.5
                      shadow-[0_4px_12px_rgba(15,76,219,0.25)] self-start sm:self-auto">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Registrar activo
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- ══════════════════════════════════
             FILA 1 — KPI cards
        ══════════════════════════════════ --}}
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

            @php
                $kpis = [
                    [
                        'label'   => 'Total activos',
                        'value'   => $metricas['activos']['total'],
                        'sub'     => '$' . number_format($metricas['activos']['valor_total'] ?? 0, 0, ',', '.') . ' en valor',
                        'icon'    => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
                        'iconBg'  => 'bg-brand/8',
                        'iconClr' => '#0F4CDB',
                        'trend'   => null,
                    ],
                    [
                        'label'   => 'En uso ahora',
                        'value'   => $metricas['uso']['en_uso_ahora'],
                        'sub'     => ($metricas['uso']['usos_hoy'] ?? 0) . ' usos hoy',
                        'icon'    => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
                        'iconBg'  => 'bg-red-50',
                        'iconClr' => '#EF4444',
                        'trend'   => null,
                    ],
                    [
                        'label'   => 'Disponibles',
                        'value'   => ($metricas['activos']['activos'] ?? 0) - ($metricas['uso']['en_uso_ahora'] ?? 0),
                        'sub'     => 'listos para usar',
                        'icon'    => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
                        'iconBg'  => 'bg-accent/8',
                        'iconClr' => '#00D4AA',
                        'trend'   => null,
                    ],
                    [
                        'label'   => 'Usuarios',
                        'value'   => $metricas['usuarios']['total'],
                        'sub'     => ($metricas['usuarios']['admins'] ?? 0) . ' admin · ' . (($metricas['usuarios']['total'] ?? 0) - ($metricas['usuarios']['admins'] ?? 0)) . ' empleados',
                        'icon'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                        'iconBg'  => 'bg-violet-50',
                        'iconClr' => '#7C3AED',
                        'trend'   => null,
                    ],
                ];
            @endphp

            @foreach($kpis as $kpi)
            <div class="bg-white border border-border rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between mb-4">
                    <p class="text-xs font-bold text-ink-faint uppercase tracking-wider leading-tight">
                        {{ $kpi['label'] }}
                    </p>
                    <div class="w-9 h-9 rounded-xl {{ $kpi['iconBg'] }} flex items-center justify-center shrink-0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="{{ $kpi['iconClr'] }}" stroke-width="1.75"
                             stroke-linecap="round" stroke-linejoin="round">
                            {!! $kpi['icon'] !!}
                        </svg>
                    </div>
                </div>
                <p class="font-display font-extrabold text-ink text-3xl sm:text-4xl leading-none tracking-tight">
                    {{ $kpi['value'] }}
                </p>
                <p class="text-xs text-ink-faint mt-2 leading-snug">{{ $kpi['sub'] }}</p>
            </div>
            @endforeach

        </div>

        {{-- ══════════════════════════════════
             FILA 2 — Gráfica + Estado
        ══════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Gráfica principal --}}
            <div class="lg:col-span-2 bg-white border border-border rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
                    <div>
                        <h2 class="font-display font-bold text-ink text-base">Actividad del año {{ now()->year }}</h2>
                        <p class="text-xs text-ink-faint mt-0.5">Activos registrados, mantenimientos y usos por mes</p>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-ink-muted">
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-1.5 rounded-full bg-brand inline-block"></span>Activos
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-1.5 rounded-full bg-amber-400 inline-block"></span>Mant.
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="w-3 h-1.5 rounded-full bg-accent inline-block"></span>Usos
                        </span>
                    </div>
                </div>
                <div class="relative">
                    <canvas id="chartActividad" height="85"></canvas>
                </div>
            </div>

            {{-- Dona estado activos --}}
            <div class="bg-white border border-border rounded-2xl p-6 shadow-sm">
                <h2 class="font-display font-bold text-ink text-base mb-5">Estado de activos</h2>

                <div class="flex items-center justify-center mb-5">
                    <div class="relative w-36 h-36">
                        <canvas id="chartEstado"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="font-display font-extrabold text-ink text-2xl leading-none">
                                {{ $metricas['activos']['total'] }}
                            </span>
                            <span class="text-[10px] text-ink-faint uppercase tracking-wider mt-0.5">total</span>
                        </div>
                    </div>
                </div>

                @php $total = max($metricas['activos']['total'], 1); @endphp
                <div class="space-y-3">
                    @foreach([
                        ['label' => 'Operativos',    'valor' => $metricas['activos']['activos'],       'color' => 'bg-brand',     'pct' => round($metricas['activos']['activos'] / $total * 100)],
                        ['label' => 'Mantenimiento', 'valor' => $metricas['activos']['mantenimiento'], 'color' => 'bg-amber-400', 'pct' => round($metricas['activos']['mantenimiento'] / $total * 100)],
                        ['label' => 'Dados de baja', 'valor' => $metricas['activos']['baja'],          'color' => 'bg-red-400',   'pct' => round($metricas['activos']['baja'] / $total * 100)],
                    ] as $item)
                    <div>
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="flex items-center gap-2 text-ink-muted">
                                <span class="w-2 h-2 rounded-full {{ $item['color'] }} shrink-0"></span>
                                {{ $item['label'] }}
                            </span>
                            <span class="font-semibold text-ink">{{ $item['valor'] }}
                                <span class="text-ink-faint font-normal">({{ $item['pct'] }}%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-surface rounded-full h-1.5 overflow-hidden">
                            <div class="{{ $item['color'] }} h-1.5 rounded-full transition-all duration-500"
                                 style="width:{{ $item['pct'] }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════
             FILA 3 — Tablas
        ══════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- En uso ahora --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-red-400 rounded-full animate-pulse"></span>
                        <h3 class="font-display font-bold text-sm text-ink">En uso ahora</h3>
                    </div>
                    <a href="{{ route('activos.index') }}" class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                        Ver todos →
                    </a>
                </div>
                <div class="divide-y divide-surface">
                    @forelse($equiposEnUso as $uso)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-surface/60 transition-colors">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-ink truncate">{{ $uso->activo?->nombre }}</p>
                            <p class="text-xs text-ink-faint truncate mt-0.5">
                                {{ $uso->user?->nombre }} {{ $uso->user?->apellido }}
                            </p>
                        </div>
                        <span class="text-xs font-medium text-ink-muted shrink-0 ml-3 tabular-nums">
                            {{ $uso->started_at->format('H:i') }}
                        </span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="w-10 h-10 rounded-xl bg-surface flex items-center justify-center mb-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.75"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                        <p class="text-xs text-ink-faint">Ningún equipo en uso</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Próximos mantenimientos --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <div class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <h3 class="font-display font-bold text-sm text-ink">Próximos mantenimientos</h3>
                    </div>
                    <a href="{{ route('mantenimientos.index') }}" class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                        Ver todos →
                    </a>
                </div>
                <div class="divide-y divide-surface">
                    @forelse($proximosMant as $mant)
                    <div class="flex items-center justify-between px-5 py-3.5 hover:bg-surface/60 transition-colors">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-ink truncate">{{ $mant->titulo }}</p>
                            <p class="text-xs text-ink-faint truncate mt-0.5">{{ $mant->activo?->nombre }}</p>
                        </div>
                        <div class="text-right shrink-0 ml-3">
                            <p class="text-xs font-bold tabular-nums
                               {{ ($mant->diasRestantes() ?? 99) <= 3 ? 'text-red-500' : 'text-ink-muted' }}">
                                {{ $mant->diasRestantes() }}d
                            </p>
                            <p class="text-[10px] text-ink-faint">{{ $mant->programado_at->format('d/m') }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="w-10 h-10 rounded-xl bg-surface flex items-center justify-center mb-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.75"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        </div>
                        <p class="text-xs text-ink-faint">Sin mantenimientos próximos</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Actividad reciente --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <div class="flex items-center gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        <h3 class="font-display font-bold text-sm text-ink">Actividad reciente</h3>
                    </div>
                    @if(auth()->user()->esAdmin())
                    <a href="{{ route('activity-logs.index') }}" class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                        Ver todo →
                    </a>
                    @endif
                </div>
                <div class="divide-y divide-surface">
                    @forelse($actividad as $log)
                    <div class="flex items-start gap-3 px-5 py-3.5 hover:bg-surface/60 transition-colors">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 mt-0.5
                            {{ $log->action === 'create' ? 'bg-accent/10' : ($log->action === 'delete' ? 'bg-red-50' : 'bg-brand/8') }}">
                            @if($log->action === 'create')
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            @elseif($log->action === 'delete')
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="3" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            @else
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round"><polyline points="23 4 23 11 16 11"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 11"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-ink leading-relaxed truncate">{{ $log->description }}</p>
                            <p class="text-[10px] text-ink-faint mt-0.5">
                                {{ $log->user?->nombre ?? 'Sistema' }}
                                <span class="mx-1">·</span>
                                {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="w-10 h-10 rounded-xl bg-surface flex items-center justify-center mb-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.75"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        </div>
                        <p class="text-xs text-ink-faint">Sin actividad registrada</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ══════════════════════════════════
             FILA 4 — Top activos + Tabla uso
        ══════════════════════════════════ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            {{-- Top activos más usados --}}
            @if(isset($metricas['uso']['top_activos']) && $metricas['uso']['top_activos']->count())
            <div class="bg-white border border-border rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <h2 class="font-display font-bold text-sm text-ink">Activos más utilizados</h2>
                </div>
                @php $maxUsos = $metricas['uso']['top_activos']->first()->total_usos; @endphp
                <div class="space-y-4">
                    @foreach($metricas['uso']['top_activos'] as $i => $uso)
                    <div class="flex items-center gap-3">
                        <span class="w-5 text-xs font-bold text-ink-faint text-center shrink-0 tabular-nums">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-semibold text-ink truncate">
                                    {{ $uso->activo?->nombre ?? 'Activo eliminado' }}
                                </span>
                                <span class="text-xs font-bold text-ink-muted shrink-0 ml-2 tabular-nums">
                                    {{ $uso->total_usos }}
                                </span>
                            </div>
                            <div class="w-full bg-surface rounded-full h-1.5 overflow-hidden">
                                <div class="h-1.5 rounded-full bg-brand transition-all duration-700"
                                     style="width:{{ ($uso->total_usos / $maxUsos) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tabla uso reciente (responsive) --}}
            <div class="{{ isset($metricas['uso']['top_activos']) && $metricas['uso']['top_activos']->count() ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-white border border-border rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <h2 class="font-display font-bold text-sm text-ink">Historial de uso reciente</h2>
                    <a href="{{ route('activos.index') }}" class="text-xs font-medium text-brand hover:text-brand-light transition-colors">
                        Ver todos →
                    </a>
                </div>

                {{-- Mobile: cards --}}
                <div class="sm:hidden divide-y divide-surface">
                    @forelse($equiposEnUso as $uso)
                    <div class="px-5 py-4 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-ink">{{ $uso->activo?->nombre }}</p>
                            @if($uso->ended_at)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-accent/10 text-accent">
                                    <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>Disponible
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-500">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse"></span>En uso
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-ink-faint">{{ $uso->user?->nombre }} {{ $uso->user?->apellido }}</p>
                        <p class="text-xs text-ink-faint tabular-nums">
                            {{ $uso->started_at->format('d/m H:i') }}
                            @if($uso->ended_at) → {{ $uso->ended_at->format('H:i') }} @endif
                        </p>
                    </div>
                    @empty
                    <div class="px-5 py-10 text-center text-xs text-ink-faint">Sin registros</div>
                    @endforelse
                </div>

                {{-- Desktop: table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-surface border-b border-border">
                                <th class="text-left px-5 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Activo</th>
                                <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Usuario</th>
                                <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Inicio</th>
                                <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Fin</th>
                                <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface">
                            @forelse($equiposEnUso as $uso)
                            <tr class="hover:bg-surface/50 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-brand/8 flex items-center justify-center shrink-0">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2">
                                                <rect x="2" y="3" width="20" height="14" rx="2"/>
                                                <line x1="8" y1="21" x2="16" y2="21"/>
                                                <line x1="12" y1="17" x2="12" y2="21"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-ink text-sm truncate max-w-[140px]">
                                            {{ $uso->activo?->nombre ?? '—' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-ink-muted text-sm">
                                    {{ $uso->user?->nombre }} {{ $uso->user?->apellido }}
                                </td>
                                <td class="px-4 py-3.5 text-ink-muted text-sm tabular-nums">
                                    {{ $uso->started_at->format('d/m H:i') }}
                                </td>
                                <td class="px-4 py-3.5 text-ink-muted text-sm tabular-nums">
                                    {{ $uso->ended_at ? $uso->ended_at->format('d/m H:i') : '—' }}
                                </td>
                                <td class="px-4 py-3.5">
                                    @if($uso->ended_at)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-accent/10 text-accent">
                                            <span class="w-1.5 h-1.5 bg-accent rounded-full shrink-0"></span>
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-500">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse shrink-0"></span>
                                            En uso
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-xs text-ink-faint">
                                    No hay registros de uso
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════
             Accesos rápidos
        ══════════════════════════════════ --}}
        <div class="bg-white border border-border rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] font-bold text-ink-faint uppercase tracking-wider mb-3">Acceso rápido</p>
            <div class="flex flex-wrap gap-2.5">
                @can('create', App\Models\Activo::class)
                <a href="{{ route('activos.create') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_2px_8px_rgba(15,76,219,0.20)]">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nuevo activo
                </a>
                @endcan
                <a href="{{ route('activos.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    Ver activos
                </a>
                <a href="{{ route('mantenimientos.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    Mantenimientos
                </a>
                @if(auth()->user()->esAdmin())
                <a href="{{ route('usuarios.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                    Usuarios
                </a>
                <a href="{{ route('reportes.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Reportes
                </a>
                <a href="{{ route('activity-logs.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-surface border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    Auditoría
                </a>
                @endif
            </div>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const colorPrimario = getComputedStyle(document.documentElement)
            .getPropertyValue('--color-primario').trim() || '#0F4CDB';
        const colorAccent = '#00D4AA';

        // ── Líneas múltiples ──────────────────────
        new Chart(document.getElementById('chartActividad'), {
            type: 'line',
            data: {
                labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                datasets: [
                    {
                        label: 'Activos',
                        data: @json($metricas['activos']['por_mes']),
                        borderColor: colorPrimario,
                        backgroundColor: colorPrimario + '18',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Mantenimientos',
                        data: @json($metricas['mantenimientos']['por_mes']),
                        borderColor: '#F59E0B',
                        backgroundColor: '#F59E0B18',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Usos',
                        data: @json($metricas['uso']['por_mes']),
                        borderColor: colorAccent,
                        backgroundColor: colorAccent + '18',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, color: '#9CA3AF', font: { size: 11 } },
                        grid: { color: '#F7F8FC' },
                        border: { display: false },
                    },
                    x: {
                        ticks: { color: '#9CA3AF', font: { size: 11 } },
                        grid: { display: false },
                        border: { display: false },
                    }
                }
            }
        });

        // ── Dona estado activos ───────────────────
        new Chart(document.getElementById('chartEstado'), {
            type: 'doughnut',
            data: {
                labels: ['Operativos', 'Mantenimiento', 'Baja'],
                datasets: [{
                    data: [
                        {{ $metricas['activos']['activos'] }},
                        {{ $metricas['activos']['mantenimiento'] }},
                        {{ $metricas['activos']['baja'] }},
                    ],
                    backgroundColor: [colorPrimario, '#F59E0B', '#F87171'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                cutout: '76%',
                plugins: { legend: { display: false }, tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed
                    }
                }}
            }
        });
    </script>

</x-app-layout>