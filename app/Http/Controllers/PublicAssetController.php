<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Services\AssetUsageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicAssetController extends Controller
{
    public function __construct(
        protected AssetUsageService $usageService
    ) {}

    public function show(string $token)
    {
        $activo = Activo::withoutGlobalScopes()
            ->with(['usoActual.user', 'empresa', 'categoria'])
            ->where('qr_token', $token)
            ->firstOrFail();

        if (! $activo->empresa->activo) {
            abort(403, 'Esta empresa no está activa.');
        }

        $historial = $this->usageService->historial($activo, 5);

        // Si el usuario está autenticado y pertenece a la misma empresa → vista interactiva
        if (Auth::check() && Auth::user()->empresa_id === $activo->empresa_id) {
            return view('public.activo-auth', compact('activo', 'historial'));
        }

        // Vista pública (solo lectura) para usuarios no autenticados o de otra empresa
        return view('public.activo', compact('activo', 'historial'));
    }

    public function toggle(Request $request, string $token)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'Debes iniciar sesión para usar este equipo.'], 401);
        }

        $activo = Activo::withoutGlobalScopes()
            ->where('qr_token', $token)
            ->firstOrFail();

        if (! $activo->empresa->activo) {
            return response()->json(['error' => 'Esta empresa no está activa.'], 403);
        }

        if (Auth::user()->empresa_id !== $activo->empresa_id) {
            return response()->json(['error' => 'No tienes acceso a este equipo.'], 403);
        }

        $observaciones = $request->input('observaciones');

        try {
            $resultado = $this->usageService->toggleUsage($activo, Auth::user(), $observaciones);
            return response()->json($resultado);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 409);
        }
    }
}