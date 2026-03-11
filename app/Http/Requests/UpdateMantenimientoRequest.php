<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMantenimientoRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()->esAdmin(); }

    public function rules(): array
    {
        return [
            'responsable_id' => ['nullable', 'exists:users,id'],
            'tipo'           => ['required', 'in:preventivo,correctivo,revision'],
            'titulo'         => ['required', 'string', 'max:150'],
            'descripcion'    => ['nullable', 'string', 'max:1000'],
            'programado_at'  => ['required', 'date'],
            'estado'         => ['required', 'in:pendiente,en_proceso,completado,cancelado'],
            'observaciones'  => ['nullable', 'string', 'max:1000'],
            'costo'          => ['nullable', 'numeric', 'min:0'],
            'documento'      => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ];
    }
}