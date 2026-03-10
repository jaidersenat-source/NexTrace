<?php

namespace App\Models;

use App\Traits\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory, BelongsToEmpresa;

    protected $table = 'notificaciones';

    protected $fillable = [
        'empresa_id',
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'icono',
        'url',
        'leida_at',
    ];

    protected $casts = [
        'leida_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estaLeida(): bool
    {
        return ! is_null($this->leida_at);
    }

    // Scope solo no leídas
    public function scopeNoLeidas($query)
    {
        return $query->whereNull('leida_at');
    }
}