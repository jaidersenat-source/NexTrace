<?php

namespace App\Console\Commands;

use App\Models\Mantenimiento;
use App\Services\NotificacionService;
use Illuminate\Console\Command;

class EnviarAlertasMantenimiento extends Command
{
    protected $signature   = 'mantenimientos:alertas';
    protected $description = 'Envía alertas de mantenimientos próximos y vencidos';

    public function handle(NotificacionService $service): void
    {
        // Próximos en 3 días
        $proximos = Mantenimiento::with(['activo'])
            ->proximos(3)
            ->get();

        foreach ($proximos as $m) {
            $service->notificarAdmins(
                empresaId: $m->empresa_id,
                tipo:      'mantenimiento_proximo',
                titulo:    'Mantenimiento próximo',
                mensaje:   "'{$m->titulo}' para '{$m->activo->nombre}' está programado en {$m->diasRestantes()} días.",
                icono:     '⏰',
                url:       route('mantenimientos.show', $m),
            );
        }

        // Vencidos sin completar
        $vencidos = Mantenimiento::with(['activo'])
            ->vencidos()
            ->get();

        foreach ($vencidos as $m) {
            $service->notificarAdmins(
                empresaId: $m->empresa_id,
                tipo:      'mantenimiento_vencido',
                titulo:    'Mantenimiento vencido',
                mensaje:   "'{$m->titulo}' para '{$m->activo->nombre}' estaba programado para el {$m->programado_at->format('d/m/Y')} y no se completó.",
                icono:     '🚨',
                url:       route('mantenimientos.show', $m),
            );
        }

        $this->info("✅ Alertas enviadas: {$proximos->count()} próximos, {$vencidos->count()} vencidos.");
    }
}