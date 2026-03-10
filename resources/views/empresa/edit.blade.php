<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-blue-700 flex items-center justify-center shadow-md shrink-0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Configuración de Empresa</h1>
                <p class="text-sm text-ink-muted mt-0.5">Personaliza la información y apariencia de tu empresa</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">

        @include('partials.alert')

        <form action="{{ route('empresa.update') }}" method="POST"
              enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PATCH')

            {{-- ── Logo ── --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Logo de empresa</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-6">
                        <div class="shrink-0">
                            <img src="{{ $empresa->logoUrl() }}"
                                 alt="Logo"
                                 class="h-16 w-16 object-contain rounded-xl border border-border p-1.5 bg-surface">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="logo" accept="image/*"
                                   class="w-full text-sm text-ink-muted
                                          file:mr-3 file:py-2 file:px-4
                                          file:rounded-xl file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-brand/10 file:text-brand
                                          hover:file:bg-brand/20
                                          file:transition-colors file:cursor-pointer">
                            <p class="text-xs text-ink-muted mt-2">PNG, JPG o WEBP · Máximo 2MB</p>
                            @error('logo')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Información general ── --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Información general</h2>
                </div>
                <div class="p-6 space-y-5">

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Nombre de empresa <span class="text-red-400">*</span>
                        </label>
                        <input id="nombre" type="text" name="nombre"
                               value="{{ old('nombre', $empresa->nombre) }}"
                               placeholder="Nombre de tu empresa"
                               class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                      @error('nombre') border-red-400 bg-red-50 @enderror">
                        @error('nombre')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1.5">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-ink mb-1.5 font-display">Email</label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $empresa->email) }}"
                               placeholder="contacto@empresa.com"
                               class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>

                    {{-- Teléfono + País --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="telefono" class="block text-sm font-semibold text-ink mb-1.5 font-display">Teléfono</label>
                            <input id="telefono" type="text" name="telefono"
                                   value="{{ old('telefono', $empresa->telefono) }}"
                                   placeholder="+1 000 000 0000"
                                   class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label for="pais" class="block text-sm font-semibold text-ink mb-1.5 font-display">País</label>
                            <input id="pais" type="text" name="pais"
                                   value="{{ old('pais', $empresa->pais) }}"
                                   placeholder="Colombia"
                                   class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Colores de marca ── --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-violet-100 border border-violet-200 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="13.5" cy="6.5" r="2.5"/><circle cx="19" cy="13" r="2.5"/>
                            <circle cx="6" cy="12" r="2.5"/><circle cx="10" cy="19.5" r="2.5"/>
                            <path d="M13.5 9v1.5M19 15.5V17M6 14.5V16M10 17v0"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Colores de marca</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                        {{-- Color primario --}}
                        <div>
                            <label class="block text-sm font-semibold text-ink mb-3 font-display">Color primario</label>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="color" name="color_primario" id="color_primario"
                                           value="{{ old('color_primario', $empresa->color_primario) }}"
                                           class="h-11 w-11 rounded-xl cursor-pointer border border-border p-0.5 bg-surface appearance-none">
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wide mb-0.5">HEX</p>
                                    <p class="text-sm font-mono font-semibold text-ink" id="label_primario">
                                        {{ old('color_primario', $empresa->color_primario) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Color secundario --}}
                        <div>
                            <label class="block text-sm font-semibold text-ink mb-3 font-display">Color secundario</label>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="color" name="color_secundario" id="color_secundario"
                                           value="{{ old('color_secundario', $empresa->color_secundario) }}"
                                           class="h-11 w-11 rounded-xl cursor-pointer border border-border p-0.5 bg-surface appearance-none">
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wide mb-0.5">HEX</p>
                                    <p class="text-sm font-mono font-semibold text-ink" id="label_secundario">
                                        {{ old('color_secundario', $empresa->color_secundario) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Color sidebar --}}
                        <div>
                            <label class="block text-sm font-semibold text-ink mb-3 font-display">Color sidebar</label>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input type="color" name="color_sidebar" id="color_sidebar"
                                           value="{{ old('color_sidebar', $empresa->color_sidebar) }}"
                                           class="h-11 w-11 rounded-xl cursor-pointer border border-border p-0.5 bg-surface appearance-none">
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-ink-muted uppercase tracking-wide mb-0.5">HEX</p>
                                    <p class="text-sm font-mono font-semibold text-ink" id="label_sidebar">
                                        {{ old('color_sidebar', $empresa->color_sidebar) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Preview de colores --}}
                    <div class="mt-5 pt-5 border-t border-border">
                        <p class="text-[10px] font-bold text-ink-muted uppercase tracking-widest mb-3">Vista previa</p>
                        <div class="flex items-center gap-3">
                            <div id="preview_primario"
                                 class="h-8 flex-1 rounded-lg transition-all"
                                 style="background-color: {{ old('color_primario', $empresa->color_primario) }}"></div>
                            <div id="preview_secundario"
                                 class="h-8 flex-1 rounded-lg transition-all"
                                 style="background-color: {{ old('color_secundario', $empresa->color_secundario) }}"></div>
                            <div id="preview_sidebar"
                                 class="h-8 flex-1 rounded-lg transition-all"
                                 style="background-color: {{ old('color_sidebar', $empresa->color_sidebar) }}"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Acciones ── --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pb-4">
                <a href="{{ url()->previous() }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    Cancelar
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Guardar configuración
                </button>
            </div>

        </form>
    </div>

    <script>
        // Actualiza el label HEX y el preview en tiempo real al cambiar color
        const colores = ['primario', 'secundario', 'sidebar'];

        colores.forEach(key => {
            const input   = document.getElementById(`color_${key}`);
            const label   = document.getElementById(`label_${key}`);
            const preview = document.getElementById(`preview_${key}`);

            if (!input) return;

            input.addEventListener('input', () => {
                label.textContent          = input.value.toUpperCase();
                preview.style.backgroundColor = input.value;
            });
        });
    </script>
</x-app-layout>