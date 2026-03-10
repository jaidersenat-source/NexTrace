<?php

namespace App\Services;

use App\Models\Activo;
use App\Models\AssetUsage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\NotificacionService;

class AssetUsageService
{


public function __construct(
    protected NotificacionService $notificacionService
) {}
    /**
     * Toma o libera un activo según el estado actual.
     */
    public function toggleUsage(Activo $activo, User $user, ?string $observaciones = null): array
{
    return DB::transaction(function () use ($activo, $user, $observaciones) {

        $usoActual = AssetUsage::withoutGlobalScopes()
            ->where('activo_id', $activo->id)
            ->whereNull('ended_at')
            ->first();

        if (! $usoActual) {
            AssetUsage::create([
                'empresa_id' => $user->empresa_id,
                'activo_id'  => $activo->id,
                'user_id'    => $user->id,
                'started_at' => now(),
            ]);

            $this->notificacionService->equipoTomado($activo, $user);

            return ['accion' => 'tomado', 'mensaje' => 'Equipo tomado correctamente.'];
        }

        if ($usoActual->user_id === $user->id) {
            $usoActual->update([
                'ended_at'      => now(),
                'observaciones' => $observaciones,
            ]);

            $duracion = $usoActual->started_at->diffForHumans(now(), true);
            $this->notificacionService->equipoLiberado($activo, $user, $duracion);

            return [
                'accion'   => 'liberado',
                'mensaje'  => 'Equipo liberado correctamente.',
                'duracion' => $duracion,
                'uso'      => $usoActual->fresh(),
            ];
        }

        throw new \RuntimeException(
            "Este equipo está en uso por {$usoActual->user->nombre}."
        );
    });
}
    public function historial(Activo $activo, int $limite = 20)
    {
        return AssetUsage::withoutGlobalScopes()
            ->where('activo_id', $activo->id)
            ->with('user')
            ->latest('started_at')
            ->take($limite)
            ->get();
    }
}