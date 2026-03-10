<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('mantenimientos.index') }}"
               class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-ink transition-colors shrink-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </a>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight">{{ $mantenimiento->titulo }}</h1>
                <p class="text-sm text-ink-muted mt-0.5">Detalle del mantenimiento</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-5">

        @include('partials.alert')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Detalle principal --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Detalle</h2>
                </div>

                <dl class="divide-y divide-border">
                    {{-- Activo --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Activo</dt>
                        <dd>
                            <a href="{{ route('activos.show', $mantenimiento->activo) }}"
                               class="text-sm font-semibold text-brand hover:underline underline-offset-2 transition-colors">
                                {{ $mantenimiento->activo->nombre }}
                            </a>
                        </dd>
                    </div>

                    {{-- Tipo --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Tipo</dt>
                        <dd>
                            @php
                                $tipoStyles = [
                                    'preventivo' => 'bg-violet-50 text-violet-700 ring-1 ring-violet-200',
                                    'correctivo' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-200',
                                    'revision'   => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $tipoStyles[$mantenimiento->tipo] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $mantenimiento->tipoLabel() }}
                            </span>
                        </dd>
                    </div>

                    {{-- Estado --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Estado</dt>
                        <dd>
                            @php
                                $estadoConfig = [
                                    'pendiente'  => ['dot' => 'bg-amber-400',   'badge' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200'],
                                    'en_proceso' => ['dot' => 'bg-blue-400',    'badge' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200'],
                                    'completado' => ['dot' => 'bg-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'],
                                    'cancelado'  => ['dot' => 'bg-gray-300',    'badge' => 'bg-gray-50 text-gray-500 ring-1 ring-gray-200'],
                                ];
                                $ec = $estadoConfig[$mantenimiento->estado] ?? $estadoConfig['cancelado'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $ec['badge'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $ec['dot'] }}"></span>
                                {{ $mantenimiento->estadoLabel() }}
                            </span>
                        </dd>
                    </div>

                    {{-- Programado --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Programado</dt>
                        <dd class="flex items-center gap-2">
                            <span class="text-sm font-medium text-ink">{{ $mantenimiento->programado_at->format('d/m/Y') }}</span>
                            @if($mantenimiento->estaVencido())
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-500 bg-red-50 ring-1 ring-red-200 rounded-md px-1.5 py-0.5">
                                    <svg width="9" height="9" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    VENCIDO
                                </span>
                            @endif
                        </dd>
                    </div>

                    {{-- Completado --}}
                    @if($mantenimiento->completado_at)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Completado</dt>
                            <dd class="text-sm font-medium text-emerald-600">
                                {{ $mantenimiento->completado_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Costo --}}
                    @if($mantenimiento->costo)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Costo</dt>
                            <dd class="text-sm font-bold text-ink tabular-nums">
                                ${{ number_format($mantenimiento->costo, 2) }}
                            </dd>
                        </div>
                    @endif

                    {{-- Registrado por --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Registrado por</dt>
                        <dd class="text-sm text-ink-muted">{{ $mantenimiento->user?->nombre ?? 'Sistema' }}</dd>
                    </div>

                    {{-- Responsable --}}
                    <div class="flex items-center justify-between px-6 py-3.5">
                        <dt class="text-xs font-semibold text-ink-muted uppercase tracking-wide">Responsable</dt>
                        <dd>
                            @if($mantenimiento->responsable)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-[10px] font-bold flex-shrink-0">
                                        {{ strtoupper(substr($mantenimiento->responsable->nombre, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-ink">
                                        {{ $mantenimiento->responsable->nombre }} {{ $mantenimiento->responsable->apellido }}
                                    </span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400 italic">Sin asignar</span>
                            @endif
                        </dd>
                    </div>
                </dl>

                @if(auth()->user()->esAdmin())
                    <div class="px-6 py-4 border-t border-border bg-surface flex gap-2.5">
                        <a href="{{ route('mantenimientos.edit', $mantenimiento) }}"
                           class="flex items-center gap-2 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Editar
                        </a>
                        <x-confirm-delete
    :action="route('mantenimientos.destroy', $mantenimiento)"
    :nombre="$mantenimiento->titulo"
    variant="button"
/>
                    </div>
                @endif
            </div>

            {{-- Descripción y observaciones --}}
            <div class="space-y-5">
                @if($mantenimiento->descripcion)
                    <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                        <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                            <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center shrink-0">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                                    <line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/>
                                </svg>
                            </div>
                            <h2 class="font-display font-bold text-sm text-ink">Descripción</h2>
                        </div>
                        <p class="px-6 py-5 text-sm text-ink-muted leading-relaxed">
                            {{ $mantenimiento->descripcion }}
                        </p>
                    </div>
                @endif

                @if($mantenimiento->observaciones)
                    <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                        <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                            <div class="w-7 h-7 rounded-lg bg-violet-100 border border-violet-200 flex items-center justify-center shrink-0">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <h2 class="font-display font-bold text-sm text-ink">Observaciones</h2>
                        </div>
                        <p class="px-6 py-5 text-sm text-ink-muted leading-relaxed">
                            {{ $mantenimiento->observaciones }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>