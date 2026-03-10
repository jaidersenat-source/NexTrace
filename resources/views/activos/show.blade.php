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
            <div class="bg-white border border-border rounded-2xl shadow-sm overflow-hidden">
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
                        {{-- QR image --}}
                        <div class="relative w-44 h-44 mb-4">
                            <div class="absolute inset-0 bg-gradient-to-br from-brand/8 to-accent/8 rounded-2xl"></div>
                            <div class="relative w-44 h-44 bg-white rounded-2xl border-2 border-border flex items-center justify-center overflow-hidden shadow-sm">
                                <object data="{{ Storage::disk('public')->url($activo->qr_image) }}"
                                        type="image/svg+xml"
                                        class="w-36 h-36">
                                    <img src="{{ Storage::disk('public')->url($activo->qr_image) }}"
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
                            <a id="download-qr-png"
                              data-src="{{ Storage::disk('public')->url($activo->qr_image) }}"
                              data-filename="qr-{{ $activo->codigo ?? $activo->id }}.png"
                               class="flex items-center justify-center gap-2 w-full py-2.5 bg-brand text-white font-display font-semibold text-sm rounded-xl
                                      hover:bg-brand-light transition-all hover:-translate-y-0.5 shadow-[0_3px_10px_rgba(15,76,219,0.2)] cursor-pointer">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                             <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                         <polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                               </svg>
                              Descargar QR
                              </a>
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
    async function svgUrlToPngAndDownload(svgUrl, filename, size = 1024) {
        try {
            // If the SVG URL is on a different host (e.g. 'localhost' vs '127.0.0.1'),
            // convert to a same-origin relative path so the browser doesn't block it with CORS.
            let fetchUrl = svgUrl;
            try {
                const parsed = new URL(svgUrl, window.location.href);
                if (parsed.host !== window.location.host) {
                    fetchUrl = parsed.pathname + parsed.search;
                }
            } catch (err) {
                // ignore and use original svgUrl
            }

            const res = await fetch(fetchUrl);
            if (!res.ok) throw new Error('No se pudo obtener el SVG');
            const svgText = await res.text();

            // Create a blob URL for the SVG and load into an image
            const svgBlob = new Blob([svgText], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.src = url;
            await new Promise((resolve, reject) => {
                img.onload = resolve;
                img.onerror = () => reject(new Error('Error cargando la imagen SVG'));
            });

            // Draw to canvas at requested size
            const canvas = document.createElement('canvas');
            canvas.width = size;
            canvas.height = size;
            const ctx = canvas.getContext('2d');
            // white background
            ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            // Convert to blob and trigger download
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
            }, 'image/png', 0.95);
        } catch (err) {
            console.error('Error descargando PNG:', err);
            if (window.showToast) window.showToast('No se pudo descargar PNG', 'error');
            else alert('No se pudo descargar PNG');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('download-qr-png');
        if (!btn) return;
        btn.addEventListener('click', function() {
            const src = btn.getAttribute('data-src');
            const filename = btn.getAttribute('data-filename') || 'qr.png';
            // tamaño razonable para impresión/uso: 1024
            svgUrlToPngAndDownload(src, filename, 1024);
        });
    });
</script>