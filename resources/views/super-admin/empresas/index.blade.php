<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Gestión de Empresas</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @include('partials.alert')

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Empresa</th>
                        <th class="px-6 py-3 text-left">Usuarios</th>
                        <th class="px-6 py-3 text-left">Plan</th>
                        <th class="px-6 py-3 text-left">Estado</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($empresas as $empresa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $empresa->nombre }}</p>
                                <p class="text-gray-400 text-xs">{{ $empresa->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $empresa->users_count }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    bg-{{ $empresa->planColor() }}-100
                                    text-{{ $empresa->planColor() }}-700">
                                    {{ $empresa->planLabel() }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $empresa->activo
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                    {{ $empresa->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('super-admin.empresas.show', $empresa) }}"
                                       class="text-indigo-600 hover:underline text-xs">
                                        Ver detalle
                                    </a>

                                    {{-- Toggle activo --}}
                                    <form action="{{ route('super-admin.empresas.toggle', $empresa) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Confirmar cambio de estado?')">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                                class="text-xs {{ $empresa->activo ? 'text-red-500' : 'text-green-600' }} hover:underline">
                                            {{ $empresa->activo ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                No hay empresas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($empresas->hasPages())
                <div class="px-6 py-4 border-t">{{ $empresas->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>