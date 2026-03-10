<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight">Activos</h1>
                <p class="text-sm text-ink-muted mt-0.5">{{ $activos->total() }} activos registrados</p>
            </div>
            @can('create', App\Models\Activo::class)
            <a href="{{ route('activos.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl
                      hover:bg-brand-light transition-all duration-200 hover:-translate-y-0.5
                      shadow-[0_4px_12px_rgba(15,76,219,0.25)] self-start sm:self-auto shrink-0">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nuevo activo
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="space-y-5">

        @include('partials.alert')

        {{-- Filtros --}}
        <form method="GET" action="{{ route('activos.index') }}"
              class="bg-white border border-border rounded-2xl p-4 shadow-sm">
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 items-end">
                <div class="w-full sm:flex-1 sm:min-w-[180px]">
                    <label class="block text-xs font-bold text-ink-faint uppercase tracking-wider mb-1.5">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </div>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o código..."
                               class="w-full pl-9 pr-4 py-2.5 bg-surface border border-border rounded-xl text-sm text-ink placeholder-ink-faint outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>
                </div>
                <div class="w-full sm:w-auto sm:min-w-[160px]">
                    <label class="block text-xs font-bold text-ink-faint uppercase tracking-wider mb-1.5">Categoría</label>
                    <select name="categoria_id" class="w-full px-3 py-2.5 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        <option value="">Todas</option>
                        @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icono }} {{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-auto sm:min-w-[140px]">
                    <label class="block text-xs font-bold text-ink-faint uppercase tracking-wider mb-1.5">Estado</label>
                    <select name="estado" class="w-full px-3 py-2.5 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                        <option value="">Todos</option>
                        <option value="activo"        {{ request('estado') === 'activo'        ? 'selected' : '' }}>Activo</option>
                        <option value="mantenimiento" {{ request('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="baja"          {{ request('estado') === 'baja'          ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        Filtrar
                    </button>
                    <a href="{{ route('activos.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2.5 border border-border text-ink-muted font-semibold text-sm rounded-xl hover:border-brand hover:text-brand transition-all">
                        Limpiar
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">

            {{-- Cabecera --}}
            <div class="px-5 py-3.5 border-b border-border flex items-center justify-between bg-surface">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Registros</p>
                <span class="text-xs font-semibold text-gray-500 bg-white border border-border rounded-lg px-2.5 py-1">
                    {{ $activos->total() }} total
                </span>
            </div>

            {{-- ── MÓVIL: cards ── --}}
            <div class="sm:hidden divide-y divide-border">
                @forelse($activos as $activo)
                <div class="p-4 hover:bg-surface/50 transition-colors">
                    {{-- Fila superior: icono + nombre + badge uso --}}
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-brand/8 flex items-center justify-center shrink-0 text-lg">
                                {{ $activo->categoria->icono ?? '📦' }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-display font-semibold text-ink text-sm truncate">{{ $activo->nombre }}</p>
                                <p class="text-xs text-ink-muted mt-0.5">{{ $activo->categoria->nombre ?? 'Sin categoría' }}</p>
                                <p class="text-xs text-ink-faint font-mono mt-0.5">{{ $activo->codigo ?? '—' }}</p>
                            </div>
                        </div>
                        @if($activo->estaEnUso())
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-500 shrink-0">
                                <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse"></span>En uso
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-accent/10 text-accent shrink-0">
                                <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>Libre
                            </span>
                        @endif
                    </div>

                    {{-- Fila inferior: estado + acciones --}}
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-{{ $activo->estadoColor() }}-100 text-{{ $activo->estadoColor() }}-700">
                            {{ $activo->estadoLabel() }}
                        </span>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('activos.show', $activo) }}"
                               class="w-8 h-8 rounded-lg flex items-center justify-center text-ink-muted bg-surface border border-border hover:border-ink hover:text-ink transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @can('update', $activo)
                            <a href="{{ route('activos.edit', $activo) }}"
                               class="w-8 h-8 rounded-lg flex items-center justify-center text-brand bg-brand/10 border border-brand/20 hover:bg-brand hover:text-white hover:border-brand transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            @endcan
                            @can('delete', $activo)
                            <form action="{{ route('activos.destroy', $activo) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar «{{ $activo->nombre }}»?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-red-500 bg-red-50 border border-red-200 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center">
                    <div class="text-4xl mb-3">📦</div>
                    <p class="font-display font-semibold text-ink-muted text-sm">Sin activos</p>
                    <p class="text-xs text-ink-faint mt-1">No hay activos que coincidan con los filtros.</p>
                </div>
                @endforelse
            </div>

            {{-- ── DESKTOP: tabla ── --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-surface border-b border-border">
                            <th class="text-left px-5 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Activo</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Categoría</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Código</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Valor</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Estado</th>
                            <th class="text-left px-4 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Uso</th>
                            <th class="text-right px-5 py-3.5 text-[11px] font-black text-ink-faint uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($activos as $activo)
                        <tr class="hover:bg-surface/50 transition-colors group">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-brand/8 flex items-center justify-center shrink-0 text-base">
                                        {{ $activo->categoria->icono ?? '📦' }}
                                    </div>
                                    <span class="font-display font-semibold text-ink text-sm truncate max-w-[180px]">{{ $activo->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-ink-muted text-sm">{{ $activo->categoria->nombre ?? '—' }}</td>
                            <td class="px-4 py-4">
                                <span class="font-mono text-xs text-ink-muted bg-surface px-2 py-1 rounded-lg">{{ $activo->codigo ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-4 font-semibold text-ink text-sm tabular-nums">${{ number_format($activo->valor, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-{{ $activo->estadoColor() }}-100 text-{{ $activo->estadoColor() }}-700">
                                    {{ $activo->estadoLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                @if($activo->estaEnUso())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-500">
                                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse shrink-0"></span>En uso
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-accent/10 text-accent">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full shrink-0"></span>Libre
                                    </span>
                                @endif
                            </td>
                            {{-- Acciones: siempre visibles, sin opacity-0 --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('activos.show', $activo) }}"
                                       title="Ver detalle"
                                       class="w-8 h-8 rounded-lg flex items-center justify-center text-ink-muted bg-surface border border-border hover:border-ink hover:text-ink transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    @can('update', $activo)
                                    <a href="{{ route('activos.edit', $activo) }}"
                                       title="Editar"
                                       class="w-8 h-8 rounded-lg flex items-center justify-center text-brand bg-brand/10 border border-brand/20 hover:bg-brand hover:text-white hover:border-brand transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    @endcan
                                    @can('delete', $activo)
                                    <x-confirm-delete
                                   :action="route('activos.destroy', $activo)"
                                   :nombre="$activo->nombre"
                                     />
                                     @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <div class="flex flex-col items-center gap-4 max-w-xs mx-auto">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-3xl">📦</div>
                                    <div>
                                        <p class="font-display font-semibold text-ink-muted text-sm">No hay activos registrados</p>
                                        <p class="text-xs text-ink-faint mt-1">Crea el primero con "Nuevo activo"</p>
                                    </div>
                                    @can('create', App\Models\Activo::class)
                                    <a href="{{ route('activos.create') }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand text-white font-display font-semibold text-sm rounded-xl hover:bg-brand-light transition-all hover:-translate-y-0.5">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Nuevo activo
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activos->hasPages())
            <div class="px-5 py-4 border-t border-border flex items-center justify-between gap-4 flex-wrap">
                <p class="text-xs text-gray-400">
                    Mostrando
                    <span class="font-semibold text-gray-600">{{ $activos->firstItem() }}–{{ $activos->lastItem() }}</span>
                    de
                    <span class="font-semibold text-gray-600">{{ $activos->total() }}</span>
                    registros
                </p>
                {{ $activos->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>