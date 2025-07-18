<?php
namespace App\Http\Controllers\Expedientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\ExpedienteClinico;
use App\Models\Cita;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpedientesController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');
        $pacientes = collect();
        
        if ($busqueda) {
            $pacientes = Paciente::where('nombre', 'like', "%$busqueda%")
                ->orWhere('apellido_paterno', 'like', "%$busqueda%")
                ->orWhere('apellido_materno', 'like', "%$busqueda%")
                ->orWhere('id', $busqueda)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $pacientes = Paciente::orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('expedientes.index', compact('pacientes', 'busqueda'));
    }

    public function create(Request $request)
    {
        $paciente = null;
        
        // Si se pasa un paciente_id, obtener los datos del paciente
        if ($request->has('paciente_id')) {
            $paciente = Paciente::find($request->paciente_id);
        }
        
        return view('expedientes.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_paciente' => 'required|exists:pacientes,id',
            'fecha_atencion' => 'required|date',
            'numero_visita' => 'nullable|integer|min:1',
            'tipo_interrogatorio' => 'required|string|max:255',
            'nombre_paciente' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'domicilio' => 'required|string',
            'ocupacion' => 'nullable|string',
            'parentesco_1' => 'nullable|string',
            'parentesco_2' => 'nullable|string',
            'antecedentes_heredo_familiares' => 'nullable|string',
            'antecedentes_personales_no_patologicos' => 'nullable|string',
            'antecedentes_perinatales' => 'nullable|string',
            'alimentacion' => 'nullable|string',
            'inmunizaciones' => 'nullable|string',
            'desarrollo_psicomotor' => 'nullable|string',
            'antecedentes_personales_patologicos' => 'nullable|string',
            'padecimiento_actual' => 'required|string',
            'interrogatorio_cardiovascular' => 'nullable|string',
            'interrogatorio_respiratorio' => 'nullable|string',
            'interrogatorio_gastrointestinal' => 'nullable|string',
            'interrogatorio_genitourinario' => 'nullable|string',
            'interrogatorio_hematolinfatico' => 'nullable|string',
            'interrogatorio_nervoso' => 'nullable|string',
            'interrogatorio_musculo_esqueletico' => 'nullable|string',
            'interrogatorio_piel_mucosas' => 'nullable|string',
            'signos_ta' => 'nullable|string|max:10',
            'signos_temp' => 'nullable|string|max:10',
            'signos_frec_c' => 'nullable|string|max:10',
            'signos_frec_r' => 'nullable|string|max:10',
            'signos_peso' => 'nullable|string|max:10',
            'signos_talla' => 'nullable|string|max:10',
            'exploracion_habitus' => 'nullable|string',
            'exploracion_cabeza' => 'nullable|string',
            'exploracion_cuello' => 'nullable|string',
            'exploracion_torax' => 'nullable|string',
            'exploracion_abdomen' => 'nullable|string',
            'exploracion_genitales' => 'nullable|string',
            'exploracion_extremidades' => 'nullable|string',
            'exploracion_piel' => 'nullable|string',
            'resultados_laboratorio' => 'nullable|string',
            'estudios_gabinete' => 'nullable|string',
            'diagnosticos' => 'required|string',
            'tratamiento' => 'required|string',
            'pronostico' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calcular número de visita basado en padecimientos anteriores
        $padecimientosAnteriores = ExpedienteClinico::where('id_paciente', $request->id_paciente)
            ->whereNotNull('padecimiento_actual')
            ->where('padecimiento_actual', '!=', '')
            ->count();
        $numeroVisita = $padecimientosAnteriores + 1;

        // Procesar padecimientos adicionales
        $padecimientosAdicionales = [];
        if ($request->has('padecimientos_adicionales_json')) {
            $padecimientosAdicionales = json_decode($request->padecimientos_adicionales_json, true) ?? [];
        }

        // Guardar expediente sin crear cita
        $expediente = new ExpedienteClinico($request->all());
        $expediente->fecha_elaboracion = \Carbon\Carbon::now()->toDateString();
        $expediente->hora_elaboracion = \Carbon\Carbon::now()->toTimeString();
        $expediente->numero_visita = $numeroVisita;
        $expediente->padecimientos_adicionales = $padecimientosAdicionales;
        if (!$request->filled('fecha_atencion')) {
            $expediente->fecha_atencion = \Carbon\Carbon::now()->toDateString();
        }
        $expediente->save();

        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente clínico creado exitosamente.');
    }

    public function show($id)
    {
        $expediente = ExpedienteClinico::findOrFail($id);
        return view('expedientes.show', compact('expediente'));
    }

    public function edit($id)
    {
        $expediente = ExpedienteClinico::findOrFail($id);
        $pacientes = Paciente::orderBy('nombre')->get();
        $citas = Cita::where('estado', 'confirmada')->orderBy('fecha', 'desc')->get();
        return view('expedientes.edit', compact('expediente', 'pacientes', 'citas'));
    }

    public function update(Request $request, $id)
    {
        $expediente = ExpedienteClinico::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'id_paciente' => 'required|exists:pacientes,id',
            'fecha_atencion' => 'required|date',
            'numero_visita' => 'nullable|integer|min:1',
            'tipo_interrogatorio' => 'required|string|max:255',
            'nombre_paciente' => 'required|string|max:255',
            'edad' => 'required|integer|min:0|max:150',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'domicilio' => 'required|string',
            'ocupacion' => 'nullable|string',
            'parentesco_1' => 'nullable|string',
            'parentesco_2' => 'nullable|string',
            'antecedentes_heredo_familiares' => 'nullable|string',
            'antecedentes_personales_no_patologicos' => 'nullable|string',
            'antecedentes_perinatales' => 'nullable|string',
            'alimentacion' => 'nullable|string',
            'inmunizaciones' => 'nullable|string',
            'desarrollo_psicomotor' => 'nullable|string',
            'antecedentes_personales_patologicos' => 'nullable|string',
            'padecimiento_actual' => 'required|string',
            'interrogatorio_cardiovascular' => 'nullable|string',
            'interrogatorio_respiratorio' => 'nullable|string',
            'interrogatorio_gastrointestinal' => 'nullable|string',
            'interrogatorio_genitourinario' => 'nullable|string',
            'interrogatorio_hematolinfatico' => 'nullable|string',
            'interrogatorio_nervoso' => 'nullable|string',
            'interrogatorio_musculo_esqueletico' => 'nullable|string',
            'interrogatorio_piel_mucosas' => 'nullable|string',
            'signos_ta' => 'nullable|string|max:10',
            'signos_temp' => 'nullable|string|max:10',
            'signos_frec_c' => 'nullable|string|max:10',
            'signos_frec_r' => 'nullable|string|max:10',
            'signos_peso' => 'nullable|string|max:10',
            'signos_talla' => 'nullable|string|max:10',
            'exploracion_habitus' => 'nullable|string',
            'exploracion_cabeza' => 'nullable|string',
            'exploracion_cuello' => 'nullable|string',
            'exploracion_torax' => 'nullable|string',
            'exploracion_abdomen' => 'nullable|string',
            'exploracion_genitales' => 'nullable|string',
            'exploracion_extremidades' => 'nullable|string',
            'exploracion_piel' => 'nullable|string',
            'resultados_laboratorio' => 'nullable|string',
            'estudios_gabinete' => 'nullable|string',
            'diagnosticos' => 'required|string',
            'tratamiento' => 'required|string',
            'pronostico' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Recalcular número de visita basado en padecimientos anteriores
        $padecimientosAnteriores = ExpedienteClinico::where('id_paciente', $request->id_paciente)
            ->where('id', '<=', $expediente->id)
            ->whereNotNull('padecimiento_actual')
            ->where('padecimiento_actual', '!=', '')
            ->count();
        $numeroVisita = $padecimientosAnteriores;

        // Procesar padecimientos adicionales
        $padecimientosAdicionales = [];
        if ($request->has('padecimientos_adicionales_json')) {
            $padecimientosAdicionales = json_decode($request->padecimientos_adicionales_json, true) ?? [];
        }

        $expediente->update($request->all());
        $expediente->numero_visita = $numeroVisita;
        $expediente->padecimientos_adicionales = $padecimientosAdicionales;
        if (!$request->filled('fecha_atencion')) {
            $expediente->fecha_atencion = \Carbon\Carbon::now()->toDateString();
        }
        $expediente->save();

        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente clínico actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $expediente = ExpedienteClinico::findOrFail($id);
        $expediente->delete();

        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente clínico eliminado exitosamente.');
    }

    public function buscarPacientes(Request $request)
    {
        $busqueda = $request->input('q');
        $pacientes = Paciente::where('nombre', 'like', "%$busqueda%")
            ->orWhere('apellido_paterno', 'like', "%$busqueda%")
            ->orWhere('apellido_materno', 'like', "%$busqueda%")
            ->orWhere('id', $busqueda)
            ->limit(10)
            ->get(['id', 'nombre', 'apellido_paterno', 'apellido_materno']);

        return response()->json($pacientes);
    }

    public function buscarCitas(Request $request)
    {
        $idPaciente = $request->input('id_paciente');
        $citas = Cita::where('id_paciente', $idPaciente)
            ->whereIn('estado', ['realizada', 'pendiente']) // Usar valores válidos del ENUM
            ->orderBy('fecha', 'desc')
            ->get(['id', 'fecha', 'hora', 'motivo']);

        return response()->json($citas);
    }

    public function obtenerPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    public function expedientesPaciente($idPaciente)
    {
        $paciente = Paciente::findOrFail($idPaciente);
        $expedientes = ExpedienteClinico::where('id_paciente', $idPaciente)->orderBy('fecha_elaboracion', 'desc')->get();
        
        return view('expedientes.expedientes-paciente', compact('paciente', 'expedientes'));
    }

    public function actualizarPaciente(Request $request, $id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            
            // Validar los datos
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'nullable|string|max:100',
                'telefono' => 'required|string|max:20|unique:pacientes,telefono,' . $id,
            ]);

            // Actualizar el paciente
            $paciente->update($validated);

            return response()->json(['success' => true, 'message' => 'Paciente actualizado correctamente']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el paciente: ' . $e->getMessage()], 500);
        }
    }

    public function eliminarPaciente($id)
    {
        try {
            $paciente = Paciente::findOrFail($id);
            
            // Verificar si tiene expedientes
            $tieneExpedientes = ExpedienteClinico::where('id_paciente', $id)->exists();

            if ($tieneExpedientes) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el paciente porque tiene expedientes asociados'], 400);
            }

            // Verificar si tiene citas
            $tieneCitas = Cita::where('id_paciente', $id)->exists();
            if ($tieneCitas) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar el paciente porque tiene citas asociadas'], 400);
            }

            $paciente->delete();
            return response()->json(['success' => true, 'message' => 'Paciente eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el paciente: ' . $e->getMessage()], 500);
        }
    }

    public function generarPDF($id)
    {
        $expediente = ExpedienteClinico::with('cita.paciente')->findOrFail($id);
        
        // Generar el PDF
        $pdf = Pdf::loadView('expedientes.pdf', compact('expediente'));
        
        // Configurar el PDF
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial'
        ]);
        
        // Generar nombre del archivo
        $nombreArchivo = 'Expediente_' . $expediente->nombre_paciente . '_' . $expediente->fecha_elaboracion . '.pdf';
        $nombreArchivo = str_replace([' ', '/'], ['_', '-'], $nombreArchivo);
        
        // Descargar el PDF
        return $pdf->download($nombreArchivo);
    }
} 