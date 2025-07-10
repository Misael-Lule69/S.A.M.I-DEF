<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Consultorio;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Añade esta línea
use Illuminate\Support\Facades\Log;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:paciente');
    }

    public function dashboard()
    {
        $citas = Cita::where('id_paciente', auth('paciente')->id())->get();
        return view('paciente.dashboard', compact('citas'));
    }

    public function mostrarCalendarioCitas()
    {
        $consultorios = Consultorio::all();
        return view('paciente.calendario-citas', compact('consultorios'));
    }

    public function obtenerHorariosDisponibles(Request $request)
{
    try {
        $request->validate([
            'fecha' => 'required|date',
            'consultorio' => 'required|exists:consultorios,id'
        ]);

        $fecha = $request->fecha;
        $idConsultorio = $request->consultorio;

        // Mapeo de días en español sin acentos
        $diasSemana = [
            1 => 'lunes',
            2 => 'martes',
            3 => 'miercoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sabado',
            7 => 'domingo'
        ];
        
        $carbonFecha = Carbon::parse($fecha);
        $diaNumero = $carbonFecha->dayOfWeekIso;
        
        if (!isset($diasSemana[$diaNumero])) {
            throw new \Exception("Día de la semana no válido: {$diaNumero}");
        }
        
        $diaSemana = $diasSemana[$diaNumero];

        // Obtener el horario configurado para ese día
        $horario = Schedule::where('day', 'like', $diaSemana)
            ->where('active', 1)
            ->first();

        if (!$horario) {
            return response()->json([
                'success' => false,
                'message' => 'No hay horario activo para este día',
                'horarios' => []
            ], 200);
        }

        // El campo blocks ya es un array gracias al cast en el modelo
        $bloques = $horario->blocks;
        
        if (empty($bloques)) {
            throw new \Exception("El campo blocks está vacío");
        }

        if (!is_array($bloques)) {
            throw new \Exception("El formato de bloques no es válido");
        }

        // Filtrar solo bloques de trabajo (work)
        $bloquesTrabajo = array_filter($bloques, function ($bloque) {
            return isset($bloque['type']) && $bloque['type'] === 'work';
        });

        // Verificar citas ya agendadas
        $citasAgendadas = Cita::where('fecha', $fecha)
            ->where('id_consultorio', $idConsultorio)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->pluck('hora')
            ->map(function ($hora) {
                return Carbon::parse($hora)->format('H:i');
            })
            ->toArray();

        // Procesar horarios disponibles
        $horariosDisponibles = [];

        foreach ($bloquesTrabajo as $bloque) {
            try {
                if (!isset($bloque['start']) || !isset($bloque['end'])) {
                    continue;
                }

                $start = Carbon::createFromFormat('H:i', $bloque['start']);
                $end = Carbon::createFromFormat('H:i', $bloque['end']);

                // Generar intervalos de 30 minutos
                $current = $start->copy();
                while ($current < $end) {
                    $horaFormato = $current->format('H:i');
                    $horaFin = $current->copy()->addMinutes(30)->format('H:i');

                    if (!in_array($horaFormato, $citasAgendadas)) {
                        $horariosDisponibles[] = [
                            'start' => $horaFormato,
                            'end' => $horaFin,
                            'label' => $bloque['label'] ?? 'Disponible'
                        ];
                    }

                    $current->addMinutes(30);
                }
            } catch (\Exception $e) {
                Log::error("Error procesando bloque: " . $e->getMessage());
                continue;
            }
        }

        return response()->json([
            'success' => true,
            'horarios' => $horariosDisponibles,
            'message' => count($horariosDisponibles) ? 'Horarios disponibles' : 'No hay horarios disponibles'
        ]);

    } catch (\Exception $e) {
        Log::error("Error en obtenerHorariosDisponibles: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error interno al obtener horarios',
            'error' => $e->getMessage(),
            'horarios' => []
        ], 500);
    }
}

    // Función auxiliar para validar formato de hora
    private function validarFormatoHora($hora)
    {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $hora);
    }

    // Función auxiliar para verificar si una hora está en un intervalo
    private function horaEnIntervalo($hora, $inicio, $fin)
    {
        $hora = strtotime($hora);
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);

        return $hora >= $inicio && $hora < $fin;
    }

    public function agendarCita(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'consultorio' => 'required|exists:consultorios,id',
            'motivo' => 'required|string|max:500'
        ]);

        // Convertir la hora al formato correcto para la base de datos
        $horaFormateada = date('H:i:s', strtotime($request->hora));

        // Verificar disponibilidad
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $horaFormateada)
            ->where('id_consultorio', $request->consultorio)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->exists();

        if ($citaExistente) {
            return back()
                ->withInput()
                ->with('error', 'El horario seleccionado ya no está disponible.');
        }

        try {
            DB::beginTransaction();

            $cita = new Cita();
            $cita->id_paciente = auth('paciente')->id();
            $cita->id_consultorio = $request->consultorio;
            $cita->fecha = $request->fecha;
            $cita->hora = $horaFormateada;
            $cita->motivo = $request->motivo;
            $cita->estado = 'pendiente';
            $cita->confirmada = false;
            $cita->confirmacion_enviada = false;
            $cita->save();

            DB::commit();

            return redirect()
                ->route('paciente.dashboard')
                ->with('success', 'Cita agendada correctamente para el ' .
                    Carbon::parse($request->fecha)->format('d/m/Y') .
                    ' a las ' . date('h:i A', strtotime($request->hora)));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agendar cita: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al agendar la cita. Por favor intente nuevamente.');
        }
    }

    public function cancelarCita($id)
    {
        $cita = Cita::where('id_paciente', auth('paciente')->id())
            ->where('id', $id)
            ->firstOrFail();

        $cita->estado = 'cancelada';
        $cita->save();

        return back()->with('success', 'Cita cancelada correctamente.');
    }
}
