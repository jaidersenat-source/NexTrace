<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'               => \App\Http\Middleware\CheckRole::class,
            'super_admin'    => \App\Http\Middleware\OnlySuperAdmin::class,
            'empresa'            => \App\Http\Middleware\VerificarEmpresa::class,
            'usuario.activo' => \App\Http\Middleware\VerificarUsuarioActivo::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 403 — Sin permiso
        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No autorizado.'], 403);
            }
            return response()->view('errors.403', [], 403);
        });

        // 404 — No encontrado
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Recurso no encontrado.'], 404);
            }
            return response()->view('errors.404', [], 404);
        });
    })->create();

    
