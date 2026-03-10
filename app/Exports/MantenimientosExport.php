<?php

namespace App\Exports;

use App\Models\Mantenimiento;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MantenimientosExport implements
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
        $query = Mantenimiento::withoutGlobalScopes()
            ->with(['activo', 'user'])
            ->where('empresa_id', $this->empresaId);

        if (! empty($this->filtros['estado'])) {
            $query->where('estado', $this->filtros['estado']);
        }

        if (! empty($this->filtros['tipo'])) {
            $query->where('tipo', $this->filtros['tipo']);
        }

        if (! empty($this->filtros['desde'])) {
            $query->whereDate('programado_at', '>=', $this->filtros['desde']);
        }

        if (! empty($this->filtros['hasta'])) {
            $query->whereDate('programado_at', '<=', $this->filtros['hasta']);
        }

        return $query->orderByDesc('programado_at');
    }

    public function headings(): array
    {
        return [
            'ID', 'Título', 'Activo', 'Tipo', 'Estado',
            'Programado', 'Completado', 'Costo', 'Responsable', 'Observaciones',
        ];
    }

    public function map($m): array
    {
        return [
            $m->id,
            $m->titulo,
            $m->activo?->nombre  ?? '—',
            $m->tipoLabel(),
            $m->estadoLabel(),
            $m->programado_at->format('d/m/Y'),
            $m->completado_at?->format('d/m/Y') ?? '—',
            $m->costo ? '$' . number_format($m->costo, 2) : '—',
            $m->user?->nombre . ' ' . $m->user?->apellido ?? '—',
            $m->observaciones ?? '—',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '059669']],
            ],
        ];
    }

    public function title(): string { return 'Mantenimientos'; }
}