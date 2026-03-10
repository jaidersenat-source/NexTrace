<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-violet-700 flex items-center justify-center shadow-md shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Notificaciones</h1>
                    <p class="text-sm text-ink-muted mt-0.5">
                        {{ $notificaciones->total() }} notificaciones
                        @php $noLeidas = $notificaciones->getCollection()->filter(fn($n) => !$n->estaLeida())->count(); @endphp
                        @if($noLeidas > 0)
                            · <span class="text-violet-600 font-semibold">{{ $noLeidas }} sin leer</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-5">

        @include('partials.alert')

        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">

            {{-- Cabecera --}}
            <div class="px-6 py-3.5 border-b border-border flex items-center justify-between bg-surface">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Bandeja de entrada</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-border rounded-lg px-2.5 py-1">
                    {{ $notificaciones->total() }} total
                </span>
            </div>

            {{-- Lista --}}
            @forelse($notificaciones as $notif)
                <div class="group flex items-start gap-4 px-6 py-4 border-b border-gray-50 transition-colors duration-100
                            {{ $notif->estaLeida() ? 'hover:bg-gray-50/60' : 'bg-violet-50/30 hover:bg-violet-50/60' }}">

                    {{-- Indicador no leída --}}
                    <div class="mt-1.5 shrink-0">
                        @if(! $notif->estaLeida())
                            <span class="block w-2 h-2 rounded-full bg-violet-500 shadow-sm shadow-violet-300"></span>
                        @else
                            <span class="block w-2 h-2 rounded-full bg-gray-200"></span>
                        @endif
                    </div>

                    {{-- Ícono --}}
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-xl
                                {{ $notif->estaLeida() ? 'bg-gray-100' : 'bg-violet-100' }}">
                        {{ $notif->icono }}
                    </div>

                    {{-- Contenido --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <p class="font-display font-semibold text-sm leading-tight
                                      {{ $notif->estaLeida() ? 'text-ink-muted' : 'text-ink' }}">
                                {{ $notif->titulo }}
                            </p>
                            <span class="text-[10px] text-ink-muted shrink-0 mt-0.5 whitespace-nowrap">
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-xs text-ink-muted mt-1 leading-relaxed">{{ $notif->mensaje }}</p>

                        {{-- Acciones --}}
                        <div class="flex items-center gap-2 mt-2.5">
                            @if($notif->url && ! $notif->estaLeida())
                                <form action="{{ route('notificaciones.leer', $notif) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 text-[11px] font-semibold text-violet-600 bg-violet-50 border border-violet-200 px-2.5 py-1 rounded-lg hover:bg-violet-600 hover:text-white hover:border-violet-600 transition-all">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Ver detalle
                                    </button>
                                </form>
                            @elseif($notif->url)
                                <a href="{{ $notif->url }}"
                                   class="inline-flex items-center gap-1 text-[11px] font-semibold text-ink-muted border border-border px-2.5 py-1 rounded-lg hover:border-ink hover:text-ink transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                    Ver detalle
                                </a>
                            @endif

                            <form action="{{ route('notificaciones.eliminar', $notif) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 text-[11px] font-semibold text-red-400 border border-red-100 px-2.5 py-1 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-display font-semibold text-gray-700 text-sm">Sin notificaciones</p>
                            <p class="text-gray-400 text-xs mt-1">Estás al día, no tienes notificaciones pendientes.</p>
                        </div>
                    </div>
                </div>
            @endforelse

            @if($notificaciones->hasPages())
                <div class="px-6 py-4 border-t border-border bg-surface flex items-center justify-between gap-4 flex-wrap">
                    <p class="text-xs text-gray-400">
                        Mostrando
                        <span class="font-semibold text-gray-600">{{ $notificaciones->firstItem() }}–{{ $notificaciones->lastItem() }}</span>
                        de
                        <span class="font-semibold text-gray-600">{{ $notificaciones->total() }}</span>
                    </p>
                    {{ $notificaciones->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>