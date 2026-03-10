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
        return $user->esAdmin() && $user->empresa_id === $empresa->id;
    }
}