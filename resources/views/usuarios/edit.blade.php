<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('usuarios.index') }}"
               class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-ink transition-colors shrink-0">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </a>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </h1>
                    <p class="text-sm text-ink-muted mt-0.5">{{ $usuario->email }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-5">

        @include('partials.alert')

        {{-- ── Información del usuario ── --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <h2 class="font-display font-bold text-sm text-ink">Información del usuario</h2>
            </div>
            <div class="p-6">
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')

                    @include('usuarios.partials.form')

                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-3 border-t border-border">
                        <a href="{{ route('usuarios.index') }}"
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
        </div>

        {{-- ── Cambiar contraseña ── --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5" stroke-linecap="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-sm text-ink">Cambiar contraseña</h2>
                    <p class="text-[10px] text-ink-muted mt-0.5">Deja en blanco si no deseas cambiarla</p>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('usuarios.password', $usuario) }}" method="POST" class="space-y-5">
                    @csrf @method('PATCH')

                    <div>
                        <label for="password" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Nueva contraseña <span class="text-red-400">*</span>
                        </label>
                        <input id="password" type="password" name="password" required
                               placeholder="Mínimo 8 caracteres"
                               class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                      @error('password') border-red-400 bg-red-50 @enderror">
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Confirmar contraseña <span class="text-red-400">*</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="Repite la nueva contraseña"
                               class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>

                    <div class="flex justify-end pt-3 border-t border-border">
                        <button type="submit"
                                class="flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 text-white font-display font-semibold text-sm rounded-xl hover:bg-amber-600 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(217,119,6,0.25)]">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>