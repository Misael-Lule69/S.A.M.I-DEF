<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return view('horarios');
    }

    public function guardar(Request $request)
{
    // Aquí puedes hacer lo que necesites con los datos
    $horarios = $request->all();

    // Por ahora, solo devolver éxito
    return response()->json(['success' => true]);
}


    public function getEventos()
    {
        // Datos de ejemplo - reemplaza con tu lógica real
        return response()->json([
            [
                'title' => 'Consulta con Dr. García',
                'start' => now()->format('Y-m-d').'T09:00:00',
                'end' => now()->format('Y-m-d').'T10:00:00',
                'color' => '#4e73df'
            ],
            [
                'title' => 'Disponible',
                'start' => now()->format('Y-m-d').'T11:00:00',
                'end' => now()->format('Y-m-d').'T12:00:00',
                'color' => '#1cc88a'
            ]
        ]);
    }
}