<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-md shrink-0" style="background: linear-gradient(135deg, #0F4CDB, #3B6FF0)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-none">Reportes</h1>
                <p class="text-sm text-ink-muted mt-0.5">Exporta datos en Excel o PDF</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-5">

        @include('partials.alert')

        {{-- ── MÓDULO 1: Inventario de Activos ── --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-brand/10 border border-brand/15 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-sm text-ink">Inventario de Activos</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Lista completa con estado, valor y atributos</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Estado</label>
                        <select id="activos-estado" data-modulo="activos"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todos</option>
                            <option value="activo">Activo</option>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Categoría</label>
                        <select id="activos-categoria" data-modulo="activos"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todas</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->icono }} {{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Preview activos --}}
                <div id="preview-activos" class="hidden">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Vista previa</p>
                        <span id="preview-activos-total" class="text-xs font-semibold text-gray-500 bg-surface border border-border rounded-lg px-2.5 py-1"></span>
                    </div>
                    <div class="rounded-xl border border-border overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-border text-sm">
                                <thead class="bg-surface">
                                    <tr>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Nombre</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Categoría</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Código</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Valor</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-activos-tbody" class="divide-y divide-border bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-1">
                    <button onclick="exportar('activos', 'excel')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-emerald-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(5,150,105,0.25)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Exportar Excel
                    </button>
                    <button onclick="exportar('activos', 'pdf')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-red-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(220,38,38,0.2)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Exportar PDF
                    </button>
                </div>
            </div>
        </div>

        {{-- ── MÓDULO 2: Uso de Equipos ── --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-sky-100 border border-sky-200 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#0284C7" stroke-width="2.5" stroke-linecap="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-sm text-ink">Uso de Equipos</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Historial de quién usó cada equipo y por cuánto tiempo</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Activo</label>
                        <select id="uso-activo" data-modulo="uso"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todos</option>
                            @foreach($activos as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Usuario</label>
                        <select id="uso-usuario" data-modulo="uso"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todos</option>
                            @foreach($usuarios as $u)
                                <option value="{{ $u->id }}">{{ $u->nombre }} {{ $u->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Desde</label>
                        <input type="date" id="uso-desde" data-modulo="uso"
                               class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Hasta</label>
                        <input type="date" id="uso-hasta" data-modulo="uso"
                               class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Preview uso --}}
                <div id="preview-uso" class="hidden">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Vista previa</p>
                        <span id="preview-uso-total" class="text-xs font-semibold text-gray-500 bg-surface border border-border rounded-lg px-2.5 py-1"></span>
                    </div>
                    <div class="rounded-xl border border-border overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-border text-sm">
                                <thead class="bg-surface">
                                    <tr>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Activo</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Usuario</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Inicio</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Fin</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Duración</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-uso-tbody" class="divide-y divide-border bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-1">
                    <button onclick="exportar('uso', 'excel')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-emerald-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(5,150,105,0.25)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Exportar Excel
                    </button>
                    <button onclick="exportar('uso', 'pdf')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-red-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(220,38,38,0.2)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Exportar PDF
                    </button>
                </div>
            </div>
        </div>

        {{-- ── MÓDULO 3: Mantenimientos ── --}}
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-6 py-4 border-b border-border bg-surface">
                <div class="w-7 h-7 rounded-lg bg-accent/10 border border-accent/15 flex items-center justify-center shrink-0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#00D4AA" stroke-width="2.5" stroke-linecap="round">
                        <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-display font-bold text-sm text-ink">Mantenimientos</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Historial y costos de mantenimiento por período</p>
                </div>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Estado</label>
                        <select id="mant-estado" data-modulo="mantenimientos"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="en_proceso">En proceso</option>
                            <option value="completado">Completado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Tipo</label>
                        <select id="mant-tipo" data-modulo="mantenimientos"
                                class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                            <option value="">Todos</option>
                            <option value="preventivo">Preventivo</option>
                            <option value="correctivo">Correctivo</option>
                            <option value="revision">Revisión</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Desde</label>
                        <input type="date" id="mant-desde" data-modulo="mantenimientos"
                               class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-ink mb-1.5 font-display">Hasta</label>
                        <input type="date" id="mant-hasta" data-modulo="mantenimientos"
                               class="preview-trigger w-full px-3.5 py-3 bg-surface border border-border rounded-xl text-sm text-ink outline-none focus:border-brand focus:ring-2 focus:ring-brand/15 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Preview mantenimientos --}}
                <div id="preview-mantenimientos" class="hidden">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Vista previa</p>
                        <span id="preview-mantenimientos-total" class="text-xs font-semibold text-gray-500 bg-surface border border-border rounded-lg px-2.5 py-1"></span>
                    </div>
                    <div class="rounded-xl border border-border overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-border text-sm">
                                <thead class="bg-surface">
                                    <tr>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Título</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Activo</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Tipo</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Estado</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Programado</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Responsable</th>
                                        <th class="px-4 py-2.5 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Costo</th>
                                    </tr>
                                </thead>
                                <tbody id="preview-mantenimientos-tbody" class="divide-y divide-border bg-white"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2.5 pt-1">
                    <button onclick="exportar('mantenimientos', 'excel')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-emerald-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(5,150,105,0.25)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                        Exportar Excel
                    </button>
                    <button onclick="exportar('mantenimientos', 'pdf')"
                            class="flex items-center gap-2 px-5 py-2.5 bg-red-600 text-white font-display font-semibold text-sm rounded-xl hover:bg-red-700 transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(220,38,38,0.2)]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Exportar PDF
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        // ── Rutas de exportación ──────────────────────────────
        const rutas = {
            activos:        { excel: '{{ route('reportes.activos.excel') }}',        pdf: '{{ route('reportes.activos.pdf') }}' },
            uso:            { excel: '{{ route('reportes.uso.excel') }}',            pdf: '{{ route('reportes.uso.pdf') }}' },
            mantenimientos: { excel: '{{ route('reportes.mantenimientos.excel') }}', pdf: '{{ route('reportes.mantenimientos.pdf') }}' },
        };

        // ── Rutas de preview ──────────────────────────────────
        const rutasPreview = {
            activos:        '{{ route('reportes.preview.activos') }}',
            uso:            '{{ route('reportes.preview.uso') }}',
            mantenimientos: '{{ route('reportes.preview.mantenimientos') }}',
        };

        // ── Columnas de cada módulo ───────────────────────────
        const columnas = {
            activos:        ['nombre', 'categoria', 'estado', 'codigo', 'valor'],
            uso:            ['activo', 'usuario', 'inicio', 'fin', 'duracion'],
            mantenimientos: ['titulo', 'activo', 'tipo', 'estado', 'programado', 'responsable', 'costo'],
        };

        // ── Badges de estado ──────────────────────────────────
        const estadoBadge = {
            activo:        'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
            mantenimiento: 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
            baja:          'bg-gray-100 text-gray-500 ring-1 ring-gray-200',
            pendiente:     'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
            en_proceso:    'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
            completado:    'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
            cancelado:     'bg-gray-100 text-gray-500 ring-1 ring-gray-200',
        };

        // ── Debounce ──────────────────────────────────────────
        const timers = {};
        function debounce(fn, key, ms = 350) {
            clearTimeout(timers[key]);
            timers[key] = setTimeout(fn, ms);
        }

        // ── Recoger parámetros de cada módulo ─────────────────
        function getParams(modulo) {
            const p = new URLSearchParams();
            if (modulo === 'activos') {
                const e = document.getElementById('activos-estado').value;
                const c = document.getElementById('activos-categoria').value;
                if (e) p.append('estado', e);
                if (c) p.append('categoria_id', c);
            }
            if (modulo === 'uso') {
                const a = document.getElementById('uso-activo').value;
                const u = document.getElementById('uso-usuario').value;
                const d = document.getElementById('uso-desde').value;
                const h = document.getElementById('uso-hasta').value;
                if (a) p.append('activo_id', a);
                if (u) p.append('user_id', u);
                if (d) p.append('desde', d);
                if (h) p.append('hasta', h);
            }
            if (modulo === 'mantenimientos') {
                const e = document.getElementById('mant-estado').value;
                const t = document.getElementById('mant-tipo').value;
                const d = document.getElementById('mant-desde').value;
                const h = document.getElementById('mant-hasta').value;
                if (e) p.append('estado', e);
                if (t) p.append('tipo', t);
                if (d) p.append('desde', d);
                if (h) p.append('hasta', h);
            }
            return p;
        }

        // ── Renderizar tabla de preview ───────────────────────
        function renderPreview(modulo, data) {
            const wrapper = document.getElementById(`preview-${modulo}`);
            const tbody   = document.getElementById(`preview-${modulo}-tbody`);
            const total   = document.getElementById(`preview-${modulo}-total`);

            total.textContent = `${data.total} registro${data.total !== 1 ? 's' : ''}`;

            if (data.datos.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="${columnas[modulo].length}"
                            class="px-4 py-8 text-center text-xs text-gray-400 italic">
                            Sin registros para los filtros seleccionados
                        </td>
                    </tr>`;
            } else {
                tbody.innerHTML = data.datos.map(row => {
                    const celdas = columnas[modulo].map(col => {
                        const val = row[col] ?? '—';
                        // Aplicar badge a columnas de estado
                        if (col === 'estado') {
                            const key = Object.keys(estadoBadge).find(k =>
                                val.toLowerCase().includes(k.replace('_', ' '))
                            );
                            const cls = key ? estadoBadge[key] : 'bg-gray-100 text-gray-500';
                            return `<td class="px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold ${cls}">${val}</span>
                                    </td>`;
                        }
                        return `<td class="px-4 py-3 text-xs text-ink whitespace-nowrap">${val}</td>`;
                    }).join('');
                    return `<tr class="hover:bg-surface transition-colors">${celdas}</tr>`;
                }).join('');
            }

            wrapper.classList.remove('hidden');
        }

        // ── Skeleton de carga ─────────────────────────────────
        function showSkeleton(modulo) {
            const tbody = document.getElementById(`preview-${modulo}-tbody`);
            const cols  = columnas[modulo].length;
            tbody.innerHTML = Array.from({ length: 3 }, () => `
                <tr>
                    ${Array.from({ length: cols }, () => `
                        <td class="px-4 py-3">
                            <div class="h-3 bg-gray-100 rounded animate-pulse w-24"></div>
                        </td>`).join('')}
                </tr>`).join('');
            document.getElementById(`preview-${modulo}`).classList.remove('hidden');
        }

        // ── Fetch preview ─────────────────────────────────────
        async function fetchPreview(modulo) {
            showSkeleton(modulo);
            const params = getParams(modulo);
            try {
                const res  = await fetch(`${rutasPreview[modulo]}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const data = await res.json();
                renderPreview(modulo, data);
            } catch (e) {
                console.error('Error al cargar preview:', e);
            }
        }

        // ── Escuchar cambios en filtros ───────────────────────
        document.querySelectorAll('.preview-trigger').forEach(el => {
            el.addEventListener('change', () => {
                const modulo = el.dataset.modulo;
                debounce(() => fetchPreview(modulo), modulo);
            });
        });

        // ── Exportar ──────────────────────────────────────────
        function exportar(modulo, tipo) {
            const params = getParams(modulo);
            window.location.href = rutas[modulo][tipo] + '?' + params.toString();
        }
    </script>

</x-app-layout>