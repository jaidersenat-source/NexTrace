<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EmpresaController extends Controller
{
    use AuthorizesRequests;
    public function edit(): View
    {
        $empresa = auth()->user()->empresa;
        $this->authorize('update', $empresa);

        return view('empresa.edit', compact('empresa'));
    }

    public function update(Request $request): RedirectResponse
    {
        $empresa = auth()->user()->empresa;
        $this->authorize('update', $empresa);

        $validated = $request->validate([
            'nombre'           => ['required', 'string', 'max:100'],
            'email'            => ['nullable', 'email', 'max:255'],
            'telefono'         => ['nullable', 'string', 'max:20'],
            'pais'             => ['nullable', 'string', 'max:100'],
            'color_primario'   => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_secundario' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_sidebar'    => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo'             => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg,webp'],
        ]);

        // Subir logo si viene
        if ($request->hasFile('logo')) {
            // Eliminar logo anterior
            if ($empresa->logo_url) {
                Storage::disk('public')->delete($empresa->logo_url);
            }
            $validated['logo_url'] = $request->file('logo')
                ->store('logos', 'public');
        }

        unset($validated['logo']);
        $empresa->update($validated);

        return redirect()
            ->route('empresa.edit')
            ->with('success', 'Configuración guardada correctamente.');
    }
}