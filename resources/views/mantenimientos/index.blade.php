<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center shadow-md shadow-indigo-200">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight leading-none">Mantenimientos</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Control y seguimiento de activos</p>
                </div>
            </div>
            @if(auth()->user()->esAdmin())
                <a href="{{ route('mantenimientos.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all duration-150 shadow-sm shadow-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Programar mantenimiento
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-7 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

        @include('partials.alert')

        {{-- KPIs --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            @php
                $kpis = [
                    ['label' => 'Total',       'valor' => $metricas['total'],       'from' => 'from-slate-500',   'to' => 'to-slate-700',   'ring' => 'ring-slate-100',   'text' => 'text-slate-700',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['label' => 'Pendientes',  'valor' => $metricas['pendientes'],  'from' => 'from-amber-400',   'to' => 'to-amber-600',   'ring' => 'ring-amber-100',   'text' => 'text-amber-700',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label' => 'Vencidos',    'valor' => $metricas['vencidos'],    'from' => 'from-red-500',     'to' => 'to-red-700',     'ring' => 'ring-red-100',     'text' => 'text-red-700',     'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                    ['label' => 'Esta semana', 'valor' => $metricas['proximos'],    'from' => 'from-blue-500',    'to' => 'to-blue-700',    'ring' => 'ring-blue-100',    'text' => 'text-blue-700',    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label' => 'Completados', 'valor' => $metricas['completados'], 'from' => 'from-emerald-500', 'to' => 'to-emerald-700', 'ring' => 'ring-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            @foreach($kpis as $kpi)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 ring-1 {{ $kpi['ring'] }}">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-tight">{{ $kpi['label'] }}</p>
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br {{ $kpi['from'] }} {{ $kpi['to'] }} flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black {{ $kpi['text'] }} leading-none tabular-nums">{{ $kpi['valor'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Barra de filtros --}}
        <form method="GET" action="{{ route('mantenimientos.index') }}"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4">
            <div class="flex flex-wrap gap-3 items-end">

                {{-- Buscador --}}
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Buscar</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Buscar por título o activo..."
                               class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Estado --}}
                <div class="min-w-[145px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Estado</label>
                    <select name="estado" class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                        <option value="">Todos</option>
                        <option value="pendiente"  {{ request('estado') === 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_proceso" {{ request('estado') === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="completado" {{ request('estado') === 'completado' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelado"  {{ request('estado') === 'cancelado'  ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                {{-- Tipo --}}
                <div class="min-w-[145px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Tipo</label>
                    <select name="tipo" class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                        <option value="">Todos</option>
                        <option value="preventivo" {{ request('tipo') === 'preventivo' ? 'selected' : '' }}>Preventivo</option>
                        <option value="correctivo" {{ request('tipo') === 'correctivo' ? 'selected' : '' }}>Correctivo</option>
                        <option value="revision"   {{ request('tipo') === 'revision'   ? 'selected' : '' }}>Revisión</option>
                    </select>
                </div>

                {{-- Activo --}}
                <div class="min-w-[175px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Activo</label>
                    <select name="activo_id" class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                        <option value="">Todos</option>
                        @foreach($activos as $a)
                            <option value="{{ $a->id }}" {{ request('activo_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2 pb-px">
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0014 13.828V19a1 1 0 01-1.447.894l-4-2A1 1 0 018 17v-3.172a1 1 0 00-.293-.707L1.293 6.707A1 1 0 011 6V4z"/>
                        </svg>
                        Filtrar
                    </button>
                    <a href="{{ route('mantenimientos.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50/60">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registros</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded-lg px-2.5 py-1">
                    {{ $mantenimientos->total() }} total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Activo</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Tipo</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Fecha programada</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Responsable</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Estado</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($mantenimientos as $m)
                            <tr class="group hover:bg-indigo-50/40 transition-colors duration-100 {{ $m->estaVencido() ? 'bg-red-50/50' : '' }}">

                                {{-- Activo + título --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-white transition-colors flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 leading-tight">{{ $m->titulo }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $m->activo?->nombre ?? '—' }}</p>
                                            @if($m->estaVencido())
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-500 bg-red-100 rounded-md px-1.5 py-0.5 mt-1">
                                                    <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                                    VENCIDO
                                                </span>
                                            @elseif($m->diasRestantes() <= 3 && $m->diasRestantes() >= 0)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 rounded-md px-1.5 py-0.5 mt-1">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    En {{ $m->diasRestantes() }} días
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Tipo --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $tipoStyles = [
                                            'preventivo' => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200',
                                            'correctivo' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200',
                                            'revision'   => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200',
                                        ];
                                        $tipoIcons = [
                                            'preventivo' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                            'correctivo' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                                            'revision'   => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold {{ $tipoStyles[$m->tipo] ?? 'bg-gray-100 text-gray-600' }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tipoIcons[$m->tipo] ?? '' }}"/>
                                        </svg>
                                        {{ $m->tipoLabel() }}
                                    </span>
                                </td>

                                {{-- Fecha --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 font-medium text-xs">{{ $m->programado_at->format('d M Y') }}</p>
                                            <p class="text-gray-400 text-[10px]">{{ $m->programado_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Responsable --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($m->responsable)
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($m->responsable->nombre, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-gray-700 font-medium text-xs leading-tight">{{ $m->responsable->nombre }} {{ $m->responsable->apellido }}</p>
                                                <p class="text-gray-400 text-[10px]">{{ $m->responsable->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-300 text-xs italic">Sin asignar</span>
                                    @endif
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $estadoConfig = [
                                            'pendiente'  => ['dot' => 'bg-amber-400',   'badge' => 'bg-amber-50 text-amber-700 ring-amber-200'],
                                            'en_proceso' => ['dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-700 ring-blue-200'],
                                            'completado' => ['dot' => 'bg-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
                                            'cancelado'  => ['dot' => 'bg-gray-300',    'badge' => 'bg-gray-50 text-gray-500 ring-gray-200'],
                                        ];
                                        $ec = $estadoConfig[$m->estado] ?? $estadoConfig['cancelado'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold ring-1 {{ $ec['badge'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $ec['dot'] }}"></span>
                                        {{ $m->estadoLabel() }}
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('mantenimientos.show', $m) }}"
                                           title="Ver detalle"
                                           class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 bg-gray-100 hover:bg-gray-200 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        {{-- Botones de acción rápida: solo cuando la fecha llegó y estado es pendiente/en_proceso --}}
                                        @if(in_array($m->estado, ['pendiente', 'en_proceso']) && ($m->programado_at->isToday() || $m->programado_at->isPast()))
                                            {{-- Marcar como realizado --}}
                                            <form action="{{ route('mantenimientos.completar', $m) }}" method="POST" class="inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" title="Marcar como realizado"
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </form>

                                            {{-- Reportar inconveniente (Alpine modal) --}}
                                            <div x-data="{ open: false }" class="inline">
                                                <button @click="open = true" type="button" title="Reportar inconveniente"
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-100 transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </button>

                                                <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                                    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" @click="open = false"></div>
                                                    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6" x-transition>
                                                        <div class="flex items-center gap-3 mb-4">
                                                            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                                                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                                </svg>
                                                            </div>
                                                            <div>
                                                                <h3 class="text-base font-bold text-gray-900">Reportar inconveniente</h3>
                                                                <p class="text-xs text-gray-400">{{ $m->titulo }}</p>
                                                            </div>
                                                        </div>

                                                        <form action="{{ route('mantenimientos.inconveniente', $m) }}" method="POST" class="space-y-4">
                                                            @csrf @method('PATCH')

                                                            <div>
                                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Nuevo estado</label>
                                                                <div class="grid grid-cols-2 gap-2">
                                                                    <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 transition-all">
                                                                        <input type="radio" name="nuevo_estado" value="en_proceso" checked class="text-blue-600">
                                                                        <span class="text-sm font-medium text-gray-700">En proceso</span>
                                                                    </label>
                                                                    <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer has-[:checked]:border-red-500 has-[:checked]:bg-red-50 transition-all">
                                                                        <input type="radio" name="nuevo_estado" value="cancelado" class="text-red-600">
                                                                        <span class="text-sm font-medium text-gray-700">Cancelado</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Descripción del inconveniente <span class="text-red-400">*</span></label>
                                                                <textarea name="observaciones" rows="3" required
                                                                          placeholder="Describe qué ocurrió o por qué no pudo completarse..."
                                                                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-400/40 focus:border-amber-400 focus:bg-white transition-all resize-none"></textarea>
                                                            </div>

                                                            <div class="flex justify-end gap-2 pt-1">
                                                                <button type="button" @click="open = false"
                                                                        class="px-4 py-2 rounded-lg bg-gray-100 text-gray-600 text-sm font-semibold hover:bg-gray-200 transition-colors">
                                                                    Cancelar
                                                                </button>
                                                                <button type="submit"
                                                                        class="px-4 py-2 rounded-lg bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 transition-colors">
                                                                    Registrar
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if(auth()->user()->esAdmin())
                                            <a href="{{ route('mantenimientos.edit', $m) }}"
                                               title="Editar"
                                               class="w-8 h-8 rounded-lg flex items-center justify-center text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                           <x-confirm-delete
    :action="route('mantenimientos.destroy', $m)"
    :nombre="$m->titulo"
    mensaje="Esta acción es irreversible. El mantenimiento será eliminado permanentemente del sistema."
/>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-700 text-sm">Sin mantenimientos</p>
                                            <p class="text-gray-400 text-xs mt-1">No hay registros que coincidan con los filtros aplicados.</p>
                                        </div>
                                        @if(auth()->user()->esAdmin())
                                            <a href="{{ route('mantenimientos.create') }}"
                                               class="inline-flex items-center gap-1.5 text-indigo-600 text-sm font-semibold hover:text-indigo-700 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Programar primer mantenimiento
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($mantenimientos->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between gap-4 flex-wrap">
                    <p class="text-xs text-gray-400">
                        Mostrando
                        <span class="font-semibold text-gray-600">{{ $mantenimientos->firstItem() }}–{{ $mantenimientos->lastItem() }}</span>
                        de
                        <span class="font-semibold text-gray-600">{{ $mantenimientos->total() }}</span>
                        registros
                    </p>
                    {{ $mantenimientos->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>