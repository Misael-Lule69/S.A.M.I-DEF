<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;

// Rutas de autenticación (activando registro)
Auth::routes(['register' => true]);

// Ruta raíz - redirige a login o home según autenticación
Route::redirect('/', '/home');

// Rutas públicas
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth'])->group(function () {
    // Ruta de logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Ruta home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Rutas de horarios
    Route::prefix('horarios')->group(function () {
        Route::get('/', [HorarioController::class, 'index'])->name('horarios');
        Route::get('/eventos', [HorarioController::class, 'getEventos'])->name('horarios.eventos');
        Route::post('/guardar', [HorarioController::class, 'guardar'])->name('horarios.guardar');
    });

    Route::get('/schedules', function() {
    try {
        $schedules = App\Models\Schedule::all(); // O usa where() si necesitas filtrar
        return response()->json($schedules);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al obtener los horarios',
            'details' => $e->getMessage()
        ], 500);
    }
});
});