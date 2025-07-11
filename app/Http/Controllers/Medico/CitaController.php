<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Paciente;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Mostrar las citas pendientes del médico
     */
    public function index()
    {
        // Obtener todas las citas pendientes (asumiendo que el médico ve todas las citas)
        $citas = Cita::with(['paciente', 'consultorio'])
                    ->where('estado', 'pendiente')
                    ->orderBy('fecha', 'asc')
                    ->orderBy('hora', 'asc')
                    ->get();

        return view('citas', compact('citas'));
    }

    /**
     * Cancelar una cita como médico
     */
    public function cancelar(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        
        // Validar que la cita esté pendiente
        if ($cita->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden cancelar citas pendientes.');
        }

        // Actualizar el estado a cancelada
        $cita->update([
            'estado' => 'cancelada',
            'motivo_cancelacion' => $request->motivo_cancelacion ?? 'Cancelada por el médico'
        ]);

        // Aquí podrías agregar notificaciones al paciente si lo deseas

        return redirect()->route('citas')
                         ->with('success', 'Cita cancelada exitosamente.');
    }
}