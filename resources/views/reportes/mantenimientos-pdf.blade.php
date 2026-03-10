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
            background: linear-gradient(180deg, #10b981, #059669);
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
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #6ee7b7;
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
            background: #064e3b;
            padding: 8px 28px 8px 36px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid #065f46;
        }

        .periodo-label {
            font-size: 8.5px;
            color: #6ee7b7;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .periodo-sep {
            color: #065f46;
            font-size: 10px;
            margin: 0 2px;
        }

        .periodo-value {
            font-size: 9px;
            color: #a7f3d0;
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
            background: #10b981;
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
        .kpi:first-child { border-left: 3px solid #6366f1; }

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

        .kpi-value.indigo  { color: #4f46e5; }
        .kpi-value.green   { color: #059669; }
        .kpi-value.amber   { color: #d97706; }
        .kpi-value.red     { color: #dc2626; }

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

        .td-num   { color: #94a3b8; font-size: 9px; font-weight: bold; }
        .td-name  { font-weight: bold; color: #0f172a; font-size: 10px; }
        .td-muted { color: #94a3b8; }
        .td-money { font-weight: bold; color: #0f172a; }
        .td-date  { color: #475569; white-space: nowrap; }
        .td-done  { color: #059669; font-weight: bold; white-space: nowrap; }

        /* ── Badges ──────────────────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 8.5px;
            font-weight: bold;
            white-space: nowrap;
        }

        /* Estado */
        .badge-completado { background: #dcfce7; color: #166534; }
        .badge-pendiente  { background: #fef9c3; color: #854d0e; }
        .badge-en_proceso { background: #dbeafe; color: #1e40af; }
        .badge-cancelado  { background: #f1f5f9; color: #64748b; }

        /* Tipo */
        .badge-preventivo { background: #ede9fe; color: #5b21b6; }
        .badge-correctivo { background: #fee2e2; color: #991b1b; }
        .badge-revision   { background: #e0f2fe; color: #075985; }

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
        .footer-brand span { color: #10b981; }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-accent"></div>
        <div class="header-inner">
            <div>
                <div class="header-title">{{ $empresa->nombre }}</div>
                <div class="header-subtitle">Reporte de Mantenimientos</div>
            </div>
            <div class="header-meta">
                <div class="header-badge">Mantenimientos</div>
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
        @if(!empty($filtros['estado']))
            <span class="periodo-sep" style="margin-left:12px;">·</span>
            <span class="periodo-label" style="margin-left:6px;">Estado:</span>
            <span class="periodo-value">{{ ucfirst($filtros['estado']) }}</span>
        @endif
        @if(!empty($filtros['tipo']))
            <span class="periodo-sep" style="margin-left:12px;">·</span>
            <span class="periodo-label" style="margin-left:6px;">Tipo:</span>
            <span class="periodo-value">{{ ucfirst($filtros['tipo']) }}</span>
        @endif
    </div>

    {{-- ── Info bar ── --}}
    <div class="info-bar">
        <div class="info-item">
            <div class="info-dot"></div>
            <span class="info-label">Total:&nbsp;</span>
            <span class="info-value">{{ $mantenimientos->count() }} registros</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#059669"></div>
            <span class="info-label">Completados:&nbsp;</span>
            <span class="info-value">{{ $mantenimientos->where('estado','completado')->count() }}</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#d97706"></div>
            <span class="info-label">Pendientes:&nbsp;</span>
            <span class="info-value">{{ $mantenimientos->where('estado','pendiente')->count() }}</span>
        </div>
        <div class="info-item">
            <div class="info-dot" style="background:#94a3b8"></div>
            <span class="info-label">Generado:&nbsp;</span>
            <span class="info-value">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    {{-- ── KPIs ── --}}
    <div class="kpis">
        <div class="kpi">
            <div class="kpi-label">Total</div>
            <div class="kpi-value indigo">{{ $mantenimientos->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Completados</div>
            <div class="kpi-value green">{{ $mantenimientos->where('estado','completado')->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Pendientes</div>
            <div class="kpi-value amber">{{ $mantenimientos->where('estado','pendiente')->count() }}</div>
        </div>
        <div class="kpi">
            <div class="kpi-label">Costo total</div>
            <div class="kpi-value red">${{ number_format($mantenimientos->sum('costo'), 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- ── Section label ── --}}
    <div class="section-title">
        <div class="section-line"></div>
        <div class="section-label">Historial de mantenimientos</div>
        <div class="section-line"></div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Activo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Programado</th>
                    <th>Completado</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mantenimientos as $i => $m)
                    <tr>
                        <td class="td-num">{{ $i + 1 }}</td>
                        <td>
                            <div class="td-name">{{ $m->titulo }}</div>
                            @if($m->responsable)
                                <div class="td-muted" style="font-size:8px;margin-top:1px;">{{ $m->responsable->name }}</div>
                            @endif
                        </td>
                        <td class="td-muted">{{ $m->activo?->nombre ?? '—' }}</td>
                        <td>
                            <span class="badge badge-{{ $m->tipo }}">{{ $m->tipoLabel() }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $m->estado }}">{{ $m->estadoLabel() }}</span>
                        </td>
                        <td class="td-date">{{ $m->programado_at->format('d/m/Y') }}</td>
                        <td>
                            @if($m->completado_at)
                                <span class="td-done">{{ $m->completado_at->format('d/m/Y') }}</span>
                            @else
                                <span class="td-muted">—</span>
                            @endif
                        </td>
                        <td class="td-money">
                            {{ $m->costo ? '$'.number_format($m->costo, 2) : '—' }}
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