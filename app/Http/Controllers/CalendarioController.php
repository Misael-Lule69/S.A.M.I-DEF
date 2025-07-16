<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use Carbon\Carbon;

class CalendarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:medico');
    }

    public function index()
    {
        return $this->mes();
    }

    public function mes(Request $request)
    {
        // Obtener el mes y año de la URL o usar el actual
        $mes = $request->get('mes', Carbon::now()->month);
        $anio = $request->get('anio', Carbon::now()->year);
        
        $fecha = Carbon::create($anio, $mes, 1);
        
        // Obtener todas las citas del mes
        $citas = Cita::with(['paciente', 'consultorio'])
                    ->whereYear('fecha', $anio)
                    ->whereMonth('fecha', $mes)
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get();
        
        // Organizar citas por día
        $citasPorDia = [];
        foreach ($citas as $cita) {
            $dia = $cita->fecha->format('j');
            if (!isset($citasPorDia[$dia])) {
                $citasPorDia[$dia] = [];
            }
            $citasPorDia[$dia][] = $cita;
        }
        
        return view('calendario.mes', compact('fecha', 'citasPorDia', 'citas'));
    }


}