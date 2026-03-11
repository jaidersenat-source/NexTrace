<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Mantenimiento;
use App\Models\User;
use App\Services\MantenimientoService;
use App\Services\ActivoService;
use App\Http\Requests\StoreMantenimientoRequest;
use App\Http\Requests\UpdateMantenimientoRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MantenimientoController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected MantenimientoService $service,
        protected ActivoService        $activoService,
    ) {}

    public function index(Request $request): View
    {
        $mantenimientos = $this->service->listar($request->only(['estado', 'tipo', 'activo_id']));
        $metricas       = $this->service->metricas();
        $activos        = Activo::orderBy('nombre')->get(['id', 'nombre']);

        return view('mantenimientos.index', compact('mantenimientos', 'metricas', 'activos'));
    }

    public function create(Request $request): View
    {
        $activos  = Activo::orderBy('nombre')->get(['id', 'nombre', 'estado']);
        $usuarios = User::where('empresa_id', Auth::user()->empresa_id)
                        ->where('activo', true)
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'apellido']);

        // Permite preseleccionar activo desde la URL
        $activoSeleccionado = $request->activo_id;

        return view('mantenimientos.create', compact('activos', 'activoSeleccionado', 'usuarios'));
    }

    public function store(StoreMantenimientoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('documento')) {
            $path = $request->file('documento')->store('mantenimientos', 'public');
            $datos['documento_path'] = $path;
        }

        $mantenimiento = $this->service->crear($datos, auth()->user());

        return redirect()
            ->route('mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento programado correctamente.');
    }

    public function show(Mantenimiento $mantenimiento): View
    {
        $mantenimiento->load(['activo.categoria', 'user', 'responsable']);

        return view('mantenimientos.show', compact('mantenimiento'));
    }

    public function download(Mantenimiento $mantenimiento)
    {
        if (! $mantenimiento->documento_path || ! Storage::disk('public')->exists($mantenimiento->documento_path)) {
            return redirect()->back()->with('error', 'Documento no disponible.');
        }

        $filename = basename($mantenimiento->documento_path);
        return Storage::disk('public')->download($mantenimiento->documento_path, $filename);
    }

    public function edit(Mantenimiento $mantenimiento): View
    {
        $activos  = Activo::orderBy('nombre')->get(['id', 'nombre']);
        $usuarios = User::where('empresa_id', Auth::user()->empresa_id)
                        ->where('activo', true)
                        ->orderBy('nombre')
                        ->get(['id', 'nombre', 'apellido']);

        return view('mantenimientos.edit', compact('mantenimiento', 'activos', 'usuarios'));
    }

    public function update(UpdateMantenimientoRequest $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        $datos = $request->validated();

        if ($request->hasFile('documento')) {
            // Eliminar documento anterior si existe
            if ($mantenimiento->documento_path && Storage::disk('public')->exists($mantenimiento->documento_path)) {
                Storage::disk('public')->delete($mantenimiento->documento_path);
            }

            $path = $request->file('documento')->store('mantenimientos', 'public');
            $datos['documento_path'] = $path;
        }

        $this->service->actualizar($mantenimiento, $datos);

        return redirect()
            ->route('mantenimientos.show', $mantenimiento)
            ->with('success', 'Mantenimiento actualizado correctamente.');
    }

    public function completar(Request $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        if (! in_array($mantenimiento->estado, ['pendiente', 'en_proceso'])) {
            return back()->with('error', 'El mantenimiento ya fue procesado.');
        }

        $this->service->marcarCompletado($mantenimiento, Auth::user());

        return back()->with('success', 'Mantenimiento marcado como completado.');
    }

    public function inconveniente(Request $request, Mantenimiento $mantenimiento): RedirectResponse
    {
        $request->validate([
            'observaciones' => ['required', 'string', 'max:1000'],
            'nuevo_estado'  => ['required', 'in:en_proceso,cancelado'],
        ]);

        $this->service->registrarInconveniente($mantenimiento, Auth::user(), $request->observaciones, $request->nuevo_estado);

        return back()->with('success', 'Inconveniente registrado correctamente.');
    }

    public function destroy(Mantenimiento $mantenimiento): RedirectResponse
    {
        $mantenimiento->delete();

        return redirect()
            ->route('mantenimientos.index')
            ->with('success', 'Mantenimiento eliminado.');
    }
}