<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\User;
use App\Models\Activo;

class NotificacionService
{
    // Crear notificación para un usuario
    public function crear(
        User   $user,
        string $tipo,
        string $titulo,
        string $mensaje,
        string $icono = '🔔',
        string $url   = null
    ): Notificacion {
        return Notificacion::create([
            'empresa_id' => $user->empresa_id,
            'user_id'    => $user->id,
            'tipo'       => $tipo,
            'titulo'     => $titulo,
            'mensaje'    => $mensaje,
            'icono'      => $icono,
            'url'        => $url,
        ]);
    }

    // Notificar a todos los admins de una empresa
    public function notificarAdmins(
        int    $empresaId,
        string $tipo,
        string $titulo,
        string $mensaje,
        string $icono = '🔔',
        string $url   = null
    ): void {
        $admins = User::where('empresa_id', $empresaId)
                      ->where('rol', 'admin')
                      ->where('activo', true)
                      ->get();

        foreach ($admins as $admin) {
            $this->crear($admin, $tipo, $titulo, $mensaje, $icono, $url);
        }
    }

    // Marcar una como leída
    public function marcarLeida(Notificacion $notificacion): void
    {
        $notificacion->update(['leida_at' => now()]);
    }

    // Marcar todas como leídas
    public function marcarTodasLeidas(User $user): void
    {
        Notificacion::where('user_id', $user->id)
                    ->whereNull('leida_at')
                    ->update(['leida_at' => now()]);
    }

    // Conteo no leídas
    public function contarNoLeidas(User $user): int
    {
        return Notificacion::where('user_id', $user->id)
                           ->whereNull('leida_at')
                           ->count();
    }

    // ─── Notificaciones específicas del sistema ───────────────

    public function activoPasadoAMantenimiento(Activo $activo): void
    {
        $this->notificarAdmins(
            empresaId: $activo->empresa_id,
            tipo:      'activo_mantenimiento',
            titulo:    'Activo en mantenimiento',
            mensaje:   "El activo '{$activo->nombre}' fue marcado como en mantenimiento.",
            icono:     '🔧',
            url:       route('activos.show', $activo),
        );
    }

    public function activoDadoDeBaja(Activo $activo): void
    {
        $this->notificarAdmins(
            empresaId: $activo->empresa_id,
            tipo:      'activo_baja',
            titulo:    'Activo dado de baja',
            mensaje:   "El activo '{$activo->nombre}' fue dado de baja.",
            icono:     '⚠️',
            url:       route('activos.show', $activo),
        );
    }

    public function equipoTomado(Activo $activo, User $user): void
    {
        $this->notificarAdmins(
            empresaId: $activo->empresa_id,
            tipo:      'equipo_tomado',
            titulo:    'Equipo tomado',
            mensaje:   "{$user->nombre} {$user->apellido} tomó el equipo '{$activo->nombre}'.",
            icono:     '🔒',
            url:       route('activos.show', $activo),
        );
    }

    public function equipoLiberado(Activo $activo, User $user, string $duracion): void
    {
        $this->notificarAdmins(
            empresaId: $activo->empresa_id,
            tipo:      'equipo_liberado',
            titulo:    'Equipo liberado',
            mensaje:   "{$user->nombre} liberó '{$activo->nombre}' tras usarlo {$duracion}.",
            icono:     '🔓',
            url:       route('activos.show', $activo),
        );
    }
}