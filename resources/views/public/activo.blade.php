<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activo->nombre }}</title>
    @vite(['resources/css/app.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: {{ $activo->empresa->color_primario ?? '#0f172a' }};
            --surface: #f5f4f1;
            --card: #ffffff;
            --border: #e8e5df;
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
            background: var(--surface);
            min-height: 100svh;
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
        }

        /* ── Page ── */
        .page {
            max-width: 430px;
            margin: 0 auto;
            padding: 20px 16px 52px;
        }

        /* ── Hero ── */
        .hero {
            background: var(--brand);
            border-radius: 20px;
            padding: 36px 28px 30px;
            position: relative;
            overflow: hidden;
            margin-bottom: 10px;
        }

        /* Subtle dot-grid texture */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 22px 22px;
            opacity: 0.5;
        }

        /* Large decorative circle */
        .hero::after {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-inner {
            position: relative;
            z-index: 1;
        }

        .hero-icon-wrap {
            width: 68px;
            height: 68px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin-bottom: 18px;
            backdrop-filter: blur(4px);
        }

        .hero-company {
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 8px;
        }

        .hero-title {
            font-family: var(--display);
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            line-height: 1.05;
            letter-spacing: -0.025em;
            margin-bottom: 6px;
        }

        .hero-code {
            font-family: var(--mono);
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 0.08em;
        }

        /* ── Cards ── */
        .card {
            background: var(--card);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 20px;
            margin-bottom: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }

        .card-eyebrow {
            font-family: var(--mono);
            font-size: 9px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-eyebrow::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Status ── */
        .status-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-dot.free {
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34,197,94,0.12);
        }

        .status-dot.busy {
            background: #ef4444;
            box-shadow: 0 0 0 4px rgba(239,68,68,0.12);
            animation: pulse-dot 1.8s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 4px rgba(239,68,68,0.12); }
            50%       { box-shadow: 0 0 0 8px rgba(239,68,68,0.05); }
        }

        .status-label {
            font-family: var(--display);
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .status-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .status-time {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Last use mini block ── */
        .last-use-block {
            margin-top: 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .last-use-title {
            font-family: var(--mono);
            font-size: 9px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .last-use-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 5px 0;
            border-bottom: 1px solid var(--border);
        }

        .last-use-row:last-child { border-bottom: none; }

        .last-use-key {
            font-size: 12px;
            color: var(--text-muted);
        }

        .last-use-val {
            font-family: var(--mono);
            font-size: 12px;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* ── Login CTA ── */
        .login-cta {
            margin-top: 16px;
            background: color-mix(in srgb, var(--brand) 6%, white);
            border: 1px solid color-mix(in srgb, var(--brand) 18%, white);
            border-radius: 12px;
            padding: 13px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .login-cta-icon {
            width: 32px;
            height: 32px;
            background: color-mix(in srgb, var(--brand) 12%, white);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .login-cta-text {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .login-cta-text a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
        }

        .login-cta-text a:hover { text-decoration: underline; }

        /* ── Data list ── */
        .dl-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
        }

        .dl-row:last-child { border-bottom: none; }
        .dl-dt { font-size: 13px; color: var(--text-muted); }

        .dl-dd {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
            max-width: 58%;
        }

        /* ── Specs grid (two columns) ── */
        .spec-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 24px;
            align-items: start;
        }
        .spec-item {
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            gap: 8px;
            align-items: baseline;
        }
        .spec-item:last-child { border-bottom: none; }
        .spec-key { font-size: 13px; color: var(--text-muted); }
        .spec-val { font-size: 13px; font-weight: 600; color: var(--text-primary); text-align: right; max-width: 60%; }

        /* ── Badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        /* ── History ── */
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .history-item:last-child { border-bottom: none; }

        .history-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .history-right { text-align: right; flex-shrink: 0; }

        .history-time {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--text-muted);
        }

        .history-active {
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 600;
            color: #ef4444;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            padding-top: 8px;
        }

        .footer-brand {
            font-family: var(--mono);
            font-size: 10px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .footer-brand span { font-weight: 500; color: var(--text-secondary); }

        /* ── Entrance animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .page > * {
            animation: fadeUp 0.45s cubic-bezier(.22,.68,0,1.1) backwards;
        }

        .page > *:nth-child(1) { animation-delay: 0s; }
        .page > *:nth-child(2) { animation-delay: 0.07s; }
        .page > *:nth-child(3) { animation-delay: 0.12s; }
        .page > *:nth-child(4) { animation-delay: 0.16s; }
        .page > *:nth-child(5) { animation-delay: 0.20s; }
        .page > *:nth-child(6) { animation-delay: 0.24s; }
    </style>
</head>
<body>

    <div class="page">

        {{-- ── Hero ── --}}
        <div class="hero">
            <div class="hero-inner">
                <div class="hero-icon-wrap">{{ $activo->categoria->icono ?? '📦' }}</div>
                <p class="hero-company">{{ $activo->empresa->nombre }}</p>
                <h1 class="hero-title">{{ $activo->nombre }}</h1>
                @if($activo->codigo)
                    <p class="hero-code">{{ $activo->codigo }}</p>
                @endif
            </div>
        </div>

        {{-- ── Estado ── --}}
        <div class="card">

            @if($activo->estaEnUso())
                @php $uso = $activo->usoActual; @endphp

                <div class="status-row">
                    <span class="status-dot busy"></span>
                    <div>
                        <p class="status-label">En uso</p>
                        <p class="status-sub">{{ $uso->user?->nombre }} {{ $uso->user?->apellido }}</p>
                        <p class="status-time">Desde {{ $uso->started_at->format('d/m/Y · H:i') }}</p>
                    </div>
                </div>

            @else

                <div class="status-row">
                    <span class="status-dot free"></span>
                    <div>
                        <p class="status-label">Disponible</p>
                        <p class="status-sub">Este equipo está libre</p>
                    </div>
                </div>

                {{-- Último uso ── --}}
                @php $ultimoUso = $historial->first(); @endphp
                @if($ultimoUso && $ultimoUso->ended_at)
                    <div class="last-use-block">
                        <p class="last-use-title">Último uso registrado</p>

                        <div class="last-use-row">
                            <span class="last-use-key">Usuario</span>
                            <span class="last-use-val">{{ $ultimoUso->user?->nombre }} {{ $ultimoUso->user?->apellido }}</span>
                        </div>
                        <div class="last-use-row">
                            <span class="last-use-key">Fecha</span>
                            <span class="last-use-val">{{ $ultimoUso->ended_at->format('d/m/Y · H:i') }}</span>
                        </div>
                        <div class="last-use-row">
                            <span class="last-use-key">Duración</span>
                            <span class="last-use-val">{{ $ultimoUso->duracion() }}</span>
                        </div>
                    </div>
                @endif

                {{-- CTA login ── --}}
                <div class="login-cta">
                    <div class="login-cta-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--brand)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h6v18h-6"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/>
                        </svg>
                    </div>
                    <p class="login-cta-text">
                        <a href="{{ route('login') }}">Inicia sesión</a> para registrar el uso de este equipo
                    </p>
                </div>

            @endif
        </div>

        {{-- ── Atributos dinámicos ── --}}
        @if($activo->atributos && count($activo->atributos))
            <div class="card">
                <p class="card-eyebrow">Especificaciones</p>

                <div class="spec-grid">
                    @if($activo->categoria && count($activo->categoria->campos ?? []))
                        @foreach($activo->categoria->campos as $campo)
                            @php $valor = $activo->atributo($campo['clave']); @endphp
                            @if($valor !== null && $valor !== '')
                                <div class="spec-item">
                                    <div class="spec-key">{{ $campo['label'] }}</div>
                                    <div class="spec-val">
                                        @php
                                            $display = $valor;
                                            if (is_bool($valor)) { $display = $valor ? 'Sí' : 'No'; }
                                            elseif (is_numeric($valor) && preg_match('/^\d{4}-\d{2}-\d{2}/', (string)$valor)) { $display = date('d/m/Y', strtotime($valor)); }
                                        @endphp
                                        {{ $display }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        {{-- Fallback: mostrar todas las claves del array atributos --}}
                        @foreach($activo->atributos as $clave => $valor)
                            @if($valor !== null && $valor !== '')
                                <div class="spec-item">
                                    <div class="spec-key">{{ ucwords(str_replace(['_', '-'], ' ', $clave)) }}</div>
                                    <div class="spec-val">
                                        @php
                                            $display = $valor;
                                            if (is_bool($valor)) { $display = $valor ? 'Sí' : 'No'; }
                                            elseif (is_numeric($valor) && preg_match('/^\d{4}-\d{2}-\d{2}/', (string)$valor)) { $display = date('d/m/Y', strtotime($valor)); }
                                        @endphp
                                        {{ $display }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endif

        {{-- ── Info general ── --}}
        <div class="card">
            <p class="card-eyebrow">Detalle</p>
            <dl>
                <div class="dl-row">
                    <dt class="dl-dt">Estado</dt>
                    <dd class="dl-dd">
                        <span class="badge bg-{{ $activo->estadoColor() }}-100 text-{{ $activo->estadoColor() }}-700">
                            {{ $activo->estadoLabel() }}
                        </span>
                    </dd>
                </div>
                @if($activo->descripcion)
                    <div style="padding-top:12px;border-top:1px solid var(--border);margin-top:4px;">
                        <p style="font-family:var(--mono);font-size:9px;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);margin-bottom:7px;">Descripción</p>
                        <p style="font-size:13px;color:var(--text-secondary);line-height:1.65;">{{ $activo->descripcion }}</p>
                    </div>
                @endif
            </dl>
        </div>

        {{-- ── Historial ── --}}
        @if($historial->count())
            <div class="card">
                <p class="card-eyebrow">Últimos usos</p>
                <ul style="list-style:none;">
                    @foreach($historial as $uso)
                        <li class="history-item">
                            <p class="history-name">
                                {{ $uso->user?->nombre ?? 'Usuario eliminado' }}
                                @if($uso->user?->apellido) {{ $uso->user->apellido }} @endif
                            </p>
                            <div class="history-right">
                                <p class="history-time">
                                    {{ $uso->started_at->format('d/m · H:i') }}
                                    @if($uso->ended_at) → {{ $uso->ended_at->format('H:i') }} @endif
                                </p>
                                @if(!$uso->ended_at)
                                    <p class="history-active">● activo</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ── Footer ── --}}
        <div class="footer">
            <p class="footer-brand">Powered by <span>NexTrace</span></p>
        </div>

    </div>

</body>
</html>