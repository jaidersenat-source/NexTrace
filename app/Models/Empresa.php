<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Empresa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre', 'slug', 'email', 'telefono', 'pais', 'activo',
        'logo_url', 'color_primario', 'color_secundario', 'color_sidebar',
        'plan', 'plan_vence_at', 'notas_admin',
    ];

    protected $casts = [
        'activo'        => 'boolean',
        'plan_vence_at' => 'datetime',
    ];
    public function planLabel(): string
    {
        return match($this->plan) {
            'gratuito'    => 'Gratuito',
            'basico'      => 'Básico',
            'profesional' => 'Profesional',
            'enterprise'  => 'Enterprise',
            default       => $this->plan,
        };
    }

    public function planColor(): string
    {
        return match($this->plan) {
            'gratuito'    => 'gray',
            'basico'      => 'blue',
            'profesional' => 'indigo',
            'enterprise'  => 'purple',
            default       => 'gray',
        };
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function generarSlug(string $nombre): string
    {
        $slug  = Str::slug($nombre);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }

    // Devuelve logo o placeholder
    public function logoUrl(): string
    {
        return $this->logo_url
            ? asset('storage/' . $this->logo_url)
            : asset('images/logo-default.png');
    }
}