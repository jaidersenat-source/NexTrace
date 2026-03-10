<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->esSuperAdmin()) return true;
        return null;
    }

    // Solo admin puede ver usuarios de su empresa
    public function viewAny(User $user): bool
    {
        return $user->esAdmin();
    }

    public function create(User $user): bool
    {
        return $user->esAdmin();
    }

    // Admin solo puede gestionar usuarios de su misma empresa
    public function update(User $user, User $modelo): bool
    {
        return $user->esAdmin()
            && $user->empresa_id === $modelo->empresa_id
            && $user->id !== $modelo->id; // no editarse a sí mismo de rol
    }

    public function delete(User $user, User $modelo): bool
    {
        return $user->esAdmin()
            && $user->empresa_id === $modelo->empresa_id
            && $user->id !== $modelo->id;
    }
}