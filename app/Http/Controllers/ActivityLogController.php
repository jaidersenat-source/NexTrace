<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user')
            ->latest();

        // Filtro por acción
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filtro por modelo
        if ($request->filled('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        // Filtro por usuario
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs    = $query->paginate(20)->withQueryString();
        $usuarios = auth()->user()->empresa->users()->select('id', 'nombre', 'apellido')->get();

        return view('activity-logs.index', compact('logs', 'usuarios'));
    }
}