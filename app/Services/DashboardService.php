<?php

namespace App\Services;

use App\Models\Activo;
use App\Models\ActivityLog;
use App\Models\AssetUsage;
use App\Models\Mantenimiento;
use App\Models\User;

class DashboardService
{
    public function metricas(): array
    {
        return [
            'activos'         => $this->metricasActivos(),
            'mantenimientos'  => $this->metricasMantenimientos(),
            'uso'             => $this->metricasUso(),
            'usuarios'        => $this->metricasUsuarios(),
        ];
    }

    // ─── Activos ──────────────────────────────────────────────
    private function metricasActivos(): array
    {
        $porEstado = Activo::selectRaw('estado, COUNT(*) as total, SUM(valor) as valor')
            ->groupBy('estado')
            ->get()
            ->keyBy('estado');

        $porMes = Activo::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[$i] = $porMes[$i] ?? 0;
        }

        return [
            'total'         => Activo::count(),
            'valor_total'   => Activo::sum('valor'),
            'activos'       => $porEstado['activo']->total        ?? 0,
            'mantenimiento' => $porEstado['mantenimiento']->total ?? 0,
            'baja'          => $porEstado['baja']->total          ?? 0,
            'en_uso'        => AssetUsage::whereNull('ended_at')->count(),
            'por_mes'       => array_values($meses),
        ];
    }

    // ─── Mantenimientos ───────────────────────────────────────
    private function metricasMantenimientos(): array
    {
        $porMes = Mantenimiento::selectRaw('MONTH(programado_at) as mes, COUNT(*) as total')
            ->whereYear('programado_at', now()->year)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[$i] = $porMes[$i] ?? 0;
        }

        return [
            'total'       => Mantenimiento::count(),
            'pendientes'  => Mantenimiento::pendientes()->count(),
            'vencidos'    => Mantenimiento::vencidos()->count(),
            'proximos'    => Mantenimiento::proximos(7)->count(),
            'completados' => Mantenimiento::where('estado', 'completado')->count(),
            'costo_total' => Mantenimiento::where('estado', 'completado')->sum('costo'),
            'por_mes'     => array_values($meses),
        ];
    }

    // ─── Uso de equipos ───────────────────────────────────────
    private function metricasUso(): array
    {
        $usosPorMes = AssetUsage::selectRaw('MONTH(started_at) as mes, COUNT(*) as total')
            ->whereYear('started_at', now()->year)
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[$i] = $usosPorMes[$i] ?? 0;
        }

        // Top 5 activos más usados
        $topActivos = AssetUsage::selectRaw('activo_id, COUNT(*) as total_usos')
            ->with('activo:id,nombre')
            ->groupBy('activo_id')
            ->orderByDesc('total_usos')
            ->take(5)
            ->get();

        return [
            'total_usos'   => AssetUsage::count(),
            'usos_hoy'     => AssetUsage::whereDate('started_at', today())->count(),
            'en_uso_ahora' => AssetUsage::whereNull('ended_at')->count(),
            'por_mes'      => array_values($meses),
            'top_activos'  => $topActivos,
        ];
    }

    // ─── Usuarios ─────────────────────────────────────────────
    private function metricasUsuarios(): array
    {
        return [
            'total'    => User::where('empresa_id', auth()->user()->empresa_id)->count(),
            'activos'  => User::where('empresa_id', auth()->user()->empresa_id)
                              ->where('activo', true)->count(),
            'admins'   => User::where('empresa_id', auth()->user()->empresa_id)
                              ->where('rol', 'admin')->count(),
        ];
    }

    // ─── Actividad reciente ───────────────────────────────────
    public function actividadReciente(int $limite = 8)
    {
        return ActivityLog::with('user')
            ->latest()
            ->take($limite)
            ->get();
    }

    // ─── Próximos mantenimientos ──────────────────────────────
    public function proximosMantenimientos(int $limite = 5)
    {
        return Mantenimiento::with('activo:id,nombre')
            ->proximos(30)
            ->orderBy('programado_at')
            ->take($limite)
            ->get();
    }

    // ─── Equipos en uso ahora ─────────────────────────────────
    public function equiposEnUso(int $limite = 5)
    {
        return AssetUsage::with(['activo:id,nombre', 'user:id,nombre,apellido'])
            ->whereNull('ended_at')
            ->latest('started_at')
            ->take($limite)
            ->get();
    }
}