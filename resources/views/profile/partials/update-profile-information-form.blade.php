<section>
    <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
            <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div>
                <h2 class="font-display font-bold text-sm text-ink">Información del perfil</h2>
                <p class="text-[10px] text-ink-muted mt-0.5">Actualiza tu nombre y dirección de email</p>
            </div>
        </div>

        <div class="p-6">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('patch')

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Nombre <span class="text-red-400">*</span>
                    </label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', $user->name) }}"
                           required autofocus autocomplete="name"
                           class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                  @error('name') @enderror">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $user->email) }}"
                           required autocomplete="username"
                           class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                  @error('email') @enderror">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    {{-- Email no verificado --}}
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 flex items-start gap-2.5 p-3 bg-amber-50 border border-amber-200 rounded-xl">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-amber-700">Email no verificado</p>
                                <button form="send-verification"
                                        class="text-xs text-amber-600 underline hover:text-amber-800 mt-0.5">
                                    Reenviar email de verificación
                                </button>
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-1 text-xs font-medium text-emerald-600">
                                        ✓ Enlace enviado a tu email.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Acciones --}}
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-border">
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }"
                           x-show="show"
                           x-transition
                           x-init="setTimeout(() => show = false, 2000)"
                           class="text-xs font-semibold text-emerald-600 flex items-center gap-1.5">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Guardado
                        </p>
                    @endif
                    <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>