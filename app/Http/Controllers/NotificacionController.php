<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Services\NotificacionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class NotificacionController extends Controller
{
    public function __construct(
        protected NotificacionService $service
    ) {}

    public function index(): View
    {
        $notificaciones = Notificacion::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        // Marcar todas como leídas al abrir la bandeja
        $this->service->marcarTodasLeidas(auth()->user());

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida(Notificacion $notificacion): RedirectResponse
    {
        // Verificar que pertenece al usuario
        abort_if($notificacion->user_id !== auth()->id(), 403);

        $this->service->marcarLeida($notificacion);

        if ($notificacion->url) {
            return redirect($notificacion->url);
        }

        return back();
    }

    public function conteo(): JsonResponse
    {
        return response()->json([
            'count' => $this->service->contarNoLeidas(auth()->user()),
        ]);
    }

    public function lista(): JsonResponse
    {
        $notificaciones = Notificacion::where('user_id', auth()->id())
            ->whereNull('leida_at')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'titulo' => $n->titulo,
                    'mensaje' => $n->mensaje,
                    'icono' => $n->icono,
                    'abrir_url' => route('notificaciones.abrir', $n),
                    'leida' => $n->estaLeida(),
                    'created_at' => $n->created_at ? $n->created_at->diffForHumans() : null,
                ];
            });

        return response()->json([
            'data' => $notificaciones,
            'count' => $this->service->contarNoLeidas(auth()->user()),
        ]);
    }

    public function abrir(Notificacion $notificacion)
    {
        abort_if($notificacion->user_id !== auth()->id(), 403);

        $this->service->marcarLeida($notificacion);

        if ($notificacion->url) {
            return redirect($notificacion->url);
        }

        return redirect()->back();
    }

    public function eliminar(Notificacion $notificacion): RedirectResponse
    {
        abort_if($notificacion->user_id !== auth()->id(), 403);

        $notificacion->delete();

        return back()->with('success', 'Notificación eliminada.');
    }
}