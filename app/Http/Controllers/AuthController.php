<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Validation\Rule;

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

    /* public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',

            'email' => [
                'required',
                'email:rfc,dns',
                'max:150',
                'unique:usuarios,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-])[A-Za-z\d@$!%*?&.#_-]+$/'
            ]

        ], [

            // NOMBRE
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',

            // EMAIL
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'email.max' => 'El correo es demasiado largo.',

            // CONTRASEÑA
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'password.regex' =>
            'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente'
        ]);

        return redirect('/login')
            ->with('success', 'Usuario registrado correctamente');
    }*/

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

            'email' => [
                'required',
                'email' => [
                    'required',
                    'email',
                    'max:150',
                    'regex:/^[^@\s]+@[^@\s]+\.[^@\s]{2,}$/',
                    'unique:usuarios,email'
                ],
                'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/',
                'max:150',
                'unique:usuarios,email'
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).+$/'
            ],

            'rol' => 'required|in:cliente,empleado'

        ], [

            // NOMBRE
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',

            // EMAIL
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.regex' => 'El correo debe terminar en un dominio válido como .com, .es, .net...',
            'email.unique' => 'Este correo ya está registrado.',
            'email.max' => 'El correo es demasiado largo.',

            // PASSWORD
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',

            'password.regex' =>
            'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',

            // ROL
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol seleccionado no es válido.',
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
            'email' => [
                'required',
                'email:rfc,dns',
                'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/',
                'max:150',
                Rule::unique('usuarios', 'email')->ignore($id, 'id_usuario'),
            ],
            'password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).+$/'
            ]
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.max' => 'El correo es demasiado largo.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres, una mayuscula, una minúscula, un número y un carácter especial.',
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
