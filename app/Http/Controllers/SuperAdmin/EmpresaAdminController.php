<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpresaAdminController extends Controller
{
    public function index(): View
    {
        $empresas = Empresa::withTrashed()
            ->withCount('users')
            ->latest()
            ->paginate(20);

        return view('super-admin.empresas.index', compact('empresas'));
    }

    public function show(Empresa $empresa): View
    {
        $empresa->loadCount('users');
        $activos = \App\Models\Activo::withoutGlobalScopes()
            ->where('empresa_id', $empresa->id)
            ->latest()
            ->take(10)
            ->get();

        $logs = \App\Models\ActivityLog::withoutGlobalScopes()
            ->where('empresa_id', $empresa->id)
            ->with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.empresas.show', compact('empresa', 'activos', 'logs'));
    }

    public function toggleActivo(Empresa $empresa): RedirectResponse
    {
        $empresa->update(['activo' => ! $empresa->activo]);

        $estado = $empresa->activo ? 'activada' : 'desactivada';

        return back()->with('success', "Empresa {$estado} correctamente.");
    }

    public function cambiarPlan(Request $request, Empresa $empresa): RedirectResponse
    {
        $request->validate([
            'plan'          => ['required', 'in:gratuito,basico,profesional,enterprise'],
            'notas_admin'   => ['nullable', 'string', 'max:500'],
            'plan_vence_at' => ['nullable', 'date'],
        ]);

        $empresa->update($request->only(['plan', 'notas_admin', 'plan_vence_at']));

        return back()->with('success', 'Plan actualizado correctamente.');
    }

    public function auditoria(): View
    {
        $logs = \App\Models\ActivityLog::withoutGlobalScopes()
            ->with(['user', 'empresa'])
            ->latest()
            ->paginate(30);

        return view('super-admin.auditoria', compact('logs'));
    }
}