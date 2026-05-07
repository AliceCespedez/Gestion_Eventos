<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    private function redirectByRole($user)
    {
        return match ($user->rol) {
            'admin' => redirect('/admin'),
            'empleado', 'cliente' => redirect('/dashboard'),
            default => redirect('/dashboard'),
        };
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente'
        ]);

        return redirect('/login')
            ->with('success', 'Usuario registrado correctamente');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // CREAR USUARIOS (ADMIN + EMPLEADO)

    public function createUserByRole(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'rol' => 'required|in:cliente,empleado'
        ]);

        $authUser = Auth::user();

        // Solo admin y empleado pueden crear usuarios
        if (!in_array($authUser->rol, ['admin', 'empleado'])) {
            return back()->with('error', 'No tienes permisos');
        }

        // Empleado solo puede crear clientes
        if ($authUser->rol === 'empleado' && $request->rol !== 'cliente') {
            return back()->with('error', 'Un empleado solo puede crear clientes');
        }

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

        // Redireccionar según el rol creado
        if ($request->rol === 'cliente') {
            return redirect('/clientes')
                ->with('success', 'Cliente creado correctamente');
        }

        if ($request->rol === 'empleado') {
            return redirect('/empleados')
                ->with('success', 'Empleado creado correctamente');
        }

        return back()->with('success', 'Usuario creado correctamente');
    }

    // ELIMINAR CLIENTE (ADMIN-EMPLEADO)
    public function destroy($id)
    {
        $user = auth()->user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar usuarios.'
            ], 403);
        }

        $cliente = Usuario::findOrFail($id);

        // Verificar si tiene eventos asociados
        if ($cliente->eventos()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar este usuario porque tiene eventos asociados.'
            ], 400);
        }

        $cliente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado correctamente.'
        ]);
    }
}
