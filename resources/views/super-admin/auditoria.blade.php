<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shrink-0" style="background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px solid #334155;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2.5" stroke-linecap="round">
                    <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Auditoría</h1>
                <p class="text-sm text-ink-muted mt-0.5">Registro de actividad del sistema</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-5">

        @include('partials.alert')

        {{-- Tabla --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">

            {{-- Cabecera --}}
            <div class="px-6 py-3.5 border-b border-border flex items-center justify-between bg-surface">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registros de actividad</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-border rounded-lg px-2.5 py-1">
                    {{ $logs->total() }} total
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border text-sm">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Fecha</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Usuario</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Empresa</th>
                            <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Acción</th>
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
                                            <p class="text-xs font-medium text-ink">{{ $log->created_at->format('d M Y') }}</p>
                                            <p class="text-[10px] text-ink-muted">{{ $log->created_at->format('H:i:s') }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Usuario --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-brand to-blue-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm">
                                                {{ strtoupper(substr($log->user->nombre, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-semibold text-ink leading-tight">{{ $log->user->nombre }}</p>
                                                <p class="text-[10px] text-ink-muted">{{ $log->user->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs text-ink-muted italic">Sin usuario</span>
                                        </div>
                                    @endif
                                </td>

                                {{-- Empresa --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->empresa)
                                        <div class="flex items-center gap-2">
                                            <div class="w-5 h-5 rounded-md bg-brand/10 border border-brand/15 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-2.5 h-2.5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-medium text-ink">{{ $log->empresa->nombre }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-ink-muted italic">Sin empresa</span>
                                    @endif
                                </td>

                                {{-- Acción --}}
                                <td class="px-6 py-4">
                                    @php
                                        $accion = $log->accion ?? '';
                                        $lower  = strtolower($accion);
                                        $badgeCls = match(true) {
                                            str_contains($lower, 'cre')    => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                            str_contains($lower, 'elim')   => 'bg-red-50 text-red-700 ring-1 ring-red-200',
                                            str_contains($lower, 'actu')   => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                            str_contains($lower, 'login')  => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200',
                                            str_contains($lower, 'logout') => 'bg-gray-100 text-gray-500 ring-1 ring-gray-200',
                                            default                        => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                        };
                                    @endphp
                                    @if($accion)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $badgeCls }}">
                                            {{ $accion }}
                                        </span>
                                    @else
                                        <span class="text-xs text-ink-muted italic">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-700 text-sm">Sin registros</p>
                                            <p class="text-gray-400 text-xs mt-1">No hay actividad registrada aún.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if($logs->hasPages())
                <div class="px-6 py-4 border-t border-border bg-surface flex items-center justify-between gap-4 flex-wrap">
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