<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'empresa_nombre' => ['required', 'string', 'max:100'],
            'nombre'         => ['required', 'string', 'max:80'],
            'apellido'       => ['nullable', 'string', 'max:80'],
            'email'          => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {

            // 1. Crear empresa
            $empresa = Empresa::create([
                'nombre' => $request->empresa_nombre,
                'slug'   => Empresa::generarSlug($request->empresa_nombre),
                'email'  => $request->email,
                'activo' => true,
            ]);

            // 2. Crear usuario administrador vinculado a la empresa
            return User::create([
                'empresa_id' => $empresa->id,
                'nombre'     => $request->nombre,
                'apellido'   => $request->apellido,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'rol'        => 'admin',
                'activo'     => true,
            ]);
        });

        event(new Registered($user));

        // ...existing code...
        // Eliminado login y redirección a subdominio
        return redirect()->route('dashboard');
    }
}