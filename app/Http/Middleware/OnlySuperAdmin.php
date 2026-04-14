<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlySuperAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! auth()->check() || ! (auth()->user()->esSuperAdmin() || auth()->user()->esAdmin())) {
            abort(403, 'Acceso restringido.');
        }

        return $next($request);
    }
}