<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Consultorio;
use Carbon\Carbon;

// Obtener pacientes existentes
$pacientes = Paciente::all();
echo "Pacientes encontrados: " . $pacientes->count() . "\n";

// Crear o obtener consultorio
$consultorio = Consultorio::firstOrCreate([
    'nombre' => 'Consultorio Principal'
], [
    'ubicacion' => 'Planta Baja'
]);

echo "Consultorio: " . $consultorio->nombre . "\n";

// Crear citas para cada paciente
foreach ($pacientes as $paciente) {
    // Crear cita para hoy
    $cita1 = Cita::firstOrCreate([
        'id_paciente' => $paciente->id,
        'fecha' => Carbon::today(),
        'hora' => '09:00:00'
    ], [
        'id_consultorio' => $consultorio->id,
        'motivo' => 'Consulta general',
        'estado' => 'confirmada',
        'confirmada' => true,
        'confirmacion_enviada' => true
    ]);

    // Crear cita para mañana
    $cita2 = Cita::firstOrCreate([
        'id_paciente' => $paciente->id,
        'fecha' => Carbon::tomorrow(),
        'hora' => '14:00:00'
    ], [
        'id_consultorio' => $consultorio->id,
        'motivo' => 'Seguimiento',
        'estado' => 'confirmada',
        'confirmada' => true,
        'confirmacion_enviada' => true
    ]);

    echo "Citas creadas para {$paciente->nombre} {$paciente->apellido_paterno}\n";
}

echo "\n=== CITAS CREADAS ===\n";
$citas = Cita::where('estado', 'confirmada')->get();
foreach ($citas as $cita) {
    $paciente = Paciente::find($cita->id_paciente);
    echo "Cita #{$cita->id} - {$paciente->nombre} {$paciente->apellido_paterno} - {$cita->fecha} {$cita->hora} - {$cita->motivo}\n";
}

echo "\nTotal de citas confirmadas: " . $citas->count() . "\n"; 