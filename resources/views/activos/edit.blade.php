<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 min-w-0">
                <a href="{{ route('activos.show', $activo) }}"
                   class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-ink transition-colors shrink-0">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight truncate">Editar activo</h1>
                    <p class="text-sm text-ink-muted mt-0.5 truncate">{{ $activo->nombre }}</p>
                </div>
            </div>
            {{-- Eliminar --}}
            @can('delete', $activo)
            <form action="{{ route('activos.destroy', $activo) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar «{{ $activo->nombre }}»? Esta acción no se puede deshacer.')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-display font-semibold text-red-500 border border-red-200 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Eliminar
                </button>
            </form>
            @endcan
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('activos.update', $activo) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Sección 1: Info general --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Información general</h2>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Categoría --}}
                    <div>
                        <label for="categoria_id" class="block text-sm font-semibold text-ink mb-1.5 font-display">
                            Categoría <span class="text-red-400">*</span>
                        </label>
                        <select id="categoria_id" name="categoria_id" required
                                class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink
                                       outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                                       @error('categoria_id') border-red-400 bg-red-50 @enderror">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}"
                                    data-campos="{{ json_encode($cat->campos) }}"
                                    {{ old('categoria_id', $activo->categoria_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icono }} {{ $cat->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    @include('activos.partials.form')
                </div>
            </div>

            {{-- Sección 2: Info adicional --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Información adicional</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="numero_serie" class="block text-sm font-semibold text-ink mb-1.5 font-display">Número de serie</label>
                            <input id="numero_serie" type="text" name="numero_serie"
                                   value="{{ old('numero_serie', $activo->numero_serie ?? '') }}"
                                   placeholder="SN-XXXXXXXX"
                                   class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint font-mono outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label for="fecha_adquisicion" class="block text-sm font-semibold text-ink mb-1.5 font-display">Fecha de adquisición</label>
                            <input id="fecha_adquisicion" type="date" name="fecha_adquisicion"
                                   value="{{ old('fecha_adquisicion', $activo->fecha_adquisicion?->format('Y-m-d') ?? '') }}"
                                   class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Atributos dinámicos --}}
            <div id="seccion-dinamica" class="hidden bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                    <div class="w-7 h-7 rounded-lg bg-violet-100 border border-violet-200 flex items-center justify-center shrink-0">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#7C3AED" stroke-width="2.5" stroke-linecap="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink" id="titulo-dinamico">Atributos del activo</h2>
                </div>
                <div id="campos-dinamicos" class="p-6 space-y-5"></div>
            </div>

            {{-- Acciones --}}
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pb-4">
                <a href="{{ route('activos.index') }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all hover:-translate-y-0.5">
                    Cancelar
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 px-6 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl
                               hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Actualizar activo
                </button>
            </div>
        </form>
    </div>

    <script>
        const existingAtributos = @json($activo->atributos ?? []);
        const oldAtributos      = @json(old('atributos', []));
        const atributosData     = Object.keys(oldAtributos).length ? oldAtributos : existingAtributos;

        const categoriaSelect = document.getElementById('categoria_id');
        const seccionDinamica = document.getElementById('seccion-dinamica');
        const tituloDinamico  = document.getElementById('titulo-dinamico');
        const container       = document.getElementById('campos-dinamicos');
        const inputClass      = 'w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all';

        categoriaSelect.addEventListener('change', () => {
            const opt = categoriaSelect.options[categoriaSelect.selectedIndex];
            renderCampos(JSON.parse(opt.dataset.campos || '[]'), opt.textContent.trim());
        });

        function renderCampos(campos, catNombre) {
            container.innerHTML = '';
            if (!campos.length) { seccionDinamica.classList.add('hidden'); return; }
            tituloDinamico.textContent = 'Atributos — ' + catNombre;
            seccionDinamica.classList.remove('hidden');
            campos.forEach(campo => {
                const wrap  = document.createElement('div');
                const label = document.createElement('label');
                label.className   = 'block text-sm font-semibold text-ink mb-1.5 font-display';
                label.textContent = campo.label + (campo.requerido ? ' *' : '');
                let input;
                if (campo.tipo === 'select' && campo.opciones) {
                    input = document.createElement('select');
                    input.innerHTML = '<option value="">Seleccionar...</option>';
                    campo.opciones.forEach(op => {
                        const o = document.createElement('option');
                        o.value = o.textContent = op;
                        if (atributosData[campo.clave] === op) o.selected = true;
                        input.appendChild(o);
                    });
                } else {
                    input = document.createElement('input');
                    input.type  = campo.tipo === 'number' ? 'number' : 'text';
                    input.value = atributosData[campo.clave] || '';
                    input.placeholder = campo.label;
                }
                input.name      = `atributos[${campo.clave}]`;
                input.className = inputClass;
                if (campo.requerido) input.required = true;
                wrap.appendChild(label);
                wrap.appendChild(input);
                container.appendChild(wrap);
            });
        }

        if (categoriaSelect.value) {
            const opt = categoriaSelect.options[categoriaSelect.selectedIndex];
            renderCampos(JSON.parse(opt.dataset.campos || '[]'), opt.textContent.trim());
        }
    </script>
</x-app-layout>