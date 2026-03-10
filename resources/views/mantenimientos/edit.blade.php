<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('mantenimientos.show', $mantenimiento) }}"
               class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-ink transition-colors shrink-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </a>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight">Editar mantenimiento</h1>
                <p class="text-sm text-ink-muted mt-0.5">{{ $mantenimiento->titulo }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('mantenimientos.update', $mantenimiento) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            {{-- Sección: Información del mantenimiento --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Información del mantenimiento</h2>
                </div>
                <div class="p-6 space-y-5">
                    @include('mantenimientos.partials.form')
                </div>
            </div>

            {{-- Sección: Estado y seguimiento --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                            <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Estado y seguimiento</h2>
                </div>
                <div class="p-6 space-y-5">

                    {{-- Estado --}}
                    <div>
                        <label for="estado" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select id="estado" name="estado" required
                                class="w-full px-3.5 py-3 bg-surface border rounded-xl text-sm text-ink
                                       outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                       @error('estado') border-red-400 @enderror">
                            @foreach(['pendiente' => 'Pendiente', 'en_proceso' => 'En proceso', 'completado' => 'Completado', 'cancelado' => 'Cancelado'] as $v => $l)
                                <option value="{{ $v }}" {{ old('estado', $mantenimiento->estado) === $v ? 'selected' : '' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Observaciones --}}
                    <div>
                        <label for="observaciones" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Observaciones
                        </label>
                        <textarea id="observaciones" name="observaciones" rows="4"
                                  placeholder="Añade observaciones sobre el mantenimiento..."
                                  class="w-full px-3.5 py-3 bg-surface border rounded-xl text-sm text-ink placeholder-ink-faint
                                         outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all resize-none
                                         @error('observaciones') border-red-400 @enderror">{{ old('observaciones', $mantenimiento->observaciones) }}</textarea>
                        @error('observaciones')
                            <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pb-4">
                <a href="{{ route('mantenimientos.index') }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    Cancelar
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Guardar cambios
                </button>
            </div>

        </form>
    </div>
</x-app-layout>