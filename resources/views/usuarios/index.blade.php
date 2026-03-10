<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-blue-700 flex items-center justify-center shadow-md shrink-0">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Usuarios</h1>
                    <p class="text-sm text-ink-muted mt-0.5">{{ $usuarios->count() }} usuarios registrados</p>
                </div>
            </div>
            <a href="{{ route('usuarios.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl
                      hover:bg-brand-light transition-all duration-200 hover:-translate-y-0.5
                      shadow-[0_4px_12px_rgba(15,76,219,0.25)] self-start sm:self-auto shrink-0">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-5">

        @include('partials.alert')

        {{-- ── MÓVIL: cards ── --}}
        <div class="sm:hidden space-y-3">
            @forelse($usuarios as $usuario)
                <div class="bg-white border border-border rounded-2xl shadow-sm p-4">
                    {{-- Fila superior --}}
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
                            {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-display font-semibold text-ink text-sm truncate">
                                {{ $usuario->nombre }} {{ $usuario->apellido }}
                                @if($usuario->id === auth()->id())
                                    <span class="text-[10px] text-ink-muted font-normal">(tú)</span>
                                @endif
                            </p>
                            <p class="text-xs text-ink-muted truncate">{{ $usuario->email }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-1.5 shrink-0">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold
                                {{ $usuario->esAdmin() ? 'bg-brand/10 text-brand ring-1 ring-brand/20' : 'bg-gray-100 text-gray-500 ring-1 ring-gray-200' }}">
                                {{ $usuario->esAdmin() ? 'Admin' : 'Empleado' }}
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold
                                {{ $usuario->activo ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-red-50 text-red-600 ring-1 ring-red-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $usuario->activo ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>

                    @if($usuario->id !== auth()->id())
                        <div class="flex items-center gap-1.5 pt-3 border-t border-border">
                            <a href="{{ route('usuarios.edit', $usuario) }}"
                               class="flex-1 inline-flex items-center justify-center gap-1.5 py-1.5 text-[11px] font-semibold text-brand bg-brand/10 border border-brand/20 rounded-lg hover:bg-brand hover:text-white hover:border-brand transition-all">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Editar
                            </a>
                            <form action="{{ route('usuarios.toggle', $usuario) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-[11px] font-semibold border rounded-lg transition-all
                                            {{ $usuario->activo
                                                ? 'text-amber-600 bg-amber-50 border-amber-200 hover:bg-amber-500 hover:text-white hover:border-amber-500'
                                                : 'text-emerald-600 bg-emerald-50 border-emerald-200 hover:bg-emerald-500 hover:text-white hover:border-emerald-500' }}">
                                    {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 inline-flex items-center justify-center text-red-500 bg-red-50 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white border border-border rounded-2xl shadow-sm py-20 text-center">
                    <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-700 text-sm">Sin usuarios</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- ── DESKTOP: tabla ── --}}
        <div class="hidden sm:block bg-white border border-border rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-3.5 border-b border-border flex items-center justify-between bg-surface">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registros</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-border rounded-lg px-2.5 py-1">
                    {{ $usuarios->count() }} total
                </span>
            </div>

            <table class="min-w-full divide-y divide-gray-100 text-sm">
                <thead>
                    <tr class="bg-white">
                        <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Usuario</th>
                        <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Rol</th>
                        <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                        <th class="px-6 py-3.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Registrado</th>
                        <th class="px-6 py-3.5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($usuarios as $usuario)
                        <tr class="group hover:bg-indigo-50/30 transition-colors duration-100">

                            {{-- Usuario --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-sm">
                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm leading-tight">
                                            {{ $usuario->nombre }} {{ $usuario->apellido }}
                                            @if($usuario->id === auth()->id())
                                                <span class="text-[10px] text-gray-400 font-normal ml-1">(tú)</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $usuario->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Rol --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold
                                    {{ $usuario->esAdmin()
                                        ? 'bg-brand/10 text-brand ring-1 ring-brand/20'
                                        : 'bg-gray-100 text-gray-500 ring-1 ring-gray-200' }}">
                                    @if($usuario->esAdmin())
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    @else
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    @endif
                                    {{ $usuario->esAdmin() ? 'Admin' : 'Empleado' }}
                                </span>
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold
                                    {{ $usuario->activo
                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                                        : 'bg-red-50 text-red-600 ring-1 ring-red-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $usuario->activo ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-700">{{ $usuario->created_at->format('d M Y') }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $usuario->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($usuario->id !== auth()->id())
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                           title="Editar"
                                           class="w-8 h-8 rounded-lg flex items-center justify-center text-brand bg-brand/10 border border-brand/20 hover:bg-brand hover:text-white hover:border-brand transition-all">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        <form action="{{ route('usuarios.toggle', $usuario) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    title="{{ $usuario->activo ? 'Desactivar' : 'Activar' }}"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center border transition-all
                                                        {{ $usuario->activo
                                                            ? 'text-amber-600 bg-amber-50 border-amber-200 hover:bg-amber-500 hover:text-white hover:border-amber-500'
                                                            : 'text-emerald-600 bg-emerald-50 border-emerald-200 hover:bg-emerald-500 hover:text-white hover:border-emerald-500' }}">
                                                @if($usuario->activo)
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                                @else
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                                @endif
                                            </button>
                                        </form>

                                        <x-confirm-delete
                                       :action="route('usuarios.destroy', $usuario)"
                                        :nombre="$usuario->nombre"
                                           />
                                    </div>
                                @else
                                    <div class="flex justify-end">
                                        <span class="text-xs text-gray-300 italic">Tu cuenta</span>
                                    </div>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-700 text-sm">Sin usuarios</p>
                                        <p class="text-gray-400 text-xs mt-1">Crea el primero con "Nuevo usuario"</p>
                                    </div>
                                    <a href="{{ route('usuarios.create') }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Nuevo usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>