
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ActivityLogController;
use App\Services\ActivoService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\EmpresaAdminController; 
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\PublicAssetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\ScannerController;
use App\Services\DashboardService;
// Ruta principal
Route::get('/', fn() => view('welcome'));

// Rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (DashboardService $service) {
    $metricas         = $service->metricas();
    $actividad        = $service->actividadReciente();
    $proximosMant     = $service->proximosMantenimientos();
    $equiposEnUso     = $service->equiposEnUso();

    return view('dashboard', compact(
        'metricas',
        'actividad',
        'proximosMant',
        'equiposEnUso'
    ));
})->name('dashboard');

    Route::resource('activos', ActivoController::class);

    Route::get('/scanner', [ScannerController::class, 'index'])
         ->name('scanner.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/empresa/configuracion', [EmpresaController::class, 'edit'])->name('empresa.edit');
        Route::patch('/empresa/configuracion', [EmpresaController::class, 'update'])->name('empresa.update');
        Route::get('/auditoria', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Panel Super Admin ────────────────────────────────────────────────────────
Route::prefix('super-admin')
    ->middleware(['auth', 'super_admin'])
    ->name('super-admin.')
    ->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])
             ->name('dashboard');

        Route::get('/empresas', [EmpresaAdminController::class, 'index'])
             ->name('empresas.index');

        Route::get('/empresas/{empresa}', [EmpresaAdminController::class, 'show'])
             ->name('empresas.show');

        Route::patch('/empresas/{empresa}/toggle', [EmpresaAdminController::class, 'toggleActivo'])
             ->name('empresas.toggle');

        Route::patch('/empresas/{empresa}/plan', [EmpresaAdminController::class, 'cambiarPlan'])
             ->name('empresas.plan');

        Route::get('/auditoria', [EmpresaAdminController::class, 'auditoria'])
             ->name('auditoria');
    });

    // ─── Rutas públicas QR ────────────────────────────────────────
Route::get('/a/{token}', [PublicAssetController::class, 'show'])
     ->name('public.activo');

Route::post('/a/{token}/toggle', [PublicAssetController::class, 'toggle'])
     ->middleware('auth')
     ->name('public.activo.toggle');

     Route::resource('activos', ActivoController::class)
     ->only(['index', 'show'])          // ← agrega show
     ->middleware('role:admin,empleado');

     Route::middleware('role:admin')->group(function () {

    // Usuarios de empresa
    Route::resource('usuarios', UserController::class)
         ->except(['show']);

    Route::patch('/usuarios/{usuario}/toggle', [UserController::class, 'toggleActivo'])
         ->name('usuarios.toggle');

    Route::patch('/usuarios/{usuario}/password', [UserController::class, 'resetPassword'])
         ->name('usuarios.password');

    // Empresa y auditoría (ya existentes)
    Route::get('/empresa/configuracion', [EmpresaController::class, 'edit'])
         ->name('empresa.edit');
    Route::patch('/empresa/configuracion', [EmpresaController::class, 'update'])
         ->name('empresa.update');
    Route::get('/auditoria', [ActivityLogController::class, 'index'])
         ->name('activity-logs.index');
        
        // Categorías de activos (crear desde modal)
        Route::post('/categorias', [\App\Http\Controllers\CategoriaActivoController::class, 'store'])
             ->name('categorias.store');
});

Route::middleware(['auth', 'verified', 'usuario.activo'])->group(function () {
    // todas las rutas protegidas
});

Route::middleware('role:admin')->group(function () {

    Route::get('/reportes', [ReporteController::class, 'index'])
         ->name('reportes.index');

    // Activos
    Route::get('/reportes/activos/excel', [ReporteController::class, 'activosExcel'])
         ->name('reportes.activos.excel');
    Route::get('/reportes/activos/pdf', [ReporteController::class, 'activosPdf'])
         ->name('reportes.activos.pdf');

    // Uso de equipos
    Route::get('/reportes/uso/excel', [ReporteController::class, 'usoExcel'])
         ->name('reportes.uso.excel');
    Route::get('/reportes/uso/pdf', [ReporteController::class, 'usoPdf'])
         ->name('reportes.uso.pdf');

    // Mantenimientos
    Route::get('/reportes/mantenimientos/excel', [ReporteController::class, 'mantenimientosExcel'])
         ->name('reportes.mantenimientos.excel');
    Route::get('/reportes/mantenimientos/pdf', [ReporteController::class, 'mantenimientosPdf'])
         ->name('reportes.mantenimientos.pdf');

             // Previews AJAX
    Route::get('reportes/preview/activos',        [ReporteController::class, 'previewActivos'])->name('reportes.preview.activos');
    Route::get('reportes/preview/uso',            [ReporteController::class, 'previewUso'])->name('reportes.preview.uso');
    Route::get('reportes/preview/mantenimientos', [ReporteController::class, 'previewMantenimientos'])->name('reportes.preview.mantenimientos');



});

Route::middleware(['auth', 'verified', 'usuario.activo'])->group(function () {

    // Notificaciones — todos los usuarios autenticados
    Route::get('/notificaciones', [NotificacionController::class, 'index'])
         ->name('notificaciones.index');

    Route::patch('/notificaciones/{notificacion}/leer',
                 [NotificacionController::class, 'marcarLeida'])
         ->name('notificaciones.leer');

    Route::delete('/notificaciones/{notificacion}',
                  [NotificacionController::class, 'eliminar'])
         ->name('notificaciones.eliminar');

    Route::get('/notificaciones/conteo',
               [NotificacionController::class, 'conteo'])
         ->name('notificaciones.conteo');
    
    // Lista simple para el dropdown (JSON)
    Route::get('/notificaciones/lista', [NotificacionController::class, 'lista'])
         ->name('notificaciones.lista');

    // Redirección que marca como leída y redirige al URL de la notificación
    Route::get('/notificaciones/{notificacion}/abrir', [NotificacionController::class, 'abrir'])
         ->name('notificaciones.abrir');

    // ... resto de rutas
});

Route::middleware(['auth', 'verified', 'usuario.activo'])->group(function () {

    Route::get('/mantenimientos', [MantenimientoController::class, 'index'])
        ->name('mantenimientos.index');

    Route::middleware('role:admin')->group(function () {

        Route::get('/mantenimientos/create', [MantenimientoController::class, 'create'])
            ->name('mantenimientos.create');

        Route::post('/mantenimientos', [MantenimientoController::class, 'store'])
            ->name('mantenimientos.store');

        Route::get('/mantenimientos/{mantenimiento}/editar', [MantenimientoController::class, 'edit'])
            ->name('mantenimientos.edit');

        Route::put('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'update'])
            ->name('mantenimientos.update');

        Route::patch('/mantenimientos/{mantenimiento}/completar', [MantenimientoController::class, 'completar'])
            ->name('mantenimientos.completar');

        Route::patch('/mantenimientos/{mantenimiento}/inconveniente', [MantenimientoController::class, 'inconveniente'])
            ->name('mantenimientos.inconveniente');

        Route::delete('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'destroy'])
            ->name('mantenimientos.destroy');
    });






    // 👇 SIEMPRE AL FINAL
    Route::get('/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'show'])
        ->name('mantenimientos.show');

});

require __DIR__.'/auth.php';
