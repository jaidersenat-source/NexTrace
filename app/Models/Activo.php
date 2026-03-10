<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Activo extends Model
{
    use HasFactory, SoftDeletes, BelongsToEmpresa, Auditable;

    protected $fillable = [
        'empresa_id', 'categoria_id', 'nombre', 'codigo',
        'descripcion', 'valor', 'estado',
        'atributos', 'qr_token', 'qr_image',
    ];

    protected $casts = [
        'valor'     => 'decimal:2',
        'atributos' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($activo) {
            if (empty($activo->qr_token)) {
                $activo->qr_token = (string) Str::uuid();
            }
        });
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaActivo::class, 'categoria_id');
    }

    public function usos()
    {
        return $this->hasMany(AssetUsage::class);
    }

    public function usoActual()
    {
        return $this->hasOne(AssetUsage::class)
                    ->whereNull('ended_at')
                    ->latest();
    }

    public function estaEnUso(): bool
    {
        return $this->usoActual()->exists();
    }

    public function urlPublica(): string
    {
        return url("/a/{$this->qr_token}");
    }

    // Devuelve atributo específico
    public function atributo(string $clave): mixed
    {
        return $this->atributos[$clave] ?? null;
    }

    public function estadoLabel(): string
    {
        return match($this->estado) {
            'activo'        => 'Activo',
            'mantenimiento' => 'En mantenimiento',
            'baja'          => 'Dado de baja',
            default         => $this->estado,
        };
    }

    public function estadoColor(): string
    {
        return match($this->estado) {
            'activo'        => 'green',
            'mantenimiento' => 'yellow',
            'baja'          => 'red',
            default         => 'gray',
        };
    }

    public function mantenimientos()
{
    return $this->hasMany(Mantenimiento::class);
}

public function proximoMantenimiento()
{
    return $this->hasOne(Mantenimiento::class)
                ->where('estado', 'pendiente')
                ->orderBy('programado_at');
}
}