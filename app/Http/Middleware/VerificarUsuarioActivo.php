<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarUsuarioActivo
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check() && ! Auth::user()->activo) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
        }

        $response = $next($request);

        // Evitar que el navegador muestre vistas protegidas desde la caché al pulsar "atrás".
        if (method_exists($response, 'header')) {
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->header('Pragma', 'no-cache');
            $response->header('Expires', '0');
        }

        return $response;
    }
}