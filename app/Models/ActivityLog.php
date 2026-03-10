<?php

namespace App\Models;

use App\Traits\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory, BelongsToEmpresa;

    protected $fillable = [
        'empresa_id',
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Helper: etiqueta legible de la acción
    public function actionLabel(): string
    {
        return match($this->action) {
            'create' => 'Creación',
            'update' => 'Actualización',
            'delete' => 'Eliminación',
            default  => $this->action,
        };
    }

    public function actionColor(): string
    {
        return match($this->action) {
            'create' => 'green',
            'update' => 'blue',
            'delete' => 'red',
            default  => 'gray',
        };
    }

    // Nombre corto del modelo (Activo, Empleado, etc.)
    public function modelName(): string
    {
        return class_basename($this->model);
    }
}