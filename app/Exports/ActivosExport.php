<?php

namespace App\Exports;

use App\Models\Activo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivosExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        protected int $empresaId,
        protected array $filtros = []
    ) {}

    public function query()
    {
        $query = Activo::withoutGlobalScopes()
            ->with(['categoria', 'usoActual.user'])
            ->where('empresa_id', $this->empresaId);

        if (! empty($this->filtros['estado'])) {
            $query->where('estado', $this->filtros['estado']);
        }

        if (! empty($this->filtros['categoria_id'])) {
            $query->where('categoria_id', $this->filtros['categoria_id']);
        }

        return $query->orderBy('nombre');
    }

    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Categoría', 'Código',
            'Estado', 'Valor', 'En uso por',
            'Atributos', 'Fecha registro',
        ];
    }

    public function map($activo): array
    {
        // Atributos como texto plano
        $atributos = '';
        if ($activo->atributos && $activo->categoria) {
            $partes = [];
            foreach ($activo->categoria->campos as $campo) {
                $valor = $activo->atributo($campo['clave']);
                if ($valor) {
                    $partes[] = "{$campo['label']}: {$valor}";
                }
            }
            $atributos = implode(' | ', $partes);
        }

        return [
            $activo->id,
            $activo->nombre,
            $activo->categoria->nombre ?? '—',
            $activo->codigo ?? '—',
            $activo->estadoLabel(),
            '$' . number_format($activo->valor, 2),
            $activo->usoActual?->user?->nombre ?? 'Libre',
            $atributos,
            $activo->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F46E5']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Activos';
    }
}