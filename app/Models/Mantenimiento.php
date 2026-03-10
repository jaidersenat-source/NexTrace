<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
{
    use HasFactory, SoftDeletes, BelongsToEmpresa, Auditable;

    protected $fillable = [
        'empresa_id', 'activo_id', 'user_id', 'responsable_id',
        'tipo', 'titulo', 'descripcion',
        'programado_at', 'completado_at',
        'estado', 'observaciones', 'costo',
    ];

    protected $casts = [
        'programado_at'  => 'datetime',
        'completado_at'  => 'datetime',
        'costo'          => 'decimal:2',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function estaVencido(): bool
    {
        return $this->estado === 'pendiente'
            && $this->programado_at->isPast();
    }

    public function diasRestantes(): int
    {
        return (int) now()->diffInDays($this->programado_at, false);
    }

    public function tipoLabel(): string
    {
        return match($this->tipo) {
            'preventivo' => 'Preventivo',
            'correctivo' => 'Correctivo',
            'revision'   => 'Revisión',
            default      => $this->tipo,
        };
    }

    public function tipoColor(): string
    {
        return match($this->tipo) {
            'preventivo' => 'blue',
            'correctivo' => 'red',
            'revision'   => 'yellow',
            default      => 'gray',
        };
    }

    public function estadoLabel(): string
    {
        return match($this->estado) {
            'pendiente'   => 'Pendiente',
            'en_proceso'  => 'En proceso',
            'completado'  => 'Completado',
            'cancelado'   => 'Cancelado',
            default       => $this->estado,
        };
    }

    public function estadoColor(): string
    {
        return match($this->estado) {
            'pendiente'   => 'yellow',
            'en_proceso'  => 'blue',
            'completado'  => 'green',
            'cancelado'   => 'red',
            default       => 'gray',
        };
    }

    // Scopes útiles
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeProximos($query, int $dias = 7)
    {
        return $query->where('estado', 'pendiente')
                     ->whereBetween('programado_at', [now(), now()->addDays($dias)]);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'pendiente')
                     ->where('programado_at', '<', now());
    }
}