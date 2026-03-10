<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Activo;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    public function dashboard(): View
    {
        $metricas = [
            'total_empresas'  => Empresa::withTrashed()->count(),
            'empresas_activas'=> Empresa::where('activo', true)->count(),
            'total_usuarios'  => User::withoutGlobalScopes()->count(),
            'total_activos'   => Activo::withoutGlobalScopes()->count(),
            'total_logs'      => ActivityLog::withoutGlobalScopes()->count(),
        ];

        $empresas_recientes = Empresa::latest()->take(5)->get();

        $actividad_reciente = ActivityLog::withoutGlobalScopes()
            ->with(['user', 'empresa'])
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.dashboard', compact(
            'metricas',
            'empresas_recientes',
            'actividad_reciente'
        ));
    }
}