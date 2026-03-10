<?php

namespace App\Services;

use App\Models\Activo;
use App\Models\Mantenimiento;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class MantenimientoService
{
    public function __construct(
        protected NotificacionService $notificacionService
    ) {}

    public function listar(array $filtros = []): LengthAwarePaginator
    {
        $query = Mantenimiento::with(['activo', 'user', 'responsable'])->latest('programado_at');

        if (! empty($filtros['estado'])) {
            $query->where('estado', $filtros['estado']);
        }

        if (! empty($filtros['tipo'])) {
            $query->where('tipo', $filtros['tipo']);
        }

        if (! empty($filtros['activo_id'])) {
            $query->where('activo_id', $filtros['activo_id']);
        }

        return $query->paginate(15)->withQueryString();
    }

    public function crear(array $datos, User $user): Mantenimiento
    {
        $datos['user_id']    = $user->id;
        $datos['empresa_id'] = $user->empresa_id;

        $mantenimiento = Mantenimiento::create($datos);

        // Notificar admins
        $this->notificacionService->notificarAdmins(
            empresaId: $user->empresa_id,
            tipo:      'mantenimiento_programado',
            titulo:    'Mantenimiento programado',
            mensaje:   "Se programó mantenimiento '{$mantenimiento->titulo}' para el {$mantenimiento->programado_at->format('d/m/Y')}.",
            icono:     '🔧',
            url:       route('mantenimientos.show', $mantenimiento),
        );

        return $mantenimiento;
    }

    public function actualizar(Mantenimiento $mantenimiento, array $datos): Mantenimiento
    {
        $estadoAnterior = $mantenimiento->estado;

        $mantenimiento->update($datos);

        // Si se completó, registrar fecha y notificar
        if ($datos['estado'] === 'completado' && $estadoAnterior !== 'completado') {
            $mantenimiento->update(['completado_at' => now()]);

            // Poner activo de nuevo en estado activo
            $mantenimiento->activo->update(['estado' => 'activo']);

            $this->notificacionService->notificarAdmins(
                empresaId: $mantenimiento->empresa_id,
                tipo:      'mantenimiento_completado',
                titulo:    'Mantenimiento completado',
                mensaje:   "El mantenimiento '{$mantenimiento->titulo}' fue completado.",
                icono:     '✅',
                url:       route('mantenimientos.show', $mantenimiento),
            );
        }

        return $mantenimiento->fresh();
    }

    public function marcarCompletado(Mantenimiento $mantenimiento, User $user): Mantenimiento
    {
        $mantenimiento->update([
            'estado'        => 'completado',
            'completado_at' => now(),
        ]);

        $mantenimiento->activo->update(['estado' => 'activo']);

        $this->notificacionService->notificarAdmins(
            empresaId: $mantenimiento->empresa_id,
            tipo:      'mantenimiento_completado',
            titulo:    'Mantenimiento completado',
            mensaje:   "El mantenimiento '{$mantenimiento->titulo}' fue marcado como completado por {$user->nombre} {$user->apellido}.",
            icono:     '✅',
            url:       route('mantenimientos.show', $mantenimiento),
        );

        return $mantenimiento->fresh();
    }

    public function registrarInconveniente(Mantenimiento $mantenimiento, User $user, string $observaciones, string $nuevoEstado): Mantenimiento
    {
        $mantenimiento->update([
            'estado'        => $nuevoEstado,
            'observaciones' => $observaciones,
        ]);

        $this->notificacionService->notificarAdmins(
            empresaId: $mantenimiento->empresa_id,
            tipo:      'mantenimiento_inconveniente',
            titulo:    'Inconveniente en mantenimiento',
            mensaje:   "Se reportó un inconveniente en '{$mantenimiento->titulo}' por {$user->nombre} {$user->apellido}: {$observaciones}",
            icono:     '⚠️',
            url:       route('mantenimientos.show', $mantenimiento),
        );

        return $mantenimiento->fresh();
    }

    public function metricas(): array
    {
        return [
            'total'      => Mantenimiento::count(),
            'pendientes' => Mantenimiento::pendientes()->count(),
            'vencidos'   => Mantenimiento::vencidos()->count(),
            'proximos'   => Mantenimiento::proximos(7)->count(),
            'completados'=> Mantenimiento::where('estado', 'completado')->count(),
            'costo_total'=> Mantenimiento::where('estado', 'completado')->sum('costo'),
        ];
    }
}