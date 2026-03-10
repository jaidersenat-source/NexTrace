<x-app-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-6xl font-bold text-gray-300">404</h1>
            <p class="text-xl text-gray-600 mt-4">Recurso no encontrado.</p>
            <a href="{{ route('dashboard') }}"
               class="mt-6 inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Volver al inicio
            </a>
        </div>
    </div>
</x-app-layout>