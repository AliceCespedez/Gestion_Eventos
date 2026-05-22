<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\ConsultaController;
use App\Models\Usuario;
use App\Models\Evento;

// PÚBLICAS
Route::get('/', fn() => view('welcome'));

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.attempt');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// PROTEGIDAS
Route::middleware(['auth', 'nocache'])->group(function () {

    Route::get('/dashboard', [EventoController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/admin', [EventoController::class, 'dashboardAdmin'])
        ->middleware(['role:admin'])
        ->name('admin');

    /*
    Route::get('/admin/dashboard', [EventoController::class, 'admin'])
        ->name('eventos.dashboardAdmin');
    */
    /*
    Route::get('/admin', function () {

        $eventos = Evento::with(['tipo', 'usuario'])->get();

        return view('admin', compact('eventos'));
    })->middleware(['role:admin'])->name('admin');
    */
});


// CLIENTES (CON BUSCADOR)
Route::get('/clientes', function (Request $request) {

    $query = Usuario::where('rol', 'cliente');

    //  Buscador 
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    return view('clientes.index', [
        'clientes' => $query->get(),
        'search' => $request->search
    ]);
})->middleware(['auth', 'role:empleado,admin'])
    ->name('clientes.index');

// EMPLEADOS
Route::get('/empleados', function () {
    return view('empleados.index', [
        'empleados' => Usuario::where('rol', 'empleado')->get()
    ]);
})->middleware(['auth', 'role:admin'])
    ->name('empleados.index');

//Buscador empleados
Route::get('/empleados', function (Request $request) {

    $query = \App\Models\Usuario::where('rol', 'empleado');

    //  BUSCADOR
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('nombre', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    return view('empleados.index', [
        'empleados' => $query->get(),
        'search' => $request->search
    ]);
})->middleware(['auth', 'role:admin'])
    ->name('empleados.index');


//  USUARIOS (CREAR)
Route::post('/users/create', [AuthController::class, 'createUserByRole'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('users.store');

// ELIMINAR USUARIOS
Route::delete('/users/{id}', [AuthController::class, 'destroy'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('users.destroy');

// EVENTOS
Route::get('/eventos/create', [EventoController::class, 'create'])
    ->middleware('auth')
    ->name('eventos.create');

Route::get('/eventos/solicitar', [EventoController::class, 'create'])
    ->middleware('auth')
    ->name('eventos.solicitar');

Route::post('/eventos', [EventoController::class, 'store'])
    ->middleware('auth')
    ->name('eventos.store');

Route::get('/eventos', [EventoController::class, 'index'])
    ->middleware('auth')
    ->name('eventos.index');

Route::get('/eventos/{evento}', [EventoController::class, 'show'])
    ->middleware('auth')
    ->name('eventos.show');

Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.destroy');

Route::get('/eventos/{evento}/resumen', [EventoController::class, 'summary'])
    ->middleware('auth')
    ->name('eventos.summary');

//Buscador eventos
Route::get('/eventos', function (Request $request) {

    $buscar = $request->buscar;

    $eventos = Evento::with(['tipo', 'usuario'])

        ->when($buscar, function ($query, $buscar) {
            $query->where('nombre_evento', 'like', "%{$buscar}%");
        })

        ->get();

    return view('eventos.index', compact('eventos'));
})->middleware('auth')->name('eventos.index');

//  MESAS
Route::get('/eventos/{evento}/mesas', [MesaController::class, 'porEvento'])
    ->middleware('auth')
    ->name('mesas.porEvento');

//  ASIENTOS
Route::post('/asientos/asignar', [AsientoController::class, 'asignar'])
    ->middleware('auth')
    ->name('asientos.asignar');

Route::post('/asientos/desasignar', [AsientoController::class, 'desasignar'])
    ->middleware('auth')
    ->name('asientos.desasignar');

// INVITADOS
Route::get('/eventos/{evento}/invitados', function ($evento) {

    $evento = Evento::with('invitados')->findOrFail($evento);

    return view('invitados.index', compact('evento'));
})->middleware('auth')
    ->name('invitados.lista');

Route::post('/invitados/{id}/estado', [InvitadoController::class, 'cambiarEstado'])
    ->middleware('auth')
    ->name('invitados.estado');

Route::post('/eventos/{evento}/invitados', [InvitadoController::class, 'store'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('invitados.store');

//Eliminar invitado
Route::delete('/invitados/{id}', [InvitadoController::class, 'destroy'])
    ->name('invitados.destroy');

//  MENÚS
Route::post('/eventos/{evento}/menu', [EventoController::class, 'attachMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.attach');

Route::put('/eventos/{evento}/menu/{menu}', [EventoController::class, 'updateMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.update');

Route::delete('/eventos/{evento}/menu/{menu}', [EventoController::class, 'detachMenu'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.menu.delete');

// SERVICIOS
Route::post('/eventos/{evento}/servicio', [EventoController::class, 'attachServicio'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.servicio.attach');

Route::put('/eventos/{evento}/servicio/{servicio}', [EventoController::class, 'updateServicio'])
    ->name('eventos.servicio.update');

Route::delete('/eventos/{evento}/servicio/{servicio}', [EventoController::class, 'detachServicio'])
    ->name('eventos.servicio.delete');

// CONSULTAS
Route::post('/consulta', [ConsultaController::class, 'store'])->name('consulta.store');

Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');

Route::patch('/consultas/{consulta}/leer', [ConsultaController::class, 'marcarLeido'])
    ->name('consultas.leer');

Route::delete('/consultas/{consulta}', [ConsultaController::class, 'destroy'])
    ->name('consultas.destroy');

// Notificaciones
Route::get('/consultas/{consulta}/leer', [ConsultaController::class, 'marcarLeido'])
    ->name('consultas.leer');
// ADMIN EVENTOS
Route::get('/admin/eventos/create', [EventoController::class, 'adminCreate'])
    ->middleware(['auth', 'role:admin,empleado'])
    ->name('eventos.admin_create');

//  ACCESO DENEGADO
Route::get('/acceso-denegado', function () {
    return redirect('/');
})->name('access.denied');
