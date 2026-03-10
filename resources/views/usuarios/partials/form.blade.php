<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
        <input type="text" name="nombre"
               value="{{ old('nombre', $usuario->nombre ?? '') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm" required>
        @error('nombre')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
        <input type="text" name="apellido"
               value="{{ old('apellido', $usuario->apellido ?? '') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm text-sm">
    </div>
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Correo electrónico *
    </label>
    <input type="email" name="email"
           value="{{ old('email', $usuario->email ?? '') }}"
           class="w-full rounded-lg border-gray-300 shadow-sm text-sm"
           {{ isset($usuario) ? 'readonly' : '' }} required>
    @error('email')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
    @isset($usuario)
        <p class="text-xs text-gray-400 mt-1">
            El email no puede modificarse.
        </p>
    @endisset
</div>

<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Rol *</label>
    <select name="rol" class="w-full rounded-lg border-gray-300 shadow-sm text-sm">
        <option value="empleado"
            {{ old('rol', $usuario->rol ?? 'empleado') === 'empleado' ? 'selected' : '' }}>
            Empleado
        </option>
        <option value="admin"
            {{ old('rol', $usuario->rol ?? '') === 'admin' ? 'selected' : '' }}>
            Admin
        </option>
    </select>
    @error('rol')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>