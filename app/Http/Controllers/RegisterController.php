<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Salon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    // 1. Mostrar el formulario
    public function show()
    {
        return view('register');
    }

    // 2. Procesar el registro
    public function register(Request $request)
    {
        // A. Validar que no existan duplicados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'nombre_negocio' => 'required|string|max:255',
            'slug' => 'required|string|max:50|alpha_dash|unique:salons', // alpha_dash = solo letras, numeros y guiones
        ], [
            'email.unique' => 'Este correo ya está registrado.',
            'slug.unique' => 'Ese link (URL) ya está ocupado, intenta otro.',
            'slug.alpha_dash' => 'El link solo puede tener letras, números y guiones (sin espacios).'
        ]);

        // B. Crear Usuario (Dueña)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // C. Crear Salón vinculado
        $salon = Salon::create([
            'user_id' => $user->id,
            'nombre_negocio' => $request->nombre_negocio,
            'slug' => Str::lower($request->slug), // Convertir a minusculas
            'color_brand' => '#AB3E86', // Color default (luego lo pueden editar)
            'activo' => true
        ]);

        // D. Regalar Servicios Básicos (Para que el dashboard no se vea vacío)
        $salon->servicios()->createMany([
            ['nombre' => 'Gelish Liso', 'precio' => 150, 'duracion_minutos' => 60],
            ['nombre' => 'Manicure Spa', 'precio' => 250, 'duracion_minutos' => 45],
            ['nombre' => 'Retiro', 'precio' => 50, 'duracion_minutos' => 20],
        ]);

        // E. Iniciar Sesión Automáticamente y redirigir
        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }
}