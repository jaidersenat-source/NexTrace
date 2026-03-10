<?php

namespace App\Services;

use App\Exports\ActivosExport;
use App\Exports\UsoActivosExport;
use App\Exports\MantenimientosExport;
use App\Models\Activo;
use App\Models\AssetUsage;
use App\Models\Mantenimiento;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReporteService
{
    // ─── Activos ──────────────────────────────────────────────
    public function exportarActivosExcel(int $empresaId, array $filtros = [])
    {
        return Excel::download(
            new ActivosExport($empresaId, $filtros),
            'activos-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportarActivosPdf(int $empresaId, array $filtros = [])
    {
        $query = Activo::withoutGlobalScopes()
            ->with(['categoria', 'usoActual.user'])
            ->where('empresa_id', $empresaId);

        if (! empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (! empty($filtros['categoria_id'])) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }

        $activos = $query->orderBy('nombre')->get();
        $empresa = Auth::check() ? Auth::user()->empresa : null;

        return Pdf::loadView('reportes.activos-pdf', compact('activos', 'empresa', 'filtros'))
            ->setPaper('a4', 'landscape')
            ->download('activos-' . now()->format('Y-m-d') . '.pdf');
    }

    // ─── Uso de equipos ───────────────────────────────────────
    public function exportarUsoExcel(int $empresaId, array $filtros = [])
    {
        return Excel::download(
            new UsoActivosExport($empresaId, $filtros),
            'uso-equipos-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportarUsoPdf(int $empresaId, array $filtros = [])
    {
        $query = AssetUsage::withoutGlobalScopes()
            ->with(['activo', 'user'])
            ->where('empresa_id', $empresaId);

        if (! empty($filtros['activo_id'])) {
            $query->where('activo_id', $filtros['activo_id']);
        }

        if (! empty($filtros['user_id'])) {
            $query->where('user_id', $filtros['user_id']);
        }

        if (! empty($filtros['desde'])) {
            $query->whereDate('started_at', '>=', $filtros['desde']);
        }

        if (! empty($filtros['hasta'])) {
            $query->whereDate('started_at', '<=', $filtros['hasta']);
        }

        $usos    = $query->orderByDesc('started_at')->get();
        $empresa = Auth::user()->empresa;

        return Pdf::loadView('reportes.uso-pdf', compact('usos', 'empresa', 'filtros'))
            ->setPaper('a4', 'landscape')
            ->download('uso-equipos-' . now()->format('Y-m-d') . '.pdf');
    }

    // ─── Mantenimientos ───────────────────────────────────────
    public function exportarMantenimientosExcel(int $empresaId, array $filtros = [])
    {
        return Excel::download(
            new MantenimientosExport($empresaId, $filtros),
            'mantenimientos-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportarMantenimientosPdf(int $empresaId, array $filtros = [])
    {
        $query = Mantenimiento::withoutGlobalScopes()
            ->with(['activo', 'user'])
            ->where('empresa_id', $empresaId);

        if (! empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (! empty($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }

        if (! empty($filtros['desde'])) {
            $query->whereDate('programado_at', '>=', $filtros['desde']);
        }

        if (! empty($filtros['hasta'])) {
            $query->whereDate('programado_at', '<=', $filtros['hasta']);
        }

        $mantenimientos = $query->orderByDesc('programado_at')->get();
        $empresa        = Auth::user()->empresa;

        return Pdf::loadView('reportes.mantenimientos-pdf', compact('mantenimientos', 'empresa', 'filtros'))
            ->setPaper('a4', 'landscape')
            ->download('mantenimientos-' . now()->format('Y-m-d') . '.pdf');
    }
}