<?php

// app/Http/Controllers/ScheduleController.php
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function save(Request $request)
    {
        $user = Auth::user();
        $scheduleData = $request->all();
        
        // Eliminar horarios existentes del usuario
        Schedule::where('user_id', $user->id)->delete();
        
        // Guardar cada día
        foreach ($scheduleData as $day => $data) {
            if (in_array($day, ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'])) {
                Schedule::create([
                    'user_id' => $user->id,
                    'day' => $day,
                    'active' => $data['active'],
                    'blocks' => $data['blocks']
                ]);
            }
        }
        
        return response()->json(['success' => true]);
    }
    
    public function get()
    {
        $user = Auth::user();
        $schedules = Schedule::where('user_id', $user->id)->get();
        
        $formattedData = [];
        foreach ($schedules as $schedule) {
            $formattedData[$schedule->day] = [
                'active' => $schedule->active,
                'blocks' => $schedule->blocks
            ];
        }
        
        return response()->json($formattedData);
    }
}