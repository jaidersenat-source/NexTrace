<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\AssetUsage;
use App\Models\Mantenimiento;
use App\Models\User;
use App\Services\ActivoService;
use App\Services\ReporteService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    public function __construct(
        protected ReporteService $reporteService,
        protected ActivoService  $activoService,
    ) {}

    public function index(): View
    {
        $categorias = $this->activoService->categoriasDisponibles();
        $activos    = Activo::orderBy('nombre')->get(['id', 'nombre']);
        $usuarios   = User::where('empresa_id', Auth::user()->empresa_id)
                          ->orderBy('nombre')
                          ->get(['id', 'nombre', 'apellido']);

        return view('reportes.index', compact('categorias', 'activos', 'usuarios'));
    }

    // ─── Previews (AJAX) ──────────────────────────────────────

    public function previewActivos(Request $request)
    {
        $empresaId = Auth::user()->empresa_id;
        $filtros   = $request->only(['estado', 'categoria_id']);

        $query = Activo::withoutGlobalScopes()
            ->with('categoria')
            ->where('empresa_id', $empresaId);

        if (! empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (! empty($filtros['categoria_id'])) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }

        $activos = $query->orderBy('nombre')->get(['id', 'nombre', 'estado', 'categoria_id', 'codigo', 'valor']);

        return response()->json([
            'total' => $activos->count(),
            'datos' => $activos->map(fn($a) => [
                'nombre'    => $a->nombre,
                'categoria' => $a->categoria?->nombre ?? '—',
                'estado'    => $a->estado,
                'codigo'    => $a->codigo ?? '—',
                'valor'     => $a->valor !== null ? '$' . number_format((float) $a->valor, 2) : '—',
            ]),
        ]);
    }

    public function previewUso(Request $request)
    {
        $empresaId = Auth::user()->empresa_id;
        $filtros   = $request->only(['activo_id', 'user_id', 'desde', 'hasta']);

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

        $usos = $query->orderByDesc('started_at')->get();

        return response()->json([
            'total' => $usos->count(),
            'datos' => $usos->map(fn($u) => [
                'activo'     => $u->activo?->nombre ?? '—',
                'usuario'    => $u->user ? $u->user->nombre . ' ' . $u->user->apellido : '—',
                'inicio'     => $u->started_at?->format('d/m/Y H:i') ?? '—',
                'fin'        => $u->ended_at?->format('d/m/Y H:i') ?? 'En uso',
                'duracion'   => $u->ended_at
                                    ? $u->started_at->diffForHumans($u->ended_at, true)
                                    : '—',
            ]),
        ]);
    }

    public function previewMantenimientos(Request $request)
    {
        $empresaId = Auth::user()->empresa_id;
        $filtros   = $request->only(['estado', 'tipo', 'desde', 'hasta']);

        $query = Mantenimiento::withoutGlobalScopes()
            ->with(['activo', 'responsable'])
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

        return response()->json([
            'total' => $mantenimientos->count(),
            'datos' => $mantenimientos->map(fn($m) => [
                'titulo'      => $m->titulo,
                'activo'      => $m->activo?->nombre ?? '—',
                'tipo'        => $m->tipoLabel(),
                'estado'      => $m->estadoLabel(),
                'programado'  => $m->programado_at?->format('d/m/Y') ?? '—',
                'responsable' => $m->responsable?->name ?? '—',
                'costo'       => $m->costo ? '$' . number_format($m->costo, 2) : '—',
            ]),
        ]);
    }

    // ─── Activos ──────────────────────────────────────────────
    public function activosExcel(Request $request)
    {
        return $this->reporteService->exportarActivosExcel(
            Auth::user()->empresa_id,
            $request->only(['estado', 'categoria_id'])
        );
    }

    public function activosPdf(Request $request)
    {
        return $this->reporteService->exportarActivosPdf(
            Auth::user()->empresa_id,
            $request->only(['estado', 'categoria_id'])
        );
    }

    // ─── Uso de equipos ───────────────────────────────────────
    public function usoExcel(Request $request)
    {
        return $this->reporteService->exportarUsoExcel(
            Auth::user()->empresa_id,
            $request->only(['activo_id', 'user_id', 'desde', 'hasta'])
        );
    }

    public function usoPdf(Request $request)
    {
        return $this->reporteService->exportarUsoPdf(
            Auth::user()->empresa_id,
            $request->only(['activo_id', 'user_id', 'desde', 'hasta'])
        );
    }

    // ─── Mantenimientos ───────────────────────────────────────
    public function mantenimientosExcel(Request $request)
    {
        return $this->reporteService->exportarMantenimientosExcel(
            Auth::user()->empresa_id,
            $request->only(['estado', 'tipo', 'desde', 'hasta'])
        );
    }

    public function mantenimientosPdf(Request $request)
    {
        return $this->reporteService->exportarMantenimientosPdf(
            Auth::user()->empresa_id,
            $request->only(['estado', 'tipo', 'desde', 'hasta'])
        );
    }
}