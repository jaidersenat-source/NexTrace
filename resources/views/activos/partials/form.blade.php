{{-- Nombre --}}
<div>
    <label for="nombre" class="block text-sm font-semibold text-ink mb-1.5 font-display">
        Nombre del activo <span class="text-red-400">*</span>
    </label>
    <input id="nombre" type="text" name="nombre"
           value="{{ old('nombre', $activo->nombre ?? '') }}"
           placeholder="Ej: Laptop Dell XPS 15" required
           class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                  outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                  @error('nombre') border-red-400 bg-red-50 @enderror">
    @error('nombre')
    <p class="mt-2 text-xs text-red-500 flex items-center gap-1.5">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ $message }}
    </p>
    @enderror
</div>

{{-- Código + Valor --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="codigo" class="block text-sm font-semibold text-ink mb-1.5 font-display">
            Código interno
        </label>
        <input id="codigo" type="text" name="codigo"
               value="{{ old('codigo', $activo->codigo ?? '') }}"
               placeholder="NXT-001"
               class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint font-mono
                      outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                      @error('codigo') border-red-400 bg-red-50 @enderror">
        @error('codigo')
        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="valor" class="block text-sm font-semibold text-ink mb-1.5 font-display">
            Valor <span class="text-red-400">*</span>
        </label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-ink-faint text-sm pointer-events-none">$</span>
            <input id="valor" type="number" name="valor" step="0.01" min="0"
                   value="{{ old('valor', $activo->valor ?? '') }}"
                   placeholder="0.00" required
                   class="w-full pl-8 pr-4 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint tabular-nums
                          outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all
                          @error('valor') border-red-400 bg-red-50 @enderror">
        </div>
        @error('valor')
        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Estado --}}
<div>
    <label class="block text-sm font-semibold text-ink mb-2 font-display">
        Estado <span class="text-red-400">*</span>
    </label>
    <div class="grid grid-cols-3 gap-3">
        @foreach([
            'activo'        => ['label' => 'Activo',        'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>'],
            'mantenimiento' => ['label' => 'Mantenimiento', 'icon' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>'],
            'baja'          => ['label' => 'Baja',          'icon' => '<polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>'],
        ] as $val => $opt)
        <label class="relative cursor-pointer">
            <input type="radio" name="estado" value="{{ $val }}"
                   {{ old('estado', $activo->estado ?? 'activo') === $val ? 'checked' : '' }}
                   class="peer sr-only">
            <div class="flex flex-col items-center gap-2 p-3 bg-surface border-2 border-border rounded-xl text-center
                        peer-checked:border-brand peer-checked:bg-brand/4 transition-all hover:border-brand/40 cursor-pointer">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="text-ink-faint peer-checked:text-brand">
                    {!! $opt['icon'] !!}
                </svg>
                <span class="text-xs font-semibold text-ink-muted">{{ $opt['label'] }}</span>
            </div>
        </label>
        @endforeach
    </div>
    @error('estado')
    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>

{{-- Descripción --}}
<div>
    <label for="descripcion" class="block text-sm font-semibold text-ink mb-1.5 font-display">
        Descripción
    </label>
    <textarea id="descripcion" name="descripcion" rows="3"
              placeholder="Descripción, características o notas del activo..."
              class="w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint
                     outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all resize-none
                     @error('descripcion') border-red-400 bg-red-50 @enderror">{{ old('descripcion', $activo->descripcion ?? '') }}</textarea>
    @error('descripcion')
    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
    @enderror
</div>