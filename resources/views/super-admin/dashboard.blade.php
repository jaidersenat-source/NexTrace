<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full uppercase">
                Super Admin
            </span>
            <h2 class="text-xl font-semibold text-gray-800">Panel Global</h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- Métricas globales --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $tarjetas = [
                    ['label' => 'Empresas totales',  'valor' => $metricas['total_empresas'],   'color' => 'indigo'],
                    ['label' => 'Empresas activas',  'valor' => $metricas['empresas_activas'], 'color' => 'green'],
                    ['label' => 'Usuarios totales',  'valor' => $metricas['total_usuarios'],   'color' => 'blue'],
                    ['label' => 'Activos totales',   'valor' => $metricas['total_activos'],    'color' => 'yellow'],
                    ['label' => 'Registros de log',  'valor' => $metricas['total_logs'],       'color' => 'purple'],
                ];
            @endphp

            @foreach($tarjetas as $t)
                <div class="bg-white rounded-xl shadow p-5">
                    <p class="text-xs text-gray-500 uppercase font-medium">{{ $t['label'] }}</p>
                    <p class="text-3xl font-bold text-{{ $t['color'] }}-600 mt-1">{{ $t['valor'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Empresas recientes --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">Empresas recientes</h3>
                    <a href="{{ route('super-admin.empresas.index') }}"
                       class="text-sm text-indigo-600 hover:underline">Ver todas</a>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach($empresas_recientes as $empresa)
                        <li class="px-6 py-3 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">{{ $empresa->nombre }}</p>
                                <p class="text-xs text-gray-400">{{ $empresa->email }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    bg-{{ $empresa->planColor() }}-100
                                    text-{{ $empresa->planColor() }}-700">
                                    {{ $empresa->planLabel() }}
                                </span>
                                <span class="w-2 h-2 rounded-full
                                    {{ $empresa->activo ? 'bg-green-400' : 'bg-red-400' }}">
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Actividad reciente --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h3 class="font-semibold text-gray-700">Actividad reciente</h3>
                    <a href="{{ route('super-admin.auditoria') }}"
                       class="text-sm text-indigo-600 hover:underline">Ver toda</a>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach($actividad_reciente as $log)
                        <li class="px-6 py-3">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-gray-700">{{ $log->description }}</p>
                                <span class="text-xs text-gray-400">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $log->empresa?->nombre ?? '—' }} ·
                                {{ $log->user?->nombre ?? 'Sistema' }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>