<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'empresa_id', 'nombre', 'apellido',
        'email', 'password', 'rol', 'activo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'activo'            => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function esSuperAdmin(): bool { return $this->rol === 'super_admin'; }
    public function esAdmin(): bool      { return $this->rol === 'admin'; }
    public function esEmpleado(): bool   { return $this->rol === 'empleado'; }

    public function tieneRol(string|array $roles): bool
    {
        return in_array($this->rol, (array) $roles);
    }
}