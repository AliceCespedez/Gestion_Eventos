<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AsientoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MesaController;


Route::get('/', fn() => view('welcome'));


// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// PROTEGIDAS
Route::middleware(['auth', 'nocache'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {

        if (Auth::user()->rol === 'empleado') {
            $eventos = \App\Models\Evento::with(['tipo', 'usuario'])->get();
        } else {
            $eventos = \App\Models\Evento::with(['tipo'])
                ->where('id_usuario', Auth::user()->id_usuario)
                ->get();
        }

        return view('dashboard', compact('eventos'));
    })->middleware('role:cliente,empleado')
        ->name('dashboard');


    Route::get('/admin', fn() => view('admin'))
        ->middleware('role:admin')
        ->name('admin');
});


// CLIENTES
Route::get('/clientes', function () {
    return view('clientes.index', [
        'clientes' => \App\Models\Usuario::where('rol', 'cliente')->get()
    ]);
})->middleware(['auth', 'role:empleado,admin'])
    ->name('clientes.index');


// EMPLEADOS
Route::get('/empleados', function () {
    return view('empleados.index', [
        'empleados' => \App\Models\Usuario::where('rol', 'empleado')->get()
    ]);
})->middleware(['auth', 'role:admin'])
    ->name('empleados.index');


// CREAR USUARIOS
Route::post('/users/create', [AuthController::class, 'createUserByRole'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('users.store');


// ============================
// EVENTOS (MEJORADO)
// ============================

// LISTADO (ahora con controller)
Route::get('/eventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('eventos.index');


// DETALLE EVENTO + SEATING PLAN
Route::get('/eventos/{evento}', [EventoController::class, 'show'])
    ->middleware('auth')
    ->name('eventos.show');


// ============================
// SEATING PLAN (ASIGNACIÓN)
// ============================

Route::post('/asientos/asignar', [AsientoController::class, 'asignar'])
    ->middleware('auth')
    ->name('asientos.asignar');

Route::post('/asientos/desasignar', [AsientoController::class, 'desasignar'])
    ->middleware('auth')
    ->name('asientos.desasignar');

//Mesas
Route::get('/eventos/{evento}/mesas', [MesaController::class, 'porEvento'])
    ->middleware('auth')
    ->name('mesas.porEvento');
    
// ACCESO DENEGADO
Route::get('/acceso-denegado', function () {
    return redirect('/');
})->name('access.denied');
