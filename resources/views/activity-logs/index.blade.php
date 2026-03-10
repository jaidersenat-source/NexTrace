<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shrink-0"
                 style="background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px solid #334155;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Historial de Auditoría</h1>
                <p class="text-sm text-ink-muted mt-0.5">Seguimiento de cambios y acciones en el sistema</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-5">

        @include('partials.alert')

        {{-- Filtros --}}
        <form method="GET" action="{{ route('activity-logs.index') }}"
              class="bg-white border border-border rounded-2xl shadow-sm px-5 py-4">
            <div class="flex flex-wrap gap-3 items-end">

                {{-- Acción --}}
                <div class="min-w-[145px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Acción</label>
                    <select name="action"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                        <option value="">Todas</option>
                        <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Creación</option>
                        <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Actualización</option>
                        <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Eliminación</option>
                    </select>
                </div>

                {{-- Módulo --}}
                <div class="min-w-[175px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Módulo</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="model" value="{{ request('model') }}"
                               placeholder="Activo, Empleado..."
                               class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-800 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Usuario --}}
                <div class="min-w-[175px]">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Usuario</label>
                    <select name="user_id"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-400 focus:bg-white transition-all">
                        <option value="">Todos</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->nombre }} {{ $u->apellido }}
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
                    <a href="{{ route('activity-logs.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-3.5 border-b border-border flex items-center justify-between bg-gray-50/60">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registros</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-gray-200 rounded-lg px-2.5 py-1">
                    {{ $logs->total() }} total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead>
                        <tr class="bg-white">
                            {{-- Siempre visible --}}
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Fecha</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Usuario</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Acción</th>
                            {{-- Visible desde sm --}}
                            <th class="hidden sm:table-cell px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Módulo</th>
                            {{-- Visible desde lg --}}
                            <th class="hidden lg:table-cell px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Descripción</th>
                            <th class="hidden lg:table-cell px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Cambios</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($logs as $log)
                            <tr class="group hover:bg-indigo-50/40 transition-colors duration-100">

                                {{-- Fecha --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-700">{{ $log->created_at->format('d M Y') }}</p>
                                            <p class="text-[10px] text-gray-400">{{ $log->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Usuario --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($log->user->nombre, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-gray-700 leading-tight">{{ $log->user->nombre }}</p>
                                                <p class="hidden sm:block text-[10px] text-gray-400">{{ $log->user->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-400 italic">Sistema</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Acción --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $actionStyles = [
                                            'create' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                            'update' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                            'delete' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
                                        ];
                                        $actionIcons = [
                                            'create' => 'M12 4v16m8-8H4',
                                            'update' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                                            'delete' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                                        ];
                                        $action    = $log->action ?? '';
                                        $styleCls  = $actionStyles[$action]  ?? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200';
                                        $iconPath  = $actionIcons[$action]   ?? 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
                                    @endphp
                                    {{-- Móvil: solo ícono -- Desktop: ícono + texto --}}
                                    <span class="inline-flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-lg text-xs font-bold {{ $styleCls }}">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                                        </svg>
                                        <span class="hidden sm:inline">{{ $log->actionLabel() }}</span>
                                    </span>
                                </td>

                                {{-- Módulo — visible desde sm --}}
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-md bg-indigo-50 border border-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-700">{{ $log->modelName() }}</p>
                                            <p class="text-[10px] text-gray-400">#{{ $log->model_id }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Descripción — visible desde lg --}}
                                <td class="hidden lg:table-cell px-6 py-4 max-w-xs">
                                    <p class="text-xs text-gray-600 truncate" title="{{ $log->description }}">
                                        {{ $log->description ?? '—' }}
                                    </p>
                                </td>

                                {{-- Cambios — visible desde lg --}}
                                <td class="hidden lg:table-cell px-6 py-4">
                                    @if($log->changes)
                                        <details class="cursor-pointer group/det">
                                            <summary class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition-colors list-none select-none">
                                                <svg class="w-3 h-3 transition-transform group-open/det:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                Ver cambios
                                            </summary>
                                            <div class="mt-2.5 space-y-1.5 min-w-[220px]">
                                                @foreach($log->changes['despues'] ?? [] as $campo => $valor)
                                                    <div class="flex items-start gap-1.5 text-[10px]">
                                                        <span class="font-bold text-gray-500 shrink-0 pt-px">{{ $campo }}:</span>
                                                        <span class="line-through text-red-400">{{ $log->changes['antes'][$campo] ?? '—' }}</span>
                                                        <svg class="w-2.5 h-2.5 text-gray-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                        <span class="font-semibold text-emerald-600">{{ $valor }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </details>
                                    @else
                                        <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-700 text-sm">Sin registros</p>
                                            <p class="text-gray-400 text-xs mt-1">No hay actividad que coincida con los filtros aplicados.</p>
                                        </div>
                                        <a href="{{ route('activity-logs.index') }}"
                                           class="inline-flex items-center gap-1.5 text-indigo-600 text-sm font-semibold hover:text-indigo-700 transition-colors">
                                            Limpiar filtros
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between gap-4 flex-wrap">
                    <p class="text-xs text-gray-400">
                        Mostrando
                        <span class="font-semibold text-gray-600">{{ $logs->firstItem() }}–{{ $logs->lastItem() }}</span>
                        de
                        <span class="font-semibold text-gray-600">{{ $logs->total() }}</span>
                        registros
                    </p>
                    {{ $logs->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>