<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medico');
    }

    public function index(Request $request)
    {
        // Obtener la fecha actual
        $hoy = Carbon::today();
        
        // Contar citas de hoy
        $citasHoy = Cita::whereDate('fecha', $hoy)->count();
        
        // Contar citas pendientes
        $citasPendientes = Cita::where('estado', 'pendiente')->count();
        
        // Contar citas realizadas
        $citasRealizadas = Cita::whereIn('estado', ['realizada', 'completada'])->count();
        
        // Obtener datos para el calendario mensual
        $mes = $request->get('mes', Carbon::now()->month);
        $anio = $request->get('anio', Carbon::now()->year);
        $fecha = Carbon::create($anio, $mes, 1);
        
        // Obtener todas las citas del mes especificado
        $citas = Cita::with(['paciente', 'consultorio'])
                    ->whereYear('fecha', $anio)
                    ->whereMonth('fecha', $mes)
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get();
        
        // Organizar citas por día para el calendario
        $citasPorDia = [];
        foreach ($citas as $cita) {
            $dia = $cita->fecha->format('j');
            if (!isset($citasPorDia[$dia])) {
                $citasPorDia[$dia] = [];
            }
            $citasPorDia[$dia][] = $cita;
        }
        
        return view('home', compact('citas', 'citasHoy', 'citasPendientes', 'citasRealizadas', 'fecha', 'citasPorDia'));
    }
}