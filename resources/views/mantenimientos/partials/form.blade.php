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