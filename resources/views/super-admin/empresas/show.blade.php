<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">{{ $empresa->nombre }}</h2>
            <a href="{{ route('super-admin.empresas.index') }}"
               class="text-sm text-indigo-600 hover:underline">← Volver</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @include('partials.alert')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Info empresa --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-3">
                <h3 class="font-semibold text-gray-700 text-sm uppercase">Información</h3>
                <div class="text-sm space-y-2 text-gray-600">
                    <p><span class="font-medium">Slug:</span> {{ $empresa->slug }}</p>
                    <p><span class="font-medium">Email:</span> {{ $empresa->email ?? '—' }}</p>
                    <p><span class="font-medium">País:</span> {{ $empresa->pais ?? '—' }}</p>
                    <p><span class="font-medium">Usuarios:</span> {{ $empresa->users_count }}</p>
                    <p><span class="font-medium">Registrada:</span>
                        {{ $empresa->created_at->format('d/m/Y') }}</p>
                </div>

                {{-- Toggle estado --}}
                <form action="{{ route('super-admin.empresas.toggle', $empresa) }}"
                      method="POST" class="pt-2">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="w-full py-2 text-sm rounded-lg font-medium
                                {{ $empresa->activo
                                    ? 'bg-red-100 text-red-700 hover:bg-red-200'
                                    : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                        {{ $empresa->activo ? 'Desactivar empresa' : 'Activar empresa' }}
                    </button>
                </form>
            </div>

            {{-- Cambiar plan --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 text-sm uppercase mb-4">Plan</h3>

                <form action="{{ route('super-admin.empresas.plan', $empresa) }}"
                      method="POST" class="space-y-3">
                    @csrf @method('PATCH')

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Plan actual</label>
                        <select name="plan"
                                class="w-full rounded-lg border-gray-300 text-sm shadow-sm">
                            @foreach(['gratuito','basico','profesional','enterprise'] as $p)
                                <option value="{{ $p }}"
                                    {{ $empresa->plan === $p ? 'selected' : '' }}>
                                    {{ ucfirst($p) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Vence el</label>
                        <input type="date" name="plan_vence_at"
                               value="{{ $empresa->plan_vence_at?->format('Y-m-d') }}"
                               class="w-full rounded-lg border-gray-300 text-sm shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Notas internas</label>
                        <textarea name="notas_admin" rows="3"
                                  class="w-full rounded-lg border-gray-300 text-sm shadow-sm">{{ $empresa->notas_admin }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700">
                        Guardar plan
                    </button>
                </form>
            </div>

            {{-- Actividad reciente --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 text-sm uppercase mb-4">Actividad reciente</h3>
                <ul class="space-y-2">
                    @forelse($logs as $log)
                        <li class="text-xs text-gray-600 border-b pb-2">
                            <span class="font-medium">{{ $log->user?->nombre ?? 'Sistema' }}</span>
                            — {{ $log->description }}
                            <span class="text-gray-400 block">
                                {{ $log->created_at->format('d/m/Y H:i') }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-400 text-xs">Sin actividad registrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>