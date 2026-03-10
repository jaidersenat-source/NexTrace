<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Services\ActivoService;
use App\Http\Requests\StoreActivoRequest;
use App\Http\Requests\UpdateActivoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivoController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected ActivoService $service
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Activo::class);

        $activos    = $this->service->listar($request->only(['estado', 'buscar', 'categoria_id']));
        $categorias = $this->service->categoriasDisponibles();

        return view('activos.index', compact('activos', 'categorias'));
    }

    public function create(): View
    {
        $this->authorize('create', Activo::class);

        $categorias = $this->service->categoriasDisponibles();

        return view('activos.create', compact('categorias'));
    }

    public function store(StoreActivoRequest $request): RedirectResponse
    {
        $this->service->crear($request->validated());

        return redirect()
            ->route('activos.index')
            ->with('success', 'Activo creado correctamente.');
    }

    public function show(Activo $activo): View
    {
        $this->authorize('view', $activo);
        $activo->load(['categoria', 'usoActual.user']);

        return view('activos.show', compact('activo'));
    }

    public function edit(Activo $activo): View
    {
        $this->authorize('update', $activo);

        $categorias = $this->service->categoriasDisponibles();

        return view('activos.edit', compact('activo', 'categorias'));
    }

    public function update(UpdateActivoRequest $request, Activo $activo): RedirectResponse
    {
        $this->service->actualizar($activo, $request->validated());

        return redirect()
            ->route('activos.index')
            ->with('success', 'Activo actualizado correctamente.');
    }

    public function destroy(Activo $activo): RedirectResponse
    {
        $this->authorize('delete', $activo);
        $this->service->eliminar($activo);

        return redirect()
            ->route('activos.index')
            ->with('success', 'Activo eliminado correctamente.');
    }
}