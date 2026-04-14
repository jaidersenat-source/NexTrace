<?php

namespace App\Policies;

use App\Models\Empresa;
use App\Models\User;

class EmpresaPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->esSuperAdmin()) return true;
        return null;
    }

    public function update(User $user, Empresa $empresa): bool
    {
        // Permitir que cualquier usuario con rol 'admin' acceda a la configuración.
        // Antes se requería que el admin perteneciera a la misma empresa; ahora
        // los admins pueden acceder independientemente de `empresa_id`.
        return $user->esAdmin();
    }
}