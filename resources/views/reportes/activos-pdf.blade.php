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
            padding: 0;
            margin-bottom: 0;
            overflow: hidden;
        }

        .header-accent {
            position: absolute;
            top: 0; left: 0;
            width: 6px;
            height: 100%;
            background: linear-gradient(180deg, #6366f1, #0f4cdb);
        }

        .header-inner {
            padding: 22px 28px 22px 36px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-icon {
            width: 36px;
            height: 36px;
            background: rgba(99, 102, 241, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(99, 102, 241, 0.3);
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

        .header-meta {
            text-align: right;
        }

        .header-badge {
            display: inline-block;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #a5b4fc;
            font-size: 9px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .header-date {
            color: #64748b;
            font-size: 9px;
        }

        /* ── Info bar ────────────────────────────────────────── */
        .info-bar {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 9px;
            color: #64748b;
        }

        .info-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #6366f1;
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
            padding: 14px 16px;
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
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1;
        }

        .kpi-value.indigo { color: #4f46e5; }
        .kpi-value.green  { color: #059669; }
        .kpi-value.amber  { color: #d97706; }
        .kpi-value.red    { color: #dc2626; }

        /* ── Section title ───────────────────────────────────── */
        .section-title {
            margin: 0 28px 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-line {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #1e293b;
            color: #94a3b8;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 9px 12px;
            text-align: left;
        }

        thead th:first-child {
            color: #475569;
            width: 28px;
        }

        tbody tr { background: #ffffff; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:last-child td { border-bottom: none; }

        tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 9.5px;
            color: #334155;
            vertical-align: middle;
        }

        .td-num {
            color: #94a3b8;
            font-size: 9px;
            font-weight: bold;
        }

        .td-name {
            font-weight: bold;
            color: #0f172a;
            font-size: 10px;
        }

        .td-muted { color: #94a3b8; }

        .td-money {
            font-weight: bold;
            color: #0f172a;
            font-variant-numeric: tabular-nums;
        }

        /* ── Badges ──────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
        }

        .badge-green  { background: #dcfce7; color: #166534; }
        .badge-yellow { background: #fef9c3; color: #854d0e; }
        .badge-red    { background: #fee2e2; color: #991b1b; }
        .badge-gray   { background: #f1f5f9; color: #64748b; }

        /* ── Footer ──────────────────────────────────────────── */
        .footer {
            margin-top: 24px;
            padding: 12px 28px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-left {
            font-size: 8px;
            color: #94a3b8;
        }

        .footer-brand {
            font-size: 8px;
            color: #cbd5e1;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .footer-brand span { color: #6366f1; }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-accent"></div>
        <div class="header-inner">
            <div class="header-logo">
                <div>
                    <div class="header-title">{{ $empresa->nombre }}</div>
                    <div class="header-subtitle">Reporte de Inventario de Activos</div>
                </div>
            </div>
            <div class="header-meta">
                <div class="header-badge">Activos</div>
                <div class="header-date">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i') }}</div>
                <div class="header-date" style="margin-top:2px;">Por: {{ auth()->user()->nombre }}</div>
            </div>
        </div>
    </div>

    {{-- ── Info bar de filtros ── --}}
    <div class="info-bar">
        <div class="info-item">
            <div class="info-dot"></div>
            <span class="info-label">Total registros:&nbsp;</span>
            <span class="info-value">{{ $activos->count() }}</span>
        </div>
        @if(!empty($filtros['estado']))
            <div class="info-item">
                <div class="info-dot"></div>
                <span class="info-label">Estado:&nbsp;</span>
                <span class="info-value">{{ ucfirst($filtros['estado']) }}</span>
            </div>
        @endif
        @if(!empty($filtros['categoria_id']))
            <div class="info-item">
                <div class="info-dot"></div>
                <span class="info-label">Categoría:&nbsp;</span>
                <span class="info-value">Filtrada</span>
            </div>
        @endif
        <div class="info-item">
            <div class="info-dot" style="background:#94a3b8"></div>
            <span class="info-label">Fecha:&nbsp;</span>
            <span class="info-value">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="kpis">
        <div class="kpi">
            <div class="kpi-label">Total activos</div>
            <div class="kpi-value indigo">{{ $activos->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Valor total</div>
            <div class="kpi-value green">${{ number_format($activos->sum('valor'), 0, ',', '.') }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">En uso</div>
            <div class="kpi-value amber">{{ $activos->filter(fn($a) => $a->estaEnUso())->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">En mantenimiento</div>
            <div class="kpi-value red">{{ $activos->where('estado','mantenimiento')->count() }}</div>
        </div>
    </div>

    {{-- ── Section label ── --}}
    <div class="section-title">
        <div class="section-line"></div>
        <div class="section-label">Listado de activos</div>
        <div class="section-line"></div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Estado</th>
                    <th>Valor</th>
                    <th>En uso por</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activos as $i => $activo)
                    <tr>
                        <td class="td-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="td-name">{{ $activo->nombre }}</div>
                            @if($activo->numero_serie)
                                <div class="td-muted" style="font-size:8px;margin-top:1px;">{{ $activo->numero_serie }}</div>
                            @endif
                        </td>
                        <td class="td-muted">{{ $activo->categoria?->nombre ?? '—' }}</td>
                        <td class="td-muted" style="font-family:monospace;">{{ $activo->codigo ?? '—' }}</td>
                        <td>
                            @php
                                $badgeClass = match($activo->estado) {
                                    'activo'        => 'badge-green',
                                    'mantenimiento' => 'badge-yellow',
                                    'baja'          => 'badge-red',
                                    default         => 'badge-gray',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $activo->estadoLabel() }}</span>
                        </td>
                        <td class="td-money">${{ number_format($activo->valor, 2) }}</td>
                        <td>
                            @if($activo->usoActual?->user)
                                <div style="font-weight:600;color:#1e293b;">{{ $activo->usoActual->user->nombre }}</div>
                            @else
                                <span class="td-muted">—</span>
                            @endif
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