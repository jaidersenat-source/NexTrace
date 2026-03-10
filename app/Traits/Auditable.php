<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        // Registrar creación
        static::created(function ($model) {
            static::registrarLog('create', $model);
        });

        // Registrar actualización con cambios
        static::updated(function ($model) {
            static::registrarLog('update', $model, $model->getChanges(), $model->getOriginal());
        });

        // Registrar eliminación (soft o hard delete)
        static::deleted(function ($model) {
            static::registrarLog('delete', $model);
        });
    }

    protected static function registrarLog(
        string $action,
        $model,
        array $nuevo = [],
        array $anterior = []
    ): void {
        // No registrar si no hay usuario autenticado (seeders, comandos)
        if (! auth()->check()) return;

        $changes = null;

        if ($action === 'update' && ! empty($nuevo)) {
            // Filtrar campos sensibles
            $excluir = ['password', 'remember_token', 'updated_at'];
            $changes = [
                'antes'  => collect($anterior)->except($excluir)->only(array_keys($nuevo))->toArray(),
                'despues' => collect($nuevo)->except($excluir)->toArray(),
            ];
        }

        ActivityLog::create([
            'empresa_id'  => auth()->user()->empresa_id,
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model'       => get_class($model),
            'model_id'    => $model->getKey(),
            'description' => static::generarDescripcion($action, $model),
            'changes'     => $changes,
        ]);
    }

    protected static function generarDescripcion(string $action, $model): string
    {
        $modelName = class_basename($model);
        $nombre    = $model->nombre ?? "ID {$model->getKey()}";

        return match($action) {
            'create' => "{$modelName} '{$nombre}' creado.",
            'update' => "{$modelName} '{$nombre}' actualizado.",
            'delete' => "{$modelName} '{$nombre}' eliminado.",
            default  => "{$action} sobre {$modelName}.",
        };
    }
}