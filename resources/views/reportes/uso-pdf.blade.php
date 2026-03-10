<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            background: #ffffff;
        }

        /* ── Header ─────────────────────────────────────────── */
        .header {
            position: relative;
            background: #0f172a;
            overflow: hidden;
        }

        .header-accent {
            position: absolute;
            top: 0; left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(180deg, #38bdf8, #0284c7);
        }

        .header-inner {
            padding: 22px 28px 22px 36px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .header-subtitle {
            color: #94a3b8;
            font-size: 10px;
            margin-top: 3px;
        }

        .header-meta { text-align: right; }

        .header-badge {
            display: inline-block;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #7dd3fc;
            font-size: 9px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .header-date { color: #64748b; font-size: 9px; }

        /* ── Periodo bar ─────────────────────────────────────── */
        .periodo-bar {
            background: #0c4a6e;
            padding: 8px 28px 8px 36px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid #075985;
        }

        .periodo-label {
            font-size: 8.5px;
            color: #7dd3fc;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .periodo-sep { color: #075985; font-size: 10px; margin: 0 2px; }

        .periodo-value {
            font-size: 9px;
            color: #bae6fd;
            font-weight: bold;
        }

        /* ── Info bar ────────────────────────────────────────── */
        .info-bar {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 9px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            color: #64748b;
        }

        .info-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #0284c7;
            flex-shrink: 0;
        }

        .info-label { color: #94a3b8; }
        .info-value { color: #1e293b; font-weight: bold; }

        /* ── KPIs ────────────────────────────────────────────── */
        .kpis {
            display: flex;
            gap: 0;
            margin: 20px 28px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .kpi {
            flex: 1;
            padding: 13px 16px;
            border-right: 1px solid #e2e8f0;
            background: #ffffff;
        }

        .kpi:last-child { border-right: none; }

        .kpi-label {
            font-size: 8px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 5px;
        }

        .kpi-value {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1;
        }

        .kpi-value.blue   { color: #0284c7; }
        .kpi-value.green  { color: #059669; }
        .kpi-value.amber  { color: #d97706; }
        .kpi-value.violet { color: #7c3aed; }

        /* ── Section title ───────────────────────────────────── */
        .section-title {
            margin: 0 28px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-line { flex: 1; height: 1px; background: #e2e8f0; }

        .section-label {
            font-size: 8px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* ── Table ───────────────────────────────────────────── */
        .table-wrap {
            margin: 0 28px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            background: #1e293b;
            color: #94a3b8;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 9px 11px;
            text-align: left;
        }

        thead th:first-child { color: #475569; width: 24px; }

        tbody tr { background: #ffffff; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        tbody td {
            padding: 7px 11px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 9.5px;
            color: #334155;
            vertical-align: middle;
        }

        .td-num    { color: #94a3b8; font-size: 9px; font-weight: bold; }
        .td-name   { font-weight: bold; color: #0f172a; font-size: 10px; }
        .td-muted  { color: #94a3b8; }
        .td-date   { color: #475569; white-space: nowrap; font-size: 9px; }
        .td-dur    { color: #0284c7; font-weight: bold; white-space: nowrap; }

        /* ── Badges ──────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
            white-space: nowrap;
        }

        .badge-completado { background: #dcfce7; color: #166534; }
        .badge-en-uso     { background: #dbeafe; color: #1e40af; }

        /* ── Footer ──────────────────────────────────────────── */
        .footer {
            margin-top: 24px;
            padding: 12px 28px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left  { font-size: 8px; color: #94a3b8; }
        .footer-brand { font-size: 8px; color: #cbd5e1; font-weight: bold; letter-spacing: 0.5px; text-transform: uppercase; }
        .footer-brand span { color: #38bdf8; }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-accent"></div>
        <div class="header-inner">
            <div>
                <div class="header-title">{{ $empresa->nombre }}</div>
                <div class="header-subtitle">Reporte de Uso de Equipos</div>
            </div>
            <div class="header-meta">
                <div class="header-badge">Uso de Equipos</div>
                <div class="header-date">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
                <div class="header-date" style="margin-top:2px;">Por: {{ auth()->user()->nombre }}</div>
            </div>
        </div>
    </div>

    {{-- ── Periodo ── --}}
    <div class="periodo-bar">
        <span class="periodo-label">Período:</span>
        <span class="periodo-value">{{ !empty($filtros['desde']) ? \Carbon\Carbon::parse($filtros['desde'])->format('d/m/Y') : 'Inicio' }}</span>
        <span class="periodo-sep">→</span>
        <span class="periodo-value">{{ !empty($filtros['hasta']) ? \Carbon\Carbon::parse($filtros['hasta'])->format('d/m/Y') : 'Hoy' }}</span>
        @if(!empty($filtros['activo_id']))
            <span class="periodo-sep" style="margin-left:12px;">·</span>
            <span class="periodo-label" style="margin-left:6px;">Activo filtrado</span>
        @endif
        @if(!empty($filtros['user_id']))
            <span class="periodo-sep" style="margin-left:12px;">·</span>
            <span class="periodo-label" style="margin-left:6px;">Usuario filtrado</span>
        @endif
    </div>

    {{-- ── Info bar ── --}}
    <div class="info-bar">
        <div class="info-item">
            <div class="info-dot"></div>
            <span class="info-label">Total:&nbsp;</span>
            <span class="info-value">{{ $usos->count() }} registros</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#059669"></div>
            <span class="info-label">Completados:&nbsp;</span>
            <span class="info-value">{{ $usos->whereNotNull('ended_at')->count() }}</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#d97706"></div>
            <span class="info-label">En uso:&nbsp;</span>
            <span class="info-value">{{ $usos->whereNull('ended_at')->count() }}</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#7c3aed"></div>
            <span class="info-label">Usuarios únicos:&nbsp;</span>
            <span class="info-value">{{ $usos->pluck('user_id')->unique()->count() }}</span>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="kpis">
        <div class="kpi">
            <div class="kpi-label">Total registros</div>
            <div class="kpi-value blue">{{ $usos->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Completados</div>
            <div class="kpi-value green">{{ $usos->whereNotNull('ended_at')->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">En uso ahora</div>
            <div class="kpi-value amber">{{ $usos->whereNull('ended_at')->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Usuarios únicos</div>
            <div class="kpi-value violet">{{ $usos->pluck('user_id')->unique()->count() }}</div>
        </div>
    </div>

    {{-- ── Section label ── --}}
    <div class="section-title">
        <div class="section-line"></div>
        <div class="section-label">Historial de uso de equipos</div>
        <div class="section-line"></div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Activo</th>
                    <th>Usuario</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Duración</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usos as $i => $uso)
                    <tr>
                        <td class="td-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="td-name">{{ $uso->activo?->nombre ?? '—' }}</div>
                            @if($uso->activo?->codigo)
                                <div class="td-muted" style="font-size:8px;margin-top:1px;font-family:monospace;">{{ $uso->activo->codigo }}</div>
                            @endif
                        </td>
                        <td>
                            @if($uso->user)
                                <div style="font-weight:600;color:#1e293b;">{{ $uso->user->nombre }} {{ $uso->user->apellido }}</div>
                                <div class="td-muted" style="font-size:8px;margin-top:1px;">{{ $uso->user->email }}</div>
                            @else
                                <span class="td-muted">—</span>
                            @endif
                        </td>
                        <td class="td-date">{{ $uso->started_at->format('d/m/Y') }}<br><span style="color:#94a3b8;">{{ $uso->started_at->format('H:i') }}</span></td>
                        <td class="td-date">
                            @if($uso->ended_at)
                                {{ $uso->ended_at->format('d/m/Y') }}<br><span style="color:#94a3b8;">{{ $uso->ended_at->format('H:i') }}</span>
                            @else
                                <span class="td-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($uso->ended_at)
                                <span class="td-dur">{{ $uso->started_at->diffForHumans($uso->ended_at, true) }}</span>
                            @else
                                <span class="td-muted">En curso</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $uso->ended_at ? 'badge-completado' : 'badge-en-uso' }}">
                                {{ $uso->ended_at ? 'Completado' : 'En uso' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-left">
            Documento generado automáticamente · {{ $empresa->nombre }} · Confidencial
        </div>
        <div class="footer-brand">
            <span>Nex</span>Trace
        </div>
    </div>

</body>
</html>