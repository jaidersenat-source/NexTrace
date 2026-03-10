<?php


namespace App\Traits;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;

trait BelongsToEmpresa
{
    /**
     * Registra el scope y asigna empresa_id automáticamente al crear.
     */
    protected static function bootBelongsToEmpresa(): void
    {
        // 1. Aplica el filtro global por empresa
        static::addGlobalScope(new EmpresaScope());

        // 2. Asigna empresa_id automáticamente al crear un registro
        static::creating(function ($model) {
            if (Auth::check() && empty($model->empresa_id)) {
                $model->empresa_id = Auth::user()->empresa_id;
            }
        });
    }

    /**
     * Relación hacia Empresa (disponible en todos los modelos que usen el trait).
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Permite ignorar el scope cuando sea necesario (ej: super admin).
     */
    public static function sinFiltroEmpresa(): \Illuminate\Database\Eloquent\Builder
    {
        return static::withoutGlobalScope(EmpresaScope::class);
    }
}