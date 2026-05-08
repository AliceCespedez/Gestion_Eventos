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

    // CREAR USUARIOS
    public function createUserByRole(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'rol' => 'required|in:cliente,empleado'
        ]);

        $authUser = Auth::user();

        if (!in_array($authUser->rol, ['admin', 'empleado'])) {

            return back()->with('error', 'No tienes permisos');
        }

        if ($authUser->rol === 'empleado' && $request->rol !== 'cliente') {

            return back()->with('error', 'Un empleado solo puede crear clientes');
        }

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol
        ]);

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

    // ELIMINAR USUARIOS
    public function destroy($id)
    {
        $user = auth()->user();

        // Buscar usuario
        $target = Usuario::findOrFail($id);

        //  ELIMINAR EMPLEADOS
        if ($target->rol === 'empleado') {

            // Solo admin puede eliminar empleados
            if ($user->rol !== 'admin') {
                $message = 'Solo el administrador puede eliminar empleados.';
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 403);
                }
                return back()->with('error', $message);
            }

            // No permitir eliminar empleados con eventos
            if ($target->eventos()->exists()) {
                $message = 'No se puede eliminar este empleado porque tiene eventos asociados.';
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 400);
                }
                return back()->with('error', $message);
            }

            $target->delete();
            
            $message = 'Empleado eliminado correctamente.';
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);
        }

        // ELIMINAR CLIENTES
        if (in_array($user->rol, ['admin', 'empleado'])) {

            // No permitir eliminar clientes con eventos
            if ($target->eventos()->exists()) {
                $message = 'No puedes eliminar este cliente porque tiene eventos asociados.';
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => $message], 400);
                }
                return back()->with('error', $message);
            }

            $target->delete();

            $message = 'Cliente eliminado correctamente.';
            if (request()->expectsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }
            return back()->with('success', $message);
        }

        //  SIN PERMISOS
        $message = 'No tienes permisos para realizar esta acción.';
        if (request()->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 403);
        }
        return back()->with('error', $message);
    }
}
