<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AsientoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\InvitadoController;

//Públicas

Route::get('/', fn() => view('welcome'));

//Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

//Protegidas

Route::middleware(['auth', 'nocache'])->group(function () {

    // DASHBOARD (ÚNICO)
    Route::get('/dashboard', [EventoController::class, 'dashboard'])
        ->name('dashboard');

    // Dashboard admin
    Route::get('/admin/dashboard', [EventoController::class, 'dashboardAdmin'])
        ->name('eventos.dashboardAdmin')
        ->middleware('auth');

    // ADMIN 
    Route::get('/admin', function () {

        $eventos = \App\Models\Evento::with(['tipo', 'usuario'])->get();

        return view('admin', compact('eventos'));
    })->middleware(['role:admin'])->name('admin');
});

//Clientes
Route::get('/clientes', function () {
    return view('clientes.index', [
        'clientes' => \App\Models\Usuario::where('rol', 'cliente')->get()
    ]);
})->middleware(['auth', 'role:empleado,admin'])
    ->name('clientes.index');

//Empleados
Route::get('/empleados', function () {
    return view('empleados.index', [
        'empleados' => \App\Models\Usuario::where('rol', 'empleado')->get()
    ]);
})->middleware(['auth', 'role:admin'])
    ->name('empleados.index');

//Usuarios
Route::post('/users/create', [AuthController::class, 'createUserByRole'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('users.store');

//Eventos
Route::get('/eventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('eventos.index');

Route::get('/eventos/{evento}', [EventoController::class, 'show'])
    ->middleware('auth')
    ->name('eventos.show');

// Resumen del evento
Route::get('/eventos/{evento}/resumen', [EventoController::class, 'summary'])
    ->middleware('auth')
    ->name('eventos.summary');

//Asientos
Route::post('/asientos/asignar', [AsientoController::class, 'asignar'])
    ->middleware('auth')
    ->name('asientos.asignar');

Route::post('/asientos/desasignar', [AsientoController::class, 'desasignar'])
    ->middleware('auth')
    ->name('asientos.desasignar');


// Mesas
Route::get('/eventos/{evento}/mesas', [MesaController::class, 'porEvento'])
    ->middleware('auth')
    ->name('mesas.porEvento');

//Invitados
Route::get('/eventos/{evento}/invitados', function ($evento) {

    $evento = \App\Models\Evento::with('invitados')->findOrFail($evento);

    return view('invitados.index', compact('evento'));
})->middleware('auth')->name('invitados.lista');

// Cambiar estado del invitado 
Route::post('/invitados/{inv}/estado', [InvitadoController::class, 'cambiarEstado'])
    ->middleware('auth')
    ->name('invitados.estado');

//Acceso denegado
Route::get('/acceso-denegado', function () {
    return redirect('/');
})->name('access.denied');
