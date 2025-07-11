<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Paciente;
use App\Models\Cita;

echo "=== PRUEBA DE BÚSQUEDA DE PACIENTES ===\n";

// Listar todos los pacientes
$pacientes = Paciente::all();
echo "Pacientes en la base de datos:\n";
foreach ($pacientes as $paciente) {
    echo "- ID: {$paciente->id}, Nombre: {$paciente->nombre} {$paciente->apellido_paterno} {$paciente->apellido_materno}\n";
}

echo "\n=== PRUEBA DE BÚSQUEDA ===\n";
$busqueda = "Juan";
$resultados = Paciente::where('nombre', 'like', "%$busqueda%")
    ->orWhere('apellido_paterno', 'like', "%$busqueda%")
    ->orWhere('apellido_materno', 'like', "%$busqueda%")
    ->orWhere('id', $busqueda)
    ->limit(10)
    ->get(['id', 'nombre', 'apellido_paterno', 'apellido_materno']);

echo "Búsqueda por '$busqueda':\n";
foreach ($resultados as $paciente) {
    echo "- {$paciente->nombre} {$paciente->apellido_paterno} {$paciente->apellido_materno} (ID: {$paciente->id})\n";
}

echo "\n=== PRUEBA DE CITAS ===\n";
$citas = Cita::where('estado', 'confirmada')->get();
echo "Citas confirmadas:\n";
foreach ($citas as $cita) {
    echo "- Cita #{$cita->id} - Paciente ID: {$cita->id_paciente} - {$cita->fecha} {$cita->hora} - {$cita->motivo}\n";
}

if ($citas->count() > 0) {
    $primeraCita = $citas->first();
    echo "\n=== PRUEBA DE CITAS POR PACIENTE ===\n";
    $citasPaciente = Cita::where('id_paciente', $primeraCita->id_paciente)
        ->where('estado', 'confirmada')
        ->orderBy('fecha', 'desc')
        ->get(['id', 'fecha', 'hora', 'motivo']);
    
    echo "Citas del paciente ID {$primeraCita->id_paciente}:\n";
    foreach ($citasPaciente as $cita) {
        echo "- Cita #{$cita->id} - {$cita->fecha} {$cita->hora} - {$cita->motivo}\n";
    }
} 