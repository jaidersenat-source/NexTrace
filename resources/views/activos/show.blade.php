<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="flex items-start gap-4 min-w-0">
                {{-- Icono categoría --}}
                <div class="w-12 h-12 rounded-2xl bg-brand/8 border border-brand/12
                            flex items-center justify-center shrink-0 text-2xl shadow-sm">
                    {{ $activo->categoria->icono ?? '📦' }}
                </div>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5 mb-1">
                        <h1 class="font-display font-extrabold text-ink text-2xl tracking-tight leading-tight">
                            {{ $activo->nombre }}
                        </h1>
                        {{-- Badge estado --}}
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold
                                     bg-{{ $activo->estadoColor() }}-100 text-{{ $activo->estadoColor() }}-700 shrink-0">
                            {{ $activo->estadoLabel() }}
                        </span>
                        {{-- Badge uso en vivo --}}
                        @if($activo->estaEnUso())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-500 shrink-0">
                                <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse"></span>En uso
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-accent/10 text-accent shrink-0">
                                <span class="w-1.5 h-1.5 bg-accent rounded-full"></span>Disponible
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-ink-faint flex items-center gap-2">
                        <span class="font-mono text-xs bg-surface px-2 py-0.5 rounded-md">{{ $activo->codigo ?? 'Sin código' }}</span>
                        <span class="text-border">·</span>
                        {{ $activo->categoria->nombre ?? 'Sin categoría' }}
                        @if($activo->fecha_adquisicion)
                            <span class="text-border">·</span>
                            <span>Adquirido {{ $activo->fecha_adquisicion->format('d/m/Y') }}</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Acciones header --}}
            <div class="flex items-center gap-2 shrink-0 self-start">
                <a href="{{ route('activos.index') }}"
                   class="flex items-center justify-center w-9 h-9 rounded-xl border border-border text-ink-muted hover:text-ink hover:border-ink transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                </a>
                @can('update', $activo)
                <a href="{{ route('activos.edit', $activo) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl
                          hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_4px_12px_rgba(15,76,219,0.25)]">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Editar
                </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="space-y-5">

        {{-- ══════════════════════════════════
             FILA 1: Info + Atributos + QR
        ══════════════════════════════════ --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Info general --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-visible">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-border bg-surface">
                    <div class="w-6 h-6 rounded-lg bg-brand/10 flex items-center justify-center shrink-0">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0F4CDB" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Información general</h2>
                </div>
                <div class="p-5 space-y-3">
                    @php
                        $infoItems = [
                            ['label' => 'Código',       'value' => $activo->codigo ?? null,             'mono' => true],
                            ['label' => 'Nº de serie',  'value' => $activo->numero_serie ?? null,       'mono' => true],
                            ['label' => 'Valor',        'value' => $activo->valor ? '$' . number_format($activo->valor, 0, ',', '.') : null, 'mono' => false],
                            ['label' => 'Adquisición',  'value' => $activo->fecha_adquisicion?->format('d/m/Y') ?? null, 'mono' => false],
                            ['label' => 'Categoría',    'value' => ($activo->categoria->icono ?? '') . ' ' . ($activo->categoria->nombre ?? null), 'mono' => false],
                        ];
                    @endphp

                    @foreach($infoItems as $item)
                    @if($item['value'] && trim($item['value']))
                    <div class="flex items-start justify-between gap-4 text-sm pb-3 border-b border-surface last:border-0 last:pb-0">
                        <dt class="text-ink-faint shrink-0">{{ $item['label'] }}</dt>
                        <dd class="font-semibold text-ink text-right {{ $item['mono'] ? 'font-mono text-xs bg-surface px-2 py-0.5 rounded-md' : '' }}">
                            {{ $item['value'] }}
                        </dd>
                    </div>
                    @endif
                    @endforeach

                    @if($activo->descripcion)
                    <div class="pt-2 border-t border-surface">
                        <p class="text-xs text-ink-faint mb-1.5">Descripción</p>
                        <p class="text-sm text-ink leading-relaxed">{{ $activo->descripcion }}</p>
                    </div>
                    @endif

                    {{-- Estado de uso en vivo --}}
                    <div class="pt-2 border-t border-surface">
                        @if($activo->estaEnUso())
                            @php $uso = $activo->usoActual; @endphp
                            <div class="flex items-start gap-3 p-3 bg-red-50 rounded-xl border border-red-100">
                                <span class="w-2.5 h-2.5 bg-red-400 rounded-full animate-pulse mt-0.5 shrink-0"></span>
                                <div>
                                    <p class="text-sm font-semibold text-red-700">En uso ahora</p>
                                    <p class="text-xs text-red-500 mt-0.5">
                                        {{ $uso->user?->nombre }} {{ $uso->user?->apellido }}
                                    </p>
                                    <p class="text-xs text-red-400">Desde {{ $uso->started_at->format('H:i') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 p-3 bg-accent/8 rounded-xl border border-accent/15">
                                <span class="w-2.5 h-2.5 bg-accent rounded-full shrink-0"></span>
                                <p class="text-sm font-semibold text-accent">Disponible para uso</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Atributos dinámicos por categoría --}}
            @if($activo->categoria && $activo->atributos && count($activo->categoria->campos ?? []))
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-border bg-surface">
                    <div class="w-6 h-6 rounded-lg bg-violet-100 flex items-center justify-center shrink-0 text-sm">
                        {{ $activo->categoria->icono }}
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">{{ $activo->categoria->nombre }}</h2>
                </div>
                <div class="p-5 space-y-3">
                    @foreach($activo->categoria->campos as $campo)
                        @php $valor = $activo->atributo($campo['clave']); @endphp
                        @if($valor)
                        <div class="flex items-start justify-between gap-4 text-sm pb-3 border-b border-surface last:border-0 last:pb-0">
                            <dt class="text-ink-faint shrink-0">{{ $campo['label'] }}</dt>
                            <dd class="font-semibold text-ink text-right">{{ $valor }}</dd>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- QR --}}
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-4 border-b border-border bg-surface">
                    <div class="w-6 h-6 rounded-lg bg-ink/8 flex items-center justify-center shrink-0">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#374151" stroke-width="2.5">
                            <rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/>
                            <path d="M21 16h-3a2 2 0 0 0-2 2v3M21 21v.01M12 7v3a2 2 0 0 1-2 2H7M3 12h.01M12 3h.01M12 16v.01M16 12h1a2 2 0 0 1 2 2v1"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Código QR</h2>
                </div>
                <div class="p-5">
                    @if($activo->qr_image)
                    <div class="flex flex-col items-center">
                        @php
                            $qrUrl = null;
                            $downloadFilename = null;
                            if ($activo->qr_image) {
                                $appUrl = config('app.url', '');
                                $isSecure = request()?->isSecure() ?? false;
                                if ($isSecure || (is_string($appUrl) && Illuminate\Support\Str::startsWith($appUrl, 'https'))) {
                                    $qrUrl = secure_asset('storage/' . $activo->qr_image);
                                } else {
                                    $qrUrl = asset('storage/' . $activo->qr_image);
                                }

                                $base = $activo->codigo ?? $activo->id;
                                $slug = Illuminate\Support\Str::slug($activo->nombre ?? '');
                                $downloadBasename = 'qr-' . $base . ($slug ? '-' . $slug : '');
                            }
                        @endphp
                        {{-- QR image --}}
                        <div class="relative w-44 h-44 mb-4">
                            <div class="absolute inset-0 bg-gradient-to-br from-brand/8 to-accent/8 rounded-2xl"></div>
                            <div class="relative w-44 h-44 bg-white rounded-2xl border-2 border-border flex items-center justify-center overflow-hidden shadow-sm">
                                <object data="{{ $qrUrl }}"
                                        type="image/svg+xml"
                                        class="w-36 h-36">
                                    <img src="{{ $qrUrl }}"
                                         alt="QR {{ $activo->nombre }}" class="w-36 h-36">
                                </object>
                            </div>
                        </div>

                        {{-- URL pública --}}
                        <div class="w-full mb-4">
                            <p class="text-[10px] text-ink-faint font-semibold uppercase tracking-wider mb-1.5">URL pública</p>
                            <div class="flex items-center gap-2 p-2.5 bg-surface rounded-xl border border-border">
                                <p class="text-[11px] text-ink-muted font-mono flex-1 truncate">{{ $activo->urlPublica() }}</p>
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $activo->urlPublica() }}').then(() => this.innerHTML = '✓')"
                                        class="text-xs text-ink-faint hover:text-brand transition-colors px-1 shrink-0">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Acciones QR --}}
                        <div class="flex flex-col gap-2 w-full">

                            {{-- Botón descargar con selector de formato --}}
                               @php $empresaNombre = $activo->empresa?->nombre ?? config('app.name'); @endphp
                               <div class="relative w-full"
                                   id="qr-download-wrapper"
                                   data-src="{{ $qrUrl }}"
                                   data-name="{{ $activo->nombre }}"
                                   data-company="{{ $empresaNombre }}"
                                   data-basename="{{ $downloadBasename }}">

                                {{-- Split button --}}
                                <div class="flex w-full rounded-xl overflow-hidden shadow-[0_3px_10px_rgba(15,76,219,0.2)]">
                                    <button type="button" id="qr-download-main"
                                            class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-brand text-white
                                                   font-display font-semibold text-sm hover:bg-brand-light transition-all">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                        </svg>
                                        <span id="qr-format-label">Descargar PNG</span>
                                    </button>
                                    <button type="button" id="qr-format-toggle"
                                            class="px-3 py-2.5 bg-brand border-l border-white/25 text-white hover:bg-brand-light transition-colors"
                                            aria-label="Elegir formato">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
                                            <polyline points="6 9 12 15 18 9"/>
                                        </svg>
                                    </button>
                                </div>

                                {{-- Dropdown de formatos --}}
                                <div id="qr-format-menu"
                                   class="hidden fixed bg-white border border-border rounded-xl shadow-lg z-50 overflow-hidden">
                                    <button type="button" data-format="png"
                                            class="qr-format-opt flex items-center gap-2.5 w-full px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface transition-colors">
                                        <span class="w-8 text-center text-[10px] font-bold bg-brand/10 text-brand rounded px-1 py-0.5 uppercase">PNG</span>
                                        Imagen PNG
                                        <span class="ml-auto text-[10px] text-ink-faint">Alta calidad</span>
                                    </button>
                                    <button type="button" data-format="jpg"
                                            class="qr-format-opt flex items-center gap-2.5 w-full px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface transition-colors border-t border-border">
                                        <span class="w-8 text-center text-[10px] font-bold bg-amber-100 text-amber-700 rounded px-1 py-0.5 uppercase">JPG</span>
                                        Imagen JPG
                                        <span class="ml-auto text-[10px] text-ink-faint">Comprimida</span>
                                    </button>
                                    <button type="button" data-format="svg"
                                            class="qr-format-opt flex items-center gap-2.5 w-full px-4 py-2.5 text-sm font-semibold text-ink hover:bg-surface transition-colors border-t border-border">
                                        <span class="w-8 text-center text-[10px] font-bold bg-emerald-100 text-emerald-700 rounded px-1 py-0.5 uppercase">SVG</span>
                                        Vector SVG
                                        <span class="ml-auto text-[10px] text-ink-faint">Escalable</span>
                                    </button>
                                </div>
                            </div>

                            <a href="{{ $activo->urlPublica() }}" target="_blank"
                               class="flex items-center justify-center gap-2 w-full py-2.5 border border-border text-ink font-display font-semibold text-sm rounded-xl
                                      hover:border-brand hover:text-brand transition-all">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                    <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                                </svg>
                                Ver pública
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-surface border-2 border-dashed border-border flex items-center justify-center mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5">
                                <rect x="3" y="3" width="5" height="5"/><rect x="16" y="3" width="5" height="5"/><rect x="3" y="16" width="5" height="5"/>
                                <path d="M21 16h-3a2 2 0 0 0-2 2v3M21 21v.01M12 7v3a2 2 0 0 1-2 2H7M3 12h.01M12 3h.01M12 16v.01M16 12h1a2 2 0 0 1 2 2v1"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-ink-muted">QR no generado</p>
                        <p class="text-xs text-ink-faint mt-1">El código QR se generará automáticamente</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════
             FILA 2: Historial de uso
        ══════════════════════════════════ --}}
        @if($activo->usos->count())
        <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round">
                            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <h2 class="font-display font-bold text-sm text-ink">Historial de uso</h2>
                </div>
                <span class="text-xs text-ink-faint">{{ $activo->usos->count() }} registros</span>
            </div>

            {{-- Mobile cards --}}
            <div class="sm:hidden divide-y divide-surface">
                @foreach($activo->usos->take(8) as $uso)
                <div class="px-5 py-4">
                    <div class="flex items-start justify-between gap-3 mb-1">
                        <p class="font-semibold text-sm text-ink">
                            {{ $uso->user?->nombre ?? 'Usuario eliminado' }} {{ $uso->user?->apellido }}
                        </p>
                        @if($uso->ended_at)
                            <span class="text-xs font-semibold text-accent shrink-0">{{ $uso->duracion() }}</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-500 shrink-0">
                                <span class="w-1 h-1 bg-red-400 rounded-full animate-pulse"></span>Activo
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-ink-faint tabular-nums">
                        {{ $uso->started_at->format('d/m/Y H:i') }}
                        @if($uso->ended_at) → {{ $uso->ended_at->format('H:i') }} @endif
                    </p>
                </div>
                @endforeach
            </div>

            {{-- Desktop table --}}
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-surface border-b border-border">
                            <th class="text-left px-5 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Usuario</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Inicio</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Fin</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Duración</th>
                            <th class="text-left px-4 py-3 text-[11px] font-bold text-ink-faint uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface">
                        @foreach($activo->usos->take(10) as $uso)
                        <tr class="hover:bg-surface/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-brand/10 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold text-brand">
                                            {{ strtoupper(substr($uso->user?->nombre ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                    <span class="font-semibold text-ink text-sm">
                                        {{ $uso->user?->nombre ?? 'Eliminado' }} {{ $uso->user?->apellido }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-ink-muted tabular-nums text-sm">
                                {{ $uso->started_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3.5 text-ink-muted tabular-nums text-sm">
                                {{ $uso->ended_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="px-4 py-3.5 text-sm">
                                @if($uso->ended_at)
                                    <span class="font-semibold text-ink-muted">{{ $uso->duracion() }}</span>
                                @else
                                    <span class="text-ink-faint">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                @if($uso->ended_at)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-accent/10 text-accent">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full shrink-0"></span>Completado
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-50 text-red-500">
                                        <span class="w-1.5 h-1.5 bg-red-400 rounded-full animate-pulse shrink-0"></span>En curso
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
<script>
   function encodeHTML(str){ if (!str) return ''; return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;'); }

async function svgUrlToPngAndDownload(svgUrl, filename, size = 1024, topLabel = null, bottomLabel = null, mimeType = 'image/png') {
    try {
        let fetchUrl = svgUrl;
        try {
            const parsed = new URL(svgUrl, window.location.href);
            if (parsed.host !== window.location.host) fetchUrl = parsed.pathname + parsed.search;
        } catch (err) {}

        const res = await fetch(fetchUrl);
        if (!res.ok) throw new Error('No se pudo obtener el SVG');
        const svgText = await res.text();

        const svgBlob = new Blob([svgText], { type: 'image/svg+xml;charset=utf-8' });
        const url = URL.createObjectURL(svgBlob);
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.src = url;
        await new Promise((resolve, reject) => {
            img.onload = resolve;
            img.onerror = () => reject(new Error('Error cargando la imagen SVG'));
        });

        // ── Diseño profesional ──────────────────────────────────────
        const PAD        = Math.round(size * 0.06);   // padding lateral
        const TOP_H      = topLabel    ? Math.round(size * 0.14) : PAD;
        const BOTTOM_H   = bottomLabel ? Math.round(size * 0.18) : PAD;
        const QR_SIZE    = size - PAD * 2;             // QR con margen lateral
        const TOTAL_H    = TOP_H + QR_SIZE + BOTTOM_H;

        const canvas = document.createElement('canvas');
        canvas.width  = size;
        canvas.height = TOTAL_H;
        const ctx = canvas.getContext('2d');

        // Fondo blanco
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Línea decorativa superior removida (ya no se dibuja línea azul)

        // Empresa (arriba) — centrada verticalmente en su bloque
        if (topLabel) {
            const company = topLabel.toUpperCase();
            const maxW    = canvas.width - PAD * 2;
            // Reducir font-size automáticamente hasta que quepa en el ancho
            let fsCompany = Math.round(size * 0.07);
            ctx.font = `700 ${fsCompany}px system-ui, -apple-system, 'Segoe UI', Roboto, Arial`;
            while (ctx.measureText(company).width > maxW && fsCompany > 18) {
                fsCompany -= 2;
                ctx.font = `700 ${fsCompany}px system-ui, -apple-system, 'Segoe UI', Roboto, Arial`;
            }
            ctx.fillStyle = '#374151';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            // Centrar verticalmente dentro del bloque superior
            ctx.fillText(company, canvas.width / 2, Math.round(TOP_H / 2));
        }

        // QR centrado
        ctx.drawImage(img, PAD, TOP_H, QR_SIZE, QR_SIZE);

        // Nombre del activo (abajo) — reduce font-size hasta que quepa, sin truncar
        if (bottomLabel) {
            const asset  = bottomLabel.toUpperCase();
            const maxW   = canvas.width - PAD * 2;
            const yCenter = TOP_H + QR_SIZE + Math.round(BOTTOM_H / 2);

            ctx.fillStyle   = '#111827';
            ctx.textAlign   = 'center';
            ctx.textBaseline = 'middle';

            // Empezar grande y reducir hasta que quepa
            let fsAsset = Math.round(size * 0.12);
            ctx.font = `900 ${fsAsset}px system-ui, -apple-system, 'Segoe UI', Roboto, Arial`;
            while (ctx.measureText(asset).width > maxW && fsAsset > 20) {
                fsAsset -= 2;
                ctx.font = `900 ${fsAsset}px system-ui, -apple-system, 'Segoe UI', Roboto, Arial`;
            }
            ctx.fillText(asset, canvas.width / 2, yCenter);
        }

        // Línea decorativa inferior removida (ya no se dibuja línea azul)

        canvas.toBlob((blob) => {
            if (!blob) return;
            const a = document.createElement('a');
            const objectUrl = URL.createObjectURL(blob);
            a.href = objectUrl;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(objectUrl);
            URL.revokeObjectURL(url);
        }, mimeType, 0.95);
    } catch (err) {
        console.error('Error descargando PNG:', err);
        if (window.showToast) window.showToast('No se pudo descargar PNG', 'error');
        else alert('No se pudo descargar PNG');
    }
}

async function svgUrlAndDownload(svgUrl, basename, format, label) {
    if (format !== 'svg') {
        const mimeType = format === 'jpg' ? 'image/jpeg' : 'image/png';
        const ext      = format === 'jpg' ? '.jpg' : '.png';
        svgUrlToPngAndDownload(svgUrl, basename + ext, 1024, label?.company ?? null, label?.asset ?? null, mimeType);
        return;
    }
    try {
        let fetchUrl = svgUrl;
        try {
            const parsed = new URL(svgUrl, window.location.href);
            if (parsed.host !== window.location.host) fetchUrl = parsed.pathname + parsed.search;
        } catch (e) {}
        const res = await fetch(fetchUrl);
        if (!res.ok) throw new Error('No se pudo obtener el SVG');
        const svgText = await res.text();

        let finalSvg = svgText;
        const top    = label?.company ? label.company.toUpperCase() : '';
        const bottom = label?.asset   ? label.asset.toUpperCase()   : '';

        if (top || bottom) {
            // Leer dimensiones del SVG original
            const parser = new DOMParser();
            const doc    = parser.parseFromString(svgText, 'image/svg+xml');
            const svgEl  = doc.documentElement;

            let origW = 0, origH = 0;
            const vb = svgEl.getAttribute('viewBox');
            if (vb) {
                const parts = vb.trim().split(/[\s,]+/);
                if (parts.length === 4) { origW = parseFloat(parts[2]) || 0; origH = parseFloat(parts[3]) || 0; }
            }
            if (!origW) origW = parseFloat(svgEl.getAttribute('width'))  || 300;
            if (!origH) origH = parseFloat(svgEl.getAttribute('height')) || origW;

            // Bloques superior e inferior proporcionales al QR
            const topPx    = top    ? Math.round(origH * 0.13) : 0;
            const bottomPx = bottom ? Math.round(origH * 0.16) : 0;
            const pad      = Math.round(origW * 0.04);
            const totalH   = topPx + origH + bottomPx;
            const maxTextW = origW - pad * 2; // ancho máximo disponible para los textos

            // Tamaños de fuente
            const fsTop    = Math.round(origH * 0.09);  // empresa
            const fsBottom = Math.round(origH * 0.13);  // activo

            // Posiciones Y centradas en cada bloque
            const topY    = Math.round(topPx / 2);                    // empresa: centro del bloque superior
            const bottomY = topPx + origH + Math.round(bottomPx / 2); // activo: centro del bloque inferior

            // Embeber el SVG original como <image> data-URI
            const dataUri   = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgText);
            const encTop    = encodeHTML(top);
            const encBottom = encodeHTML(bottom);

            // textLength fuerza que el texto siempre quepa sin cortarse (SVG nativo)
            const topTextAttr    = top    ? ` textLength="${maxTextW}" lengthAdjust="spacingAndGlyphs"` : '';
            const bottomTextAttr = bottom ? ` textLength="${maxTextW}" lengthAdjust="spacingAndGlyphs"` : '';

            // Construir SVG final — sin líneas azules, textos siempre visibles y centrados
            finalSvg = '<?xml version="1.0" encoding="UTF-8"?>\n' +
                `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 ${origW} ${totalH}" width="${origW}" height="${totalH}">\n` +
                `  <rect width="${origW}" height="${totalH}" fill="#ffffff"/>\n` +
                `  <image href="${dataUri}" x="0" y="${topPx}" width="${origW}" height="${origH}"/>\n` +
                (top    ? `  <text x="${origW/2}" y="${topY}" text-anchor="middle" dominant-baseline="middle" fill="#374151" font-weight="800" font-size="${fsTop}" font-family="Arial Black,Arial,sans-serif"${topTextAttr}>${encTop}</text>\n` : '') +
                (bottom ? `  <text x="${origW/2}" y="${bottomY}" text-anchor="middle" dominant-baseline="middle" fill="#111827" font-weight="900" font-size="${fsBottom}" font-family="Arial Black,Arial,sans-serif"${bottomTextAttr}>${encBottom}</text>\n` : '') +
                '</svg>';
        }

        const blob = new Blob([finalSvg], { type: 'image/svg+xml;charset=utf-8' });
        const a    = document.createElement('a');
        a.href     = URL.createObjectURL(blob);
        a.download = basename + '.svg';
        document.body.appendChild(a);
        a.click();
        a.remove();
    } catch (err) {
        console.error('Error descargando SVG:', err);
        if (window.showToast) window.showToast('No se pudo descargar SVG', 'error');
        else alert('No se pudo descargar SVG');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const wrapper     = document.getElementById('qr-download-wrapper');
    if (!wrapper) return;

    const mainBtn     = document.getElementById('qr-download-main');
    const toggleBtn   = document.getElementById('qr-format-toggle');
    const menu        = document.getElementById('qr-format-menu');
    const formatLabel = document.getElementById('qr-format-label');
    const formatOpts  = document.querySelectorAll('.qr-format-opt');

    if (!mainBtn || !toggleBtn || !menu) return;

    let selectedFormat = 'png';
    const formatNames  = { png: 'Descargar PNG', jpg: 'Descargar JPG', svg: 'Descargar SVG' };

    // Mover al body para escapar de contenedores con overflow-hidden
    document.body.appendChild(menu);

    function positionMenu() {
        const tr = toggleBtn.getBoundingClientRect();
        const mr = mainBtn.getBoundingClientRect();
        const totalWidth = mr.width + tr.width;
        let left = mr.left;
        if (left + totalWidth > window.innerWidth) left = Math.max(8, window.innerWidth - totalWidth - 8);
        // cssText evita que Tailwind sobreescriba propiedades individuales
        menu.style.cssText = `position:fixed;width:${totalWidth}px;left:${left}px;bottom:${Math.round(window.innerHeight - tr.top + 6)}px;top:auto;transform:none;z-index:99999;`;
    }

    function openMenu()  { positionMenu(); menu.classList.remove('hidden'); toggleBtn.setAttribute('aria-expanded', 'true'); }
    function closeMenu() { menu.classList.add('hidden');    toggleBtn.setAttribute('aria-expanded', 'false'); }

    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        menu.classList.contains('hidden') ? openMenu() : closeMenu();
    });

    // pointerdown detecta toque fuera en móvil antes del synthetic click
    document.addEventListener('pointerdown', function (e) {
        if (menu.classList.contains('hidden')) return;
        if (menu.contains(e.target) || toggleBtn.contains(e.target) || e.target === toggleBtn) return;
        closeMenu();
    });

    formatOpts.forEach(function (opt) {
        opt.addEventListener('click', function (e) {
            e.stopPropagation();
            selectedFormat = opt.getAttribute('data-format');
            formatLabel.textContent = formatNames[selectedFormat] || 'Descargar';
            closeMenu();
            triggerDownload();
        });
    });

    mainBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        closeMenu();
        triggerDownload();
    });

    function triggerDownload() {
        const src      = wrapper.getAttribute('data-src');
        const name     = wrapper.getAttribute('data-name')    || null;
        const company  = wrapper.getAttribute('data-company') || null;
        const basename = wrapper.getAttribute('data-basename') || 'qr';
        if (!src) return;
        svgUrlAndDownload(src, basename, selectedFormat, { asset: name, company: company });
    }

    window.addEventListener('scroll', function () { if (!menu.classList.contains('hidden')) positionMenu(); }, { passive: true });
    window.addEventListener('resize', function () { if (!menu.classList.contains('hidden')) positionMenu(); });
});
</script>