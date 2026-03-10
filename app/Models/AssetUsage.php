<?php

namespace App\Models;

use App\Traits\BelongsToEmpresa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetUsage extends Model
{
    use HasFactory, BelongsToEmpresa;

    protected $fillable = [
        'empresa_id',
        'activo_id',
        'user_id',
        'started_at',
        'ended_at',
        'observaciones',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function activo()
    {
        return $this->belongsTo(Activo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estaActivo(): bool
    {
        return is_null($this->ended_at);
    }

    public function duracion(): string
    {
        $fin = $this->ended_at ?? now();
        return $this->started_at->diffForHumans($fin, true);
    }
}