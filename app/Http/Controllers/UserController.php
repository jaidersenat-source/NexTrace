<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $usuarios = User::where('empresa_id', auth()->user()->empresa_id)
                        ->orderBy('nombre')
                        ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $request->validate([
            'nombre'   => ['required', 'string', 'max:80'],
            'apellido' => ['nullable', 'string', 'max:80'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'rol'      => ['required', 'in:admin,empleado'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'empresa_id' => auth()->user()->empresa_id,
            'nombre'     => $request->nombre,
            'apellido'   => $request->apellido,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'rol'        => $request->rol,
            'activo'     => true,
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario): View
    {
        $this->authorize('update', $usuario);

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        $request->validate([
            'nombre'   => ['required', 'string', 'max:80'],
            'apellido' => ['nullable', 'string', 'max:80'],
            'rol'      => ['required', 'in:admin,empleado'],
        ]);

        $usuario->update($request->only(['nombre', 'apellido', 'rol']));

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function toggleActivo(User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        // No puede desactivarse a sí mismo
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivarte a ti mismo.');
        }

        $usuario->update(['activo' => ! $usuario->activo]);

        $estado = $usuario->activo ? 'activado' : 'desactivado';

        return back()->with('success', "Usuario {$estado} correctamente.");
    }

    public function resetPassword(Request $request, User $usuario): RedirectResponse
    {
        $this->authorize('update', $usuario);

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $usuario->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    public function destroy(User $usuario): RedirectResponse
    {
        $this->authorize('delete', $usuario);

        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $usuario->delete();

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}