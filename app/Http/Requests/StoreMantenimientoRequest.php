<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMantenimientoRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()->esAdmin(); }

    public function rules(): array
    {
        return [
            'activo_id'      => ['required', 'exists:activos,id'],
            'responsable_id' => ['nullable', 'exists:users,id'],
            'tipo'           => ['required', 'in:preventivo,correctivo,revision'],
            'titulo'         => ['required', 'string', 'max:150'],
            'descripcion'    => ['nullable', 'string', 'max:1000'],
            'programado_at'  => ['required', 'date', 'after_or_equal:today'],
            'costo'          => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'programado_at.after_or_equal' => 'La fecha no puede ser en el pasado.',
            'activo_id.required'           => 'Debes seleccionar un activo.',
        ];
    }
}