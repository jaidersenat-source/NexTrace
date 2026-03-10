<?php

namespace App\Policies;

use App\Models\Activo;
use App\Models\User;

class ActivoPolicy
{
    // Superadmin puede todo
    public function before(User $user): ?bool
    {
        if ($user->esSuperAdmin()) {
            return true;
        }
        return null;
    }

    // Todos pueden ver el listado
    public function viewAny(User $user): bool
    {
        return $user->tieneRol(['admin', 'empleado']);
    }

    // Todos pueden ver detalle (de su empresa)
    public function view(User $user, Activo $activo): bool
    {
        return $user->empresa_id === $activo->empresa_id;
    }

    // Solo admin puede crear
    public function create(User $user): bool
    {
        return $user->esAdmin();
    }

    // Solo admin puede editar
    public function update(User $user, Activo $activo): bool
    {
        return $user->esAdmin() && $user->empresa_id === $activo->empresa_id;
    }

    // Solo admin puede eliminar
    public function delete(User $user, Activo $activo): bool
    {
        return $user->esAdmin() && $user->empresa_id === $activo->empresa_id;
    }
}