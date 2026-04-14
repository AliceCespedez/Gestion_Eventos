<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// 🔐 AUTH
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔒 PROTEGIDAS
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', fn () => view('dashboard'))
        ->middleware('role:cliente,empleado')
        ->name('dashboard');

    Route::get('/admin', fn () => view('admin'))
        ->middleware('role:admin')
        ->name('admin');

    Route::get('/empleado', fn () => view('dashboard'))
        ->middleware('role:empleado')
        ->name('empleado');

    Route::get('/cliente', fn () => view('dashboard'))
        ->middleware('role:cliente')
        ->name('cliente');

});