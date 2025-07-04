<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\MedicoLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\PacienteController;

// Rutas de autenticación para pacientes (con registro)
Auth::routes(['register' => true]);

// Ruta raíz - redirige según tipo de usuario
Route::get('/', function () {
    if (Auth::guard('medico')->check()) {
        return redirect('/home');
    } elseif (Auth::check()) {
        return redirect('/paciente/dashboard');
    }
    return redirect('/login');
});

// Ruta de login para médico
Route::get('/medico/login', [MedicoLoginController::class, 'showLoginForm'])->name('medico.login');
Route::post('/medico/login', [MedicoLoginController::class, 'login']);

// Rutas públicas comunes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Rutas protegidas para PACIENTES
Route::middleware(['auth:paciente'])->group(function () {
    // Ruta de logout para pacientes
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard de paciente
    Route::get('/paciente/dashboard', [PacienteController::class, 'dashboard'])->name('paciente.dashboard');
    
    // Otras rutas específicas de pacientes...
});

// Rutas protegidas para MÉDICO (admin)
Route::middleware(['auth:medico'])->group(function () {
    // Ruta de logout para médico
    Route::post('/medico/logout', [MedicoLoginController::class, 'logout'])->name('medico.logout');
    
    // Ruta home (solo médico)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Rutas de horarios (solo médico)
    Route::prefix('horarios')->group(function () {
        Route::get('/', [HorarioController::class, 'index'])->name('horarios');
        Route::get('/eventos', [HorarioController::class, 'getEventos'])->name('horarios.eventos');
        Route::post('/guardar', [HorarioController::class, 'guardar'])->name('horarios.guardar');
    });

    // Ruta de schedules (solo médico)
    Route::get('/schedules', function() {
        try {
            $schedules = App\Models\Schedule::all();
            return response()->json($schedules);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener los horarios',
                'details' => $e->getMessage()
            ], 500);
        }
    });
});