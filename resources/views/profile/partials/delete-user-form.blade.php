<section>
    <div class="bg-white border border-red-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-red-100 bg-red-50/50">
            <div class="w-7 h-7 rounded-lg bg-red-100 border border-red-200 flex items-center justify-center shrink-0">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-display font-bold text-sm text-red-700">Zona de peligro</h2>
                <p class="text-[10px] text-red-500 mt-0.5">Acciones irreversibles sobre tu cuenta</p>
            </div>
        </div>

        <div class="p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="max-w-sm">
                    <p class="text-sm font-semibold text-ink">Eliminar cuenta</p>
                    <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                        Una vez eliminada, todos tus datos serán borrados permanentemente. Descarga cualquier información que quieras conservar antes de continuar.
                    </p>
                </div>
                <button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-600 font-display font-semibold text-sm rounded-xl border border-red-200 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all hover:-translate-y-0.5 shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Eliminar mi cuenta
                </button>
            </div>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            {{-- Cabecera del modal --}}
            <div class="flex items-start gap-4 mb-5">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5" stroke-linecap="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-display font-bold text-ink text-base">¿Eliminar tu cuenta?</h3>
                    <p class="text-xs text-ink-muted mt-1 leading-relaxed">
                        Todos tus datos serán borrados permanentemente. Ingresa tu contraseña para confirmar.
                    </p>
                </div>
            </div>

            {{-- Input contraseña --}}
            <div class="mb-5">
                <label for="delete_password" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                    Contraseña
                </label>
                <input id="delete_password" name="password" type="password"
                       placeholder="••••••••"
                       class="w-full px-3.5 py-3 bg-surface border rounded-xl text-sm text-ink outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 focus:bg-white transition-all
                              @if($errors->userDeletion->get('password')) border-red-400 @endif">
                @if($errors->userDeletion->get('password'))
                    <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $errors->userDeletion->get('password')[0] }}
                    </p>
                @endif
            </div>

            {{-- Botones del modal --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                <button type="button"
                        x-on:click="$dispatch('close')"
                        class="flex items-center gap-2 px-5 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all">
                    Cancelar
                </button>
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-red-700 transition-all shadow-[0_4px_12px_rgba(220,38,38,0.3)]">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Sí, eliminar cuenta
                </button>
            </div>
        </form>
    </x-modal>
</section>