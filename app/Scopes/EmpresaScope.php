<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class EmpresaScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // Use Auth facade for static context
        if (! \Illuminate\Support\Facades\Auth::check()) return;

        $user = \Illuminate\Support\Facades\Auth::user();

        // Super admin ve todo — no aplicar filtro
        if ((method_exists($user, 'esSuperAdmin') && is_callable([$user, 'esSuperAdmin']) && $user->esSuperAdmin()) || (property_exists($user, 'is_super_admin') && $user->is_super_admin)) return;

        if ($user->empresa_id) {
            $modelInstance = $builder->getModel();
            $table = method_exists($modelInstance, 'getTable') ? $modelInstance->getTable() : (is_object($model) && method_exists($model, 'getTable') ? $model->getTable() : null);
            if ($table !== null) {
                $builder->where(
                    $table . '.empresa_id',
                    $user->empresa_id
                );
            }
        }
    }
}