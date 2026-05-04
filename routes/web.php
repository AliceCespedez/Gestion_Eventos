<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\InvitadoController;
use Illuminate\Support\Facades\Route;
use  App\Models\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;

// PÚBLICAS
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
    Route::get('/dashboard', [EventoController::class, 'dashboard'])
        ->name('dashboard');

    // ADMIN DASHBOARD
    Route::get('/admin/dashboard', [EventoController::class, 'dashboardAdmin'])
        ->name('eventos.dashboardAdmin');

    // ADMIN PANEL
    Route::get('/admin', function () {

        $eventos = \App\Models\Evento::with(['tipo', 'usuario'])->get();

        return view('admin', compact('eventos'));
    })->middleware(['role:admin'])->name('admin');
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

// USUARIOS
Route::post('/users/create', [AuthController::class, 'createUserByRole'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('users.store');

// EVENTOS
Route::get('/eventos/create', [EventoController::class, 'create'])
    ->middleware('auth')
    ->name('eventos.create');

Route::post('/eventos', [EventoController::class, 'store'])
    ->middleware('auth')
    ->name('eventos.store');

Route::get('/eventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('eventos.index');

Route::get('/eventos/{evento}', [EventoController::class, 'show'])
    ->middleware('auth')
    ->name('eventos.show');

Route::get('/eventos/{evento}/resumen', [EventoController::class, 'summary'])
    ->middleware('auth')
    ->name('eventos.summary');

// MESAS
Route::get('/eventos/{evento}/mesas', [MesaController::class, 'porEvento'])
    ->middleware('auth')
    ->name('mesas.porEvento');

// ASIENTOS
Route::post('/asientos/asignar', [AsientoController::class, 'asignar'])
    ->middleware('auth')
    ->name('asientos.asignar');

Route::post('/asientos/desasignar', [AsientoController::class, 'desasignar'])
    ->middleware('auth')
    ->name('asientos.desasignar');


// INVITADOS
Route::get('/eventos/{evento}/invitados', function ($evento) {

    $evento = \App\Models\Evento::with('invitados')->findOrFail($evento);

    return view('invitados.index', compact('evento'));
})->middleware('auth')->name('invitados.lista');

Route::post('/invitados/{inv}/estado', [InvitadoController::class, 'cambiarEstado'])
    ->middleware('auth')
    ->name('invitados.estado');

Route::get('/eventos/solicitar', [EventoController::class, 'create'])
    ->name('eventos.create');

// ADMIN
Route::get('/admin/eventos/create', function (Request $request) {

    return view('eventos.admin_create', [
        'locales' => \App\Models\Local::all(),
        'tipos' => \App\Models\TipoEvento::all(),
        'menus' => \App\Models\Menu::all(),
        'clientes' => \App\Models\Usuario::where('rol', 'cliente')->get(),
        'clienteSeleccionado' => $request->query('cliente')
    ]);
})
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.admin_create');

    //Menús
Route::post('/eventos/{evento}/menu', [EventoController::class, 'attachMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.attach');

Route::put('/eventos/{evento}/menu/{menu}', [EventoController::class, 'updateMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.update');

Route::delete('/eventos/{evento}/menu/{menu}', [EventoController::class, 'detachMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.delete');

// ACCESO DENEGADO
Route::get('/acceso-denegado', function () {
    return redirect('/');
})->name('access.denied');
