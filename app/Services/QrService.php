<?php

namespace App\Services;

use App\Models\Activo;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public function generarYGuardar(Activo $activo): string
    {
        $carpeta = "qrcodes/{$activo->empresa_id}";
        $archivo = "{$carpeta}/{$activo->qr_token}.svg";

        $qrSize  = 650;   // más grande para mejor resolución en grabadora láser
        $margin  = 2;

        $rawQr = QrCode::format('svg')
            ->size($qrSize)
            ->margin($margin)
            ->generate($activo->urlPublica());

        // Extraer contenido interno del SVG
        $inner = preg_replace('/<\?xml.*?\?>/s', '', $rawQr);
        $inner = preg_replace('/<svg[^>]*>(.*)<\/svg>/s', '$1', $inner);

        $empresaNombre = mb_strtoupper(optional($activo->empresa)->nombre ?? config('app.name', 'Empresa'));
        $activoNombre  = mb_strtoupper($activo->nombre ?? 'ACTIVO');

        // ── Medidas ──────────────────────────────────────────────
        $pad        = 30;          // padding lateral
        $topArea    = 120;         // altura bloque empresa (arriba) — reducido para acercar texto
        $bottomArea = 120;         // altura bloque activo  (abajo)  — reducido para acercar texto
        $width      = $qrSize + ($pad * 2);
        $height     = $topArea + $qrSize + $bottomArea;
        $centerX    = $width / 2;

        // Posición vertical centrada en cada bloque
        $topTextY    = (int) round($topArea / 2);           // empresa: centrada en bloque superior
        $bottomTextY = (int) round($topArea + $qrSize + ($bottomArea / 2)); // activo: centrada en bloque inferior

        // Separadores decorativos (líneas blancas)
        $sep1Y = $topArea;
        $sep2Y = $topArea + $qrSize;

        // Tamaño de fuente adaptado al ancho disponible
        $maxWidth      = $width - ($pad * 2);
        // Permitir fuentes mucho más grandes para impresión láser
        $fontSizeTop    = $this->calcFontSize($empresaNombre, $maxWidth, 220, 80);
        $fontSizeBottom = $this->calcFontSize($activoNombre,  $maxWidth, 220, 80);

        $fillColor = '#4b0c12';
        $textColor = '#ffffff';
        $qrBg      = '#ffffff';

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg"
     width="{$width}" height="{$height}"
     viewBox="0 0 {$width} {$height}">
  <defs>
    <style>
      .bg        { fill: {$fillColor}; }
      .qr-bg     { fill: {$qrBg}; }
      .qr g path { fill: {$fillColor}; }
      .top-text  {
        fill: {$textColor};
        font-family: Arial Black, Arial, Helvetica, sans-serif;
        font-size: {$fontSizeTop}px;
        font-weight: 900;
        letter-spacing: 2px;
      }
      .bottom-text {
        fill: {$textColor};
        font-family: Arial Black, Arial, Helvetica, sans-serif;
        font-size: {$fontSizeBottom}px;
        font-weight: 900;
        letter-spacing: 1px;
      }
    </style>
  </defs>

  <!-- Fondo principal redondeado -->
  <rect x="0" y="0" width="{$width}" height="{$height}" rx="28" ry="28" class="bg"/>

  <!-- Separadores horizontales decorativos -->
  <rect x="0" y="{$sep1Y}" width="{$width}" height="3" fill="rgba(255,255,255,0.25)"/>
  <rect x="0" y="{$sep2Y}" width="{$width}" height="3" fill="rgba(255,255,255,0.25)"/>

  <!-- Nombre empresa (arriba) -->
  <text x="{$centerX}" y="{$topTextY}"
        text-anchor="middle" dominant-baseline="middle"
        class="top-text">{$empresaNombre}</text>

  <!-- Área blanca del QR -->
  <rect x="{$pad}" y="{$topArea}" width="{$qrSize}" height="{$qrSize}" class="qr-bg"/>

  <!-- QR -->
  <g class="qr" transform="translate({$pad}, {$topArea})">
    {$inner}
  </g>

  <!-- Nombre activo (abajo) -->
  <text x="{$centerX}" y="{$bottomTextY}"
        text-anchor="middle" dominant-baseline="middle"
        class="bottom-text">{$activoNombre}</text>

</svg>
SVG;

        Storage::disk('public')->put($archivo, $svg);
        $activo->update(['qr_image' => $archivo]);

        return $archivo;
    }

    /**
     * Estima el tamaño de fuente máximo que cabe en un ancho dado.
     * Usa una proporción simple: ~0.6px de ancho por px de alto por carácter.
     */
    private function calcFontSize(string $text, int $maxWidth, int $default, int $min): int
    {
        $chars       = mb_strlen($text);
        $charWidthRatio = 0.70; // proporción ancho/alto para Arial Black bold mayúsculas
        $size = (int) floor($maxWidth / ($chars * $charWidthRatio));
        return max($min, min($default, $size));
    }

    public function urlQr(Activo $activo): ?string
    {
        if (! $activo->qr_image) return null;

        $path   = 'storage/' . $activo->qr_image;
        $appUrl = config('app.url', '');

        $isSecure = false;
        try { $isSecure = request()?->isSecure(); } catch (\Throwable) {}

        return ($isSecure || str_starts_with($appUrl, 'https'))
            ? secure_asset($path)
            : asset($path);
    }
}