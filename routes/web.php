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
    
    // Rutas para citas
    Route::get('/paciente/agendar-cita', [PacienteController::class, 'mostrarCalendarioCitas'])->name('paciente.calendario-citas');
    Route::get('/paciente/horarios-disponibles', [PacienteController::class, 'obtenerHorariosDisponibles'])
    ->name('paciente.horarios-disponibles')
    ->middleware('auth:paciente');
    Route::post('/paciente/agendar-cita', [PacienteController::class, 'agendarCita'])->name('paciente.agendar-cita');
    Route::post('/paciente/cancelar-cita/{id}', [PacienteController::class, 'cancelarCita'])->name('paciente.cancelar-cita');
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

    // Rutas de expedientes clínicos
    Route::prefix('expedientes')->group(function () {
        Route::get('/', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'index'])->name('expedientes.index');
        Route::get('/crear', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'create'])->name('expedientes.create');
        Route::post('/', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'store'])->name('expedientes.store');
        Route::get('/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'show'])->name('expedientes.show');
        Route::get('/{id}/editar', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'edit'])->name('expedientes.edit');
        Route::put('/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'update'])->name('expedientes.update');
        Route::delete('/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'destroy'])->name('expedientes.destroy');
        
        // Rutas para búsqueda AJAX
        Route::get('/buscar-pacientes', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'buscarPacientes'])->name('expedientes.buscar-pacientes');
        Route::get('/buscar-citas', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'buscarCitas'])->name('expedientes.buscar-citas');
        Route::get('/paciente/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'obtenerPaciente'])->name('expedientes.obtener-paciente');
        Route::get('/expedientes-paciente/{idPaciente}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'expedientesPaciente'])->name('expedientes.expedientes-paciente');
        
        // Rutas para gestión de pacientes
        Route::put('/pacientes/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'actualizarPaciente'])->name('pacientes.update');
        Route::delete('/pacientes/{id}', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'eliminarPaciente'])->name('pacientes.destroy');
        
        // Ruta para generar PDF
        Route::get('/expediente/{id}/pdf', [\App\Http\Controllers\Expedientes\ExpedientesController::class, 'generarPDF'])->name('expedientes.pdf');
    });
});