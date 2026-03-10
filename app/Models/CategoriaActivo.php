<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaActivo extends Model
{
    use HasFactory;

    protected $table = 'categoria_activos';

    protected $fillable = [
        'empresa_id',
        'nombre',
        'icono',
        'campos',
        'activo',
    ];

    protected $casts = [
        'campos' => 'array',
        'activo' => 'boolean',
    ];

    public function activos()
    {
        return $this->hasMany(Activo::class, 'categoria_id');
    }

    // Devuelve categorías globales + las de la empresa
    public static function disponiblesParaEmpresa(int $empresaId)
    {
        return static::where(function ($q) use ($empresaId) {
            $q->whereNull('empresa_id')        // globales del sistema
              ->orWhere('empresa_id', $empresaId); // propias de la empresa
        })
        ->where('activo', true)
        ->orderBy('nombre')
        ->get();
    }
}