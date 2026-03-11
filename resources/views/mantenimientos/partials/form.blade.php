<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Activo *</label>
    <select name="activo_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
        <option value="">Selecciona un activo</option>
        @foreach($activos as $a)
            <option value="{{ $a->id }}"
                {{ old('activo_id', $mantenimiento->activo_id ?? $activoSeleccionado ?? '') == $a->id ? 'selected' : '' }}>
                {{ $a->nombre }}
            </option>
        @endforeach
    </select>
    @error('activo_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Responsable</label>
    <select name="responsable_id" class="w-full rounded-lg border-gray-300 shadow-sm text-sm">
        <option value="">Sin asignar</option>
        @foreach($usuarios as $u)
            <option value="{{ $u->id }}"
                {{ old('responsable_id', $mantenimiento->responsable_id ?? '') == $u->id ? 'selected' : '' }}>
                {{ $u->nombre }} {{ $u->apellido }}
            </option>
        @endforeach
    </select>
    @error('responsable_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
    <input type="text" name="titulo"
           value="{{ old('titulo', $mantenimiento->titulo ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm"
           placeholder="Ej: Limpieza general, Cambio de disco..." required>
    @error('titulo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
        <select name="tipo" class="w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
            @foreach(['preventivo'=>'Preventivo','correctivo'=>'Correctivo','revision'=>'Revisión'] as $v => $l)
                <option value="{{ $v }}"
                    {{ old('tipo', $mantenimiento->tipo ?? '') === $v ? 'selected' : '' }}>
                    {{ $l }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha programada *</label>
        <input type="date" name="programado_at"
               value="{{ old('programado_at', isset($mantenimiento) ? $mantenimiento->programado_at->format('Y-m-d') : '') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
        @error('programado_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
    <textarea name="descripcion" rows="3"
              class="w-full rounded-lg border-gray-300 shadow-sm text-sm"
              placeholder="Detalla qué trabajo se realizará...">{{ old('descripcion', $mantenimiento->descripcion ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Costo estimado</label>
    <input type="number" name="costo" step="0.01" min="0"
           value="{{ old('costo', $mantenimiento->costo ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm"
           placeholder="0.00">
</div>

{{-- Documento (PDF) - file input estilizado --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Documento (PDF)</label>
    <label for="documento"
           class="flex items-center gap-3 w-full rounded-lg border border-gray-300 shadow-sm px-3 py-2 cursor-pointer hover:border-brand hover:bg-brand/5 transition-colors group">
        <span class="flex items-center justify-center w-7 h-7 rounded-md bg-gray-100 group-hover:bg-brand/10 transition-colors shrink-0">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 group-hover:text-brand transition-colors">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
        </span>
        <span id="documento-label" class="text-sm text-gray-400 group-hover:text-gray-600 transition-colors truncate">
            Selecciona un archivo PDF...
        </span>
    </label>
    <input type="file" id="documento" name="documento" accept="application/pdf" class="sr-only"
           onchange="document.getElementById('documento-label').textContent = this.files[0]?.name ?? 'Selecciona un archivo PDF...'"/>
    @error('documento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>