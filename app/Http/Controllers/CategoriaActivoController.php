<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoriaActivo;
use Illuminate\Http\JsonResponse;

class CategoriaActivoController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            if (! $user) {
                return response()->json(['message' => 'No autorizado'], 403);
            }
            if (! ($user->esAdmin() || $user->esSuperAdmin())) {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'icono'  => ['nullable', 'string', 'max:8'],
            'campos' => ['nullable', 'array'],
            'campos.*.label' => ['required_with:campos', 'string', 'max:120'],
            'campos.*.clave' => ['required_with:campos', 'string', 'max:60'],
            'campos.*.tipo'  => ['required_with:campos', 'in:text,number,select,date,checkbox'],
            'campos.*.opciones' => ['nullable', 'string'],
        ]);

        $categoria = new CategoriaActivo();
        // Si el usuario es super admin y envía el flag 'global', la categoría será global (empresa_id = null)
        if (auth()->user()?->esSuperAdmin() && ($request->boolean('global') ?? false)) {
            $categoria->empresa_id = null;
        } else {
            $categoria->empresa_id = auth()->user()?->empresa_id;
        }
        $categoria->nombre = $data['nombre'];
        $categoria->icono  = $data['icono'] ?? '📦';

        // Normalize campos: convert opciones string to array for select
        $campos = [];
        if (! empty($data['campos']) && is_array($data['campos'])) {
            foreach ($data['campos'] as $c) {
                $campo = [
                    'label' => $c['label'],
                    'clave' => $c['clave'],
                    'tipo'  => $c['tipo'],
                ];
                if (($c['tipo'] ?? '') === 'select') {
                    $opts = array_filter(array_map('trim', explode(',', $c['opciones'] ?? '')));
                    $campo['opciones'] = array_values($opts);
                }
                $campos[] = $campo;
            }
        }

        $categoria->campos = $campos;
        $categoria->activo = true;
            $categoria->save();

            return response()->json([
                'id' => $categoria->id,
                'nombre' => $categoria->nombre,
                'icono'  => $categoria->icono,
                'campos' => $categoria->campos,
                'empresa_id' => $categoria->empresa_id,
            ], 201);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['message' => 'No autorizado'], 403);
        } catch (\Illuminate\Http\Exceptions\HttpResponseException $e) {
            // validation exception bubbled up
            return response()->json(['message' => 'Datos inválidos', 'errors' => $e->getResponse()->getData(true)], 422);
        } catch (\Throwable $e) {
            logger()->error('Error creando categoria: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
