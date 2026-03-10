<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('activo'));
    }

    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:100'],
            'categoria_id' => ['nullable', 'exists:categoria_activos,id'],
            'codigo'      => ['nullable', 'string', 'max:50'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'valor'       => ['required', 'numeric', 'min:0'],
            'estado'      => ['required', 'in:activo,mantenimiento,baja'],
            'atributos'   => ['nullable', 'array'],
            'atributos.*' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del activo es obligatorio.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'valor.required'  => 'El valor es obligatorio.',
            'valor.numeric'   => 'El valor debe ser un número.',
            'valor.min'       => 'El valor no puede ser negativo.',
            'estado.in'       => 'El estado seleccionado no es válido.',
        ];
    }
}