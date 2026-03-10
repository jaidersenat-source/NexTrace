<?php

namespace App\Services;

use App\Models\Activo;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public function generarYGuardar(Activo $activo): string
{
    $carpeta  = "qrcodes/{$activo->empresa_id}";
    $archivo  = "{$carpeta}/{$activo->qr_token}.svg"; // ← extensión svg

    // Generar SVG del QR
    $imagen = QrCode::format('svg')
                    ->size(300)
                    ->margin(2)
                    ->generate($activo->urlPublica());

    Storage::disk('public')->put($archivo, $imagen);

    // Guardar ruta en el activo
    $activo->update(['qr_image' => $archivo]);

    return $archivo;
}

    public function urlQr(Activo $activo): ?string
    {
        if (! $activo->qr_image) return null;

        // Usar helper asset() para obtener la URL pública
        return asset('storage/' . $activo->qr_image);
    }
}