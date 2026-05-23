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

        return back()->with('success', 'Usuario creado correctamente');
    }

    public function editEmpleado($id)
    {
        $empleado = Usuario::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $authUser = auth()->user();

        if ($authUser->rol === 'empleado' && $usuario->rol !== 'cliente') {
            return back()->with('error', 'No tienes permisos.');
        }

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $authUser = auth()->user();

        if ($authUser->rol === 'empleado' && $usuario->rol !== 'cliente') {
            return back()->with('error', 'No tienes permisos.');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|unique:usuarios,email,' . $id . ',id_usuario',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return back()->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $target = Usuario::findOrFail($id);

        if ($target->rol === 'empleado') {

            if ($user->rol !== 'admin') {
                return back()->with('error', 'Solo el administrador puede eliminar empleados.');
            }

            if ($target->eventos()->exists()) {
                return back()->with('error', 'No se puede eliminar este empleado porque tiene eventos asociados.');
            }

            $target->delete();

            return back()->with('success', 'Empleado eliminado correctamente.');
        }

        if (in_array($user->rol, ['admin', 'empleado'])) {

            if ($target->eventos()->exists()) {
                return back()->with('error', 'No puedes eliminar este cliente porque tiene eventos asociados.');
            }

            $target->delete();

            return back()->with('success', 'Cliente eliminado correctamente.');
        }

        return back()->with('error', 'No tienes permisos para realizar esta acción.');
    }
}
