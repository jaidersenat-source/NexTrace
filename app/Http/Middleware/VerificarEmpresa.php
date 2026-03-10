<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarEmpresa
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && ! auth()->user()->empresa_id) {
            abort(403, 'Usuario sin empresa asignada.');
        }

        return $next($request);
    }
}