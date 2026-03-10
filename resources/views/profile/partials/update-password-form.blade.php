<section>
    <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
            <div class="w-7 h-7 rounded-lg bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#D97706" stroke-width="2.5" stroke-linecap="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-display font-bold text-sm text-ink">Actualizar contraseña</h2>
                <p class="text-[10px] text-ink-muted mt-0.5">Usa una contraseña larga y aleatoria para mayor seguridad</p>
            </div>
        </div>

        <div class="p-6">
            <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('put')

                {{-- Contraseña actual --}}
                <div>
                    <label for="update_password_current_password" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Contraseña actual
                    </label>
                    <input id="update_password_current_password" name="current_password" type="password"
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full px-3.5 py-3 bg-surface border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                  @if($errors->updatePassword->get('current_password')) border-red-400 @endif">
                    @if($errors->updatePassword->get('current_password'))
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $errors->updatePassword->get('current_password')[0] }}
                        </p>
                    @endif
                </div>

                {{-- Nueva contraseña --}}
                <div>
                    <label for="update_password_password" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Nueva contraseña
                    </label>
                    <input id="update_password_password" name="password" type="password"
                           autocomplete="new-password"
                           placeholder="Mínimo 8 caracteres"
                           class="w-full px-3.5 py-3 bg-surface border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                  @if($errors->updatePassword->get('password')) border-red-400 @endif">
                    @if($errors->updatePassword->get('password'))
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $errors->updatePassword->get('password')[0] }}
                        </p>
                    @endif
                </div>

                {{-- Confirmar contraseña --}}
                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Confirmar nueva contraseña
                    </label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                           autocomplete="new-password"
                           placeholder="Repite la nueva contraseña"
                           class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                  @if($errors->updatePassword->get('password_confirmation')) @endif">
                    @if($errors->updatePassword->get('password_confirmation'))
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $errors->updatePassword->get('password_confirmation')[0] }}
                        </p>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-border">
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }"
                           x-show="show"
                           x-transition
                           x-init="setTimeout(() => show = false, 2000)"
                           class="text-xs font-semibold text-emerald-600 flex items-center gap-1.5">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Contraseña actualizada
                        </p>
                    @endif
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-amber-500 text-white font-display font-semibold text-sm rounded-xl hover:bg-amber-600 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(217,119,6,0.25)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Actualizar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>