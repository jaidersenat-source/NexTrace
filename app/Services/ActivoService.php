<?php

namespace App\Services;

use App\Models\Activo;
use App\Models\CategoriaActivo;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\NotificacionService;

class ActivoService
{
    public function __construct(
    protected QrService           $qrService,
    protected NotificacionService $notificacionService,
) {}
    public function listar(array $filtros = []): LengthAwarePaginator
    {
        $query = Activo::with('categoria')->latest();

        if (! empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (! empty($filtros['categoria_id'])) {
            $query->where('categoria_id', $filtros['categoria_id']);
        }

        if (! empty($filtros['buscar'])) {
            $query->where(function ($q) use ($filtros) {
                $q->where('nombre', 'like', '%' . $filtros['buscar'] . '%')
                  ->orWhere('codigo', 'like', '%' . $filtros['buscar'] . '%');
            });
        }

        return $query->paginate(15)->withQueryString();
    }

    public function crear(array $datos): Activo
    {
        $activo = Activo::create($datos);
        $this->qrService->generarYGuardar($activo);
        return $activo;
    }

   public function actualizar(Activo $activo, array $datos): Activo
{
    $estadoAnterior = $activo->estado;

    $activo->update($datos);

    // Disparar notificaciones según cambio de estado
    if (isset($datos['estado']) && $datos['estado'] !== $estadoAnterior) {
        match($datos['estado']) {
            'mantenimiento' => $this->notificacionService->activoPasadoAMantenimiento($activo),
            'baja'          => $this->notificacionService->activoDadoDeBaja($activo),
            default         => null,
        };
    }

    return $activo->fresh();
}

    public function eliminar(Activo $activo): void
    {
        $activo->delete();
    }

    public function metricas(): array
    {
        $porEstado = Activo::selectRaw('estado, COUNT(*) as total, SUM(valor) as valor_total')
            ->groupBy('estado')->get()->keyBy('estado');

        $porMes = Activo::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')->pluck('total', 'mes')->toArray();

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
            'valor_activos' => $porEstado['activo']->valor_total  ?? 0,
            'por_mes'       => array_values($meses),
        ];
    }

    public function categoriasDisponibles()
    {
        return CategoriaActivo::disponiblesParaEmpresa(
    auth()->user()->empresa_id
);
    }

    
}