<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function index()
    {
        return view('horarios');
    }

    public function guardar(Request $request)
    {
        $user = Auth::user();
        
        // Validar que el usuario está autenticado
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Usuario no autenticado'], 401);
        }

        // Validar los datos recibidos
        $scheduleData = $request->all();
        if (empty($scheduleData)) {
            return response()->json(['success' => false, 'message' => 'No se recibieron datos'], 400);
        }

        try {
            // Eliminar horarios existentes del usuario
            Schedule::where('user_id', $user->id)->delete();
            
            // Guardar cada día
            foreach ($scheduleData as $day => $data) {
                if (in_array($day, ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'])) {
                    // Validar y formatear los bloques
                    $blocks = isset($data['blocks']) ? $data['blocks'] : [];
                    
                    // Asegurarse de que blocks es un array
                    if (!is_array($blocks)) {
                        $blocks = [];
                    }
                    
                    // Filtrar bloques vacíos o inválidos
                    $filteredBlocks = array_filter($blocks, function($block) {
                        return isset($block['start'], $block['end']) && 
                               !empty($block['start']) && 
                               !empty($block['end']);
                    });

                    Schedule::create([
                        'user_id' => $user->id,
                        'day' => $day,
                        'active' => isset($data['active']) ? (bool)$data['active'] : false,
                        'blocks' => array_values($filteredBlocks) // Reindexar el array
                    ]);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Horarios guardados correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los horarios: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getEventos()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $schedules = Schedule::where('user_id', $user->id)->get();
        
        $formattedData = [];
        
        // Inicializar todos los días con estructura consistente
        foreach (['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'] as $day) {
            $schedule = $schedules->firstWhere('day', $day);
            $formattedData[$day] = [
                'active' => $schedule ? $schedule->active : false,
                'blocks' => $schedule ? (is_array($schedule->blocks) ? $schedule->blocks : []) : []
            ];
        }
        
        return response()->json($formattedData);
    }
}