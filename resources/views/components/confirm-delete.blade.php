@props([
    'action',
    'nombre'  => 'este registro',
    'mensaje' => null,
    'variant' => 'icon',
])

@php
    $uid     = 'del_' . md5($action);
    $mensaje = $mensaje ?? "Esta acción es irreversible. El registro será eliminado permanentemente del sistema.";
@endphp

{{-- Botón disparador --}}
<button type="button"
        title="Eliminar"
        x-data
        x-on:click="$dispatch('open-delete-modal', { uid: '{{ $uid }}' })"
        @class([
            'w-8 h-8 rounded-lg flex items-center justify-center text-red-500 bg-red-50 border border-red-200 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all'
                => $variant === 'icon',
            'flex items-center gap-2 px-4 py-2 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-red-300 hover:text-red-500 hover:bg-red-50 transition-all'
                => $variant === 'button',
        ])>
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <polyline points="3 6 5 6 21 6"/>
        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6M14 11v6"/>
        <path d="M9 6V4h6v2"/>
    </svg>
    @if($variant === 'button') Eliminar @endif
</button>

{{-- x-teleport DEBE ir en <template> --}}
<template x-teleport="body">
    <div x-data="{ open: false, uid: '{{ $uid }}' }"
         x-on:open-delete-modal.window="if ($event.detail.uid === uid) open = true"
         x-show="open"
         x-cloak
         x-on:keydown.escape.window="open = false"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         role="dialog" aria-modal="true">

        {{-- Backdrop --}}
        <div x-on:click="open = false"
             class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

        {{-- Panel --}}
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-2xl border border-border overflow-hidden">

            <div class="h-1 w-full bg-gradient-to-r from-red-400 to-red-600"></div>

            <div class="p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-11 h-11 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-display font-bold text-ink text-base leading-tight">¿Eliminar registro?</h3>
                        <p class="text-xs text-ink-muted mt-1">
                            Vas a eliminar <span class="font-semibold text-ink">«{{ $nombre }}»</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-2.5 p-3 bg-red-50 border border-red-100 rounded-xl mb-5">
                    <svg class="w-3.5 h-3.5 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p class="text-xs text-red-600 leading-relaxed">{{ $mensaje }}</p>
                </div>

                <div class="flex items-center gap-2.5">
                    <button type="button"
                            x-on:click="open = false"
                            class="flex-1 flex items-center justify-center px-4 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all">
                        Cancelar
                    </button>
                    <form action="{{ $action }}" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-1.5 px-4 py-2.5 bg-red-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-red-700 transition-all shadow-[0_4px_12px_rgba(220,38,38,0.3)]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6M14 11v6"/>
                                <path d="M9 6V4h6v2"/>
                            </svg>
                            Sí, eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>