<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;

// Rutas de autenticación (desactivando registro)
Auth::routes(['register' => false]);

// Rutas públicas
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Ruta de logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Ruta home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Ruta de horarios
    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios');
    
    // Ruta para obtener eventos del calendario (AJAX)
    Route::get('/horarios/eventos', [HorarioController::class, 'getEventos'])->name('horarios.eventos');

    Auth::routes();
});

