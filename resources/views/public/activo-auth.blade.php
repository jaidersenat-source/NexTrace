<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $activo->nombre }} — NexTrace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: {{ $activo->empresa->color_primario ?? '#0f172a' }};
            --brand-rgb: 15, 23, 42;
            --surface: #f8f7f5;
            --card: #ffffff;
            --border: #e8e6e1;
            --text-primary: #141210;
            --text-secondary: #6b6560;
            --text-muted: #a8a39d;
            --mono: 'DM Mono', monospace;
            --sans: 'Inter', sans-serif;
            --display: 'Sora', sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--sans);
            background-color: var(--surface);
            background-image:
                radial-gradient(circle at 20% 80%, rgba(var(--brand-rgb), 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(var(--brand-rgb), 0.03) 0%, transparent 50%);
            min-height: 100svh;
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Layout ── */
        .page {
            max-width: 440px;
            margin: 0 auto;
            padding: 20px 16px 48px;
        }

        /* ── Header Hero ── */
        .hero {
            position: relative;
            background-color: var(--brand);
            border-radius: 20px;
            padding: 32px 28px 28px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                -45deg,
                transparent,
                transparent 18px,
                rgba(255,255,255,0.025) 18px,
                rgba(255,255,255,0.025) 19px
            );
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -40px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            padding: 5px 12px 5px 8px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            font-family: var(--sans);
            letter-spacing: 0.01em;
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 2;
        }

        .hero-badge-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            box-shadow: 0 0 6px #4ade80;
        }

        .hero-icon {
            font-size: 40px;
            line-height: 1;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));
        }

        .hero-label {
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.45);
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-family: var(--display);
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -0.02em;
            position: relative;
            z-index: 1;
            margin-bottom: 4px;
        }

        .hero-code {
            font-family: var(--mono);
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.06em;
            position: relative;
            z-index: 1;
        }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .card-label {
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Status Row ── */
        .status-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-indicator.free {
            background: #22c55e;
            box-shadow: 0 0 0 3px rgba(34,197,94,0.15);
        }

        .status-indicator.busy {
            background: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.15);
            animation: pulse-ring 1.8s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 0 3px rgba(239,68,68,0.15); }
            50% { box-shadow: 0 0 0 6px rgba(239,68,68,0.08); }
        }

        .status-text-primary {
            font-family: var(--display);
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .status-text-secondary {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        /* ── Timer ── */
        .timer-block {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            margin-bottom: 16px;
        }

        .timer-eyebrow {
            font-family: var(--mono);
            font-size: 9px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .timer-value {
            font-family: var(--mono);
            font-size: 38px;
            font-weight: 500;
            color: var(--text-primary);
            letter-spacing: 0.04em;
            line-height: 1;
        }

        /* ── Buttons ── */
        .btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 20px;
            border-radius: 12px;
            font-family: var(--sans);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.15s ease;
            letter-spacing: -0.01em;
        }

        .btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn:active:not(:disabled) {
            transform: scale(0.98);
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-primary:hover:not(:disabled) {
            filter: brightness(1.1);
        }

        .btn-danger {
            background: #141210;
            color: #fff;
            border: 1px solid #2a2620;
        }

        .btn-danger:hover:not(:disabled) {
            background: #ef4444;
            border-color: #ef4444;
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border);
            font-size: 14px;
            padding: 11px 20px;
        }

        .btn-ghost:hover:not(:disabled) {
            background: var(--surface);
            color: var(--text-primary);
        }

        /* ── Textarea ── */
        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.01em;
            margin-bottom: 8px;
            display: block;
        }

        .textarea {
            width: 100%;
            padding: 12px 14px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: var(--sans);
            font-size: 14px;
            color: var(--text-primary);
            resize: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            margin-bottom: 14px;
        }

        .textarea::placeholder { color: var(--text-muted); }

        .textarea:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(var(--brand-rgb), 0.08);
            background: #fff;
        }

        /* ── Alert ── */
        .alert-warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 13px;
            color: #92400e;
            font-weight: 500;
        }

        /* ── Toast Message ── */
        .toast {
            margin-top: 14px;
            padding: 11px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
        }

        .toast.ok {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .toast.error {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }

        /* ── Release Summary ── */
        .summary-card {
            background: var(--card);
            border-radius: 16px;
            border: 2px solid #d1fae5;
            padding: 22px;
            margin-bottom: 10px;
            text-align: center;
        }

        .summary-icon {
            width: 52px;
            height: 52px;
            background: #f0fdf4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border: 2px solid #d1fae5;
        }

        .summary-title {
            font-family: var(--display);
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .summary-row:last-child { border-bottom: none; }

        .summary-key {
            font-family: var(--mono);
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .summary-val {
            font-family: var(--mono);
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* ── Data List ── */
        .dl-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
        }

        .dl-row:last-child { border-bottom: none; }

        .dl-dt {
            font-size: 13px;
            color: var(--text-muted);
        }

        .dl-dd {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
            max-width: 60%;
        }

        /* ── Status Badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* ── History ── */
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
        }

        .history-item:last-child { border-bottom: none; }

        .history-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .history-obs {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 2px;
            font-style: italic;
        }

        .history-meta {
            text-align: right;
            flex-shrink: 0;
        }

        .history-time {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--text-muted);
        }

        .history-dur {
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .history-active {
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 600;
            color: #ef4444;
            margin-top: 2px;
        }

        /* ── Footer ── */
        .footer-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            padding: 8px 0 4px;
        }

        .footer-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-link:hover { color: var(--text-primary); }

        .footer-link.branded { color: var(--brand); }

        .footer-sep {
            width: 3px;
            height: 3px;
            background: var(--border);
            border-radius: 50%;
        }

        .footer-brand {
            text-align: center;
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding-top: 6px;
        }

        .footer-brand span {
            font-weight: 500;
            color: var(--text-secondary);
        }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 0.7s linear infinite; }

        /* ── Entrance animation ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page > * {
            animation: fadeUp 0.4s ease backwards;
        }

        .page > *:nth-child(1) { animation-delay: 0s; }
        .page > *:nth-child(2) { animation-delay: 0.06s; }
        .page > *:nth-child(3) { animation-delay: 0.1s; }
        .page > *:nth-child(4) { animation-delay: 0.14s; }
        .page > *:nth-child(5) { animation-delay: 0.18s; }
        .page > *:nth-child(6) { animation-delay: 0.22s; }
    </style>
</head>
<body>

    <div class="page" x-data="activoUsage()">

        {{-- ── Hero Header ── --}}
        <div class="hero">
            <div class="hero-badge">
                <div class="hero-badge-dot"></div>
                {{ Auth::user()->nombre }}
            </div>

            <div class="hero-icon">{{ $activo->categoria->icono ?? '📦' }}</div>
            <p class="hero-label">{{ $activo->empresa->nombre }}</p>
            <h1 class="hero-title">{{ $activo->nombre }}</h1>
            @if($activo->codigo)
                <p class="hero-code">{{ $activo->codigo }}</p>
            @endif
        </div>

        {{-- ── Estado + Acción ── --}}
        <div class="card">

            {{-- DISPONIBLE --}}
            <template x-if="!enUso">
                <div>
                    <div class="status-row">
                        <span class="status-indicator free"></span>
                        <div>
                            <p class="status-text-primary">Disponible</p>
                            <p class="status-text-secondary">Equipo libre y listo para usar</p>
                        </div>
                    </div>
                    <button @click="tomarEquipo()" :disabled="cargando" class="btn btn-primary">
                        <template x-if="!cargando">
                            <span style="display:flex;align-items:center;gap:8px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                Tomar equipo
                            </span>
                        </template>
                        <template x-if="cargando">
                            <span style="display:flex;align-items:center;gap:8px;">
                                <svg class="spin" width="16" height="16" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
                                Procesando…
                            </span>
                        </template>
                    </button>
                </div>
            </template>

            {{-- EN USO POR MÍ --}}
            <template x-if="enUso && esMiUso">
                <div>
                    <div class="status-row">
                        <span class="status-indicator busy"></span>
                        <div>
                            <p class="status-text-primary">En uso por ti</p>
                            <p class="status-text-secondary" x-text="'Iniciado ' + inicioFormateado"></p>
                        </div>
                    </div>

                    <div class="timer-block">
                        <p class="timer-eyebrow">Tiempo activo</p>
                        <p class="timer-value" x-text="contadorTexto">00:00:00</p>
                    </div>

                    <label class="field-label">Observaciones <span style="color:var(--text-muted);font-weight:400;">(opcional)</span></label>
                    <textarea x-model="observaciones" rows="3"
                              class="textarea"
                              placeholder="¿Alguna novedad con el equipo?"></textarea>

                    <button @click="liberarEquipo()" :disabled="cargando" class="btn btn-danger">
                        <template x-if="!cargando">
                            <span style="display:flex;align-items:center;gap:8px;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/></svg>
                                Liberar equipo
                            </span>
                        </template>
                        <template x-if="cargando">
                            <span style="display:flex;align-items:center;gap:8px;">
                                <svg class="spin" width="16" height="16" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" fill="none" opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round"/></svg>
                                Procesando…
                            </span>
                        </template>
                    </button>
                </div>
            </template>

            {{-- EN USO POR OTRO --}}
            <template x-if="enUso && !esMiUso">
                <div>
                    <div class="status-row">
                        <span class="status-indicator busy"></span>
                        <div>
                            <p class="status-text-primary">En uso</p>
                            <p class="status-text-secondary" x-text="usuarioActual"></p>
                            <p style="font-size:12px;color:var(--text-muted);margin-top:2px;" x-text="'Desde ' + inicioFormateado"></p>
                        </div>
                    </div>
                    <div class="alert-warning">
                        Este equipo está siendo utilizado por otro usuario.
                    </div>
                </div>
            </template>

            {{-- Toast ── --}}
            <div x-show="mensaje" x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="toast" :class="tipoMensaje === 'ok' ? 'ok' : 'error'"
                 x-text="mensaje">
            </div>
        </div>

        {{-- ── Resumen post-liberación ── --}}
        <template x-if="resumen">
            <div class="summary-card">
                <div class="summary-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                </div>
                <p class="summary-title">Equipo liberado</p>

                <div style="text-align:left;">
                    <div class="summary-row">
                        <span class="summary-key">Duración</span>
                        <span class="summary-val" x-text="resumen.duracion"></span>
                    </div>
                    <div class="summary-row" x-show="resumen.observaciones">
                        <span class="summary-key">Nota</span>
                        <span class="summary-val" style="font-family:var(--sans);font-size:13px;font-weight:500;max-width:60%;text-align:right;" x-text="resumen.observaciones"></span>
                    </div>
                </div>

                <a href="{{ route('scanner.index') }}" class="btn btn-ghost" style="margin-top:16px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                    Escanear otro activo
                </a>
            </div>
        </template>

        {{-- ── Atributos dinámicos ── --}}
        @if($activo->categoria && $activo->atributos)
            <div class="card">
                <p class="card-label">Especificaciones</p>
                <dl>
                    @foreach($activo->categoria->campos as $campo)
                        @php $valor = $activo->atributo($campo['clave']); @endphp
                        @if($valor)
                            <div class="dl-row">
                                <dt class="dl-dt">{{ $campo['label'] }}</dt>
                                <dd class="dl-dd">{{ $valor }}</dd>
                            </div>
                        @endif
                    @endforeach
                </dl>
            </div>
        @endif

        {{-- ── Info general ── --}}
        <div class="card">
            <p class="card-label">Detalle del activo</p>
            <dl>
                <div class="dl-row">
                    <dt class="dl-dt">Estado</dt>
                    <dd class="dl-dd">
                        <span class="badge bg-{{ $activo->estadoColor() }}-100 text-{{ $activo->estadoColor() }}-700">
                            {{ $activo->estadoLabel() }}
                        </span>
                    </dd>
                </div>
                @if($activo->valor)
                    <div class="dl-row">
                        <dt class="dl-dt">Valor</dt>
                        <dd class="dl-dd" style="font-family:var(--mono);">${{ number_format($activo->valor, 0, ',', '.') }}</dd>
                    </div>
                @endif
                @if($activo->descripcion)
                    <div style="padding-top:12px;border-top:1px solid var(--border);margin-top:4px;">
                        <p style="font-size:12px;color:var(--text-muted);margin-bottom:6px;font-family:var(--mono);letter-spacing:0.1em;text-transform:uppercase;">Descripción</p>
                        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;">{{ $activo->descripcion }}</p>
                    </div>
                @endif
            </dl>
        </div>

        {{-- ── Historial de uso ── --}}
        @if($historial->count())
            <div class="card">
                <p class="card-label">Últimos usos</p>
                <ul style="list-style:none;">
                    @foreach($historial as $uso)
                        <li class="history-item">
                            <div>
                                <p class="history-name">
                                    {{ $uso->user?->nombre ?? 'Usuario eliminado' }} {{ $uso->user?->apellido }}
                                </p>
                                @if($uso->observaciones)
                                    <p class="history-obs">"{{ Str::limit($uso->observaciones, 60) }}"</p>
                                @endif
                            </div>
                            <div class="history-meta">
                                <p class="history-time">
                                    {{ $uso->started_at->format('d/m H:i') }}
                                    @if($uso->ended_at) → {{ $uso->ended_at->format('H:i') }} @endif
                                </p>
                                @if($uso->ended_at)
                                    <p class="history-dur">{{ $uso->duracion() }}</p>
                                @else
                                    <p class="history-active">● activo</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── Footer ── --}}
        <div class="footer-links">
            <a href="{{ route('scanner.index') }}" class="footer-link branded">← Volver al escáner</a>
            <div class="footer-sep"></div>
            <a href="{{ route('activos.show', $activo) }}" class="footer-link">Ver detalle completo</a>
        </div>
        <p class="footer-brand">Powered by <span>NexTrace</span></p>

    </div>{{-- /.page --}}

    <script>
    function activoUsage() {
        const usoActual = @json($activo->usoActual);
        const userId    = {{ Auth::id() }};
        const token     = '{{ $activo->qr_token }}';

        return {
            enUso:            !!usoActual,
            esMiUso:          usoActual ? usoActual.user_id === userId : false,
            usuarioActual:    usoActual?.user ? (usoActual.user.nombre + ' ' + (usoActual.user.apellido || '')).trim() : '',
            inicioFormateado: usoActual?.started_at
                ? new Date(usoActual.started_at).toLocaleString('es', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' })
                : '',
            inicioTimestamp:  usoActual?.started_at ? new Date(usoActual.started_at).getTime() : null,
            observaciones:    '',
            cargando:         false,
            mensaje:          '',
            tipoMensaje:      'ok',
            resumen:          null,
            contadorTexto:    '00:00:00',
            _intervalo:       null,

            init() {
                if (this.enUso && this.esMiUso && this.inicioTimestamp) {
                    this.iniciarContador();
                }
            },

            iniciarContador() {
                this._intervalo = setInterval(() => {
                    const diff = Math.floor((Date.now() - this.inicioTimestamp) / 1000);
                    const h = String(Math.floor(diff / 3600)).padStart(2, '0');
                    const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
                    const s = String(diff % 60).padStart(2, '0');
                    this.contadorTexto = `${h}:${m}:${s}`;
                }, 1000);
            },

            async tomarEquipo() {
                this.cargando = true;
                this.mensaje  = '';
                try {
                    const res  = await fetch(`/a/${token}/toggle`, {
                        method:  'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept':       'application/json',
                        },
                        body: JSON.stringify({}),
                    });
                    const data = await res.json();
                    if (!res.ok) { this.mensaje = data.error || 'Error al tomar el equipo.'; this.tipoMensaje = 'error'; return; }
                    this.enUso            = true;
                    this.esMiUso          = true;
                    this.inicioTimestamp  = Date.now();
                    this.inicioFormateado = new Date().toLocaleString('es', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit' });
                    this.mensaje          = data.mensaje;
                    this.tipoMensaje      = 'ok';
                    this.iniciarContador();
                } catch (e) {
                    this.mensaje     = 'Error de conexión.';
                    this.tipoMensaje = 'error';
                } finally {
                    this.cargando = false;
                }
            },

            async liberarEquipo() {
                this.cargando = true;
                this.mensaje  = '';
                try {
                    const res  = await fetch(`/a/${token}/toggle`, {
                        method:  'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept':       'application/json',
                        },
                        body: JSON.stringify({ observaciones: this.observaciones || null }),
                    });
                    const data = await res.json();
                    if (!res.ok) { this.mensaje = data.error || 'Error al liberar el equipo.'; this.tipoMensaje = 'error'; return; }
                    if (this._intervalo) clearInterval(this._intervalo);
                    this.enUso         = false;
                    this.esMiUso       = false;
                    this.mensaje       = data.mensaje;
                    this.tipoMensaje   = 'ok';
                    this.resumen       = { duracion: data.duracion || this.contadorTexto, observaciones: this.observaciones };
                    this.observaciones = '';
                    this.contadorTexto = '00:00:00';
                } catch (e) {
                    this.mensaje     = 'Error de conexión.';
                    this.tipoMensaje = 'error';
                } finally {
                    this.cargando = false;
                }
            },

            destroy() {
                if (this._intervalo) clearInterval(this._intervalo);
            }
        };
    }
    </script>
</body>
</html>