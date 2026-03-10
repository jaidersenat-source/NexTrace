<?php

namespace App\Exports;

use App\Models\AssetUsage;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsoActivosExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(
        protected int   $empresaId,
        protected array $filtros = []
    ) {}

    public function query()
    {
        $query = AssetUsage::withoutGlobalScopes()
            ->with(['activo', 'user'])
            ->where('empresa_id', $this->empresaId);

        if (! empty($this->filtros['activo_id'])) {
            $query->where('activo_id', $this->filtros['activo_id']);
        }

        if (! empty($this->filtros['user_id'])) {
            $query->where('user_id', $this->filtros['user_id']);
        }

        if (! empty($this->filtros['desde'])) {
            $query->whereDate('started_at', '>=', $this->filtros['desde']);
        }

        if (! empty($this->filtros['hasta'])) {
            $query->whereDate('started_at', '<=', $this->filtros['hasta']);
        }

        return $query->orderByDesc('started_at');
    }

    public function headings(): array
    {
        return [
            'ID', 'Activo', 'Usuario', 'Inicio',
            'Fin', 'Duración', 'Estado',
        ];
    }

    public function map($uso): array
    {
        $duracion = $uso->ended_at
            ? $uso->started_at->diffForHumans($uso->ended_at, true)
            : 'En uso';

        return [
            $uso->id,
            $uso->activo?->nombre  ?? '—',
            $uso->user?->nombre . ' ' . $uso->user?->apellido ?? '—',
            $uso->started_at->format('d/m/Y H:i'),
            $uso->ended_at?->format('d/m/Y H:i') ?? '—',
            $duracion,
            $uso->ended_at ? 'Completado' : 'En uso',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4F46E5']],
            ],
        ];
    }

    public function title(): string { return 'Uso de Equipos'; }
}