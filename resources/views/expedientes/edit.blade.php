@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Editar Expediente Clínico #{{ $expediente->id }}</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('expedientes.update', $expediente->id) }}" id="expedienteForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Sección de Identificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-user"></i> Identificación del Paciente
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_cita" class="form-label">Cita *</label>
                                <select name="id_cita" id="id_cita" class="form-select" required>
                                    <option value="">Seleccione una cita...</option>
                                    @foreach($citas as $cita)
                                        <option value="{{ $cita->id }}" {{ $expediente->id_cita == $cita->id ? 'selected' : '' }}>
                                            Cita #{{ $cita->id }} - {{ $cita->fecha }} {{ $cita->hora }} - {{ $cita->motivo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tipo_interrogatorio" class="form-label">Tipo de Interrogatorio *</label>
                                <input type="text" name="tipo_interrogatorio" id="tipo_interrogatorio" 
                                       class="form-control" value="{{ old('tipo_interrogatorio', $expediente->tipo_interrogatorio) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre_paciente" class="form-label">Nombre Completo del Paciente *</label>
                                <input type="text" name="nombre_paciente" id="nombre_paciente" 
                                       class="form-control" value="{{ old('nombre_paciente', $expediente->nombre_paciente) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="edad" class="form-label">Edad *</label>
                                <input type="number" name="edad" id="edad" class="form-control" 
                                       min="0" max="150" value="{{ old('edad', $expediente->edad) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="genero" class="form-label">Género *</label>
                                <select name="genero" id="genero" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino" {{ $expediente->genero == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ $expediente->genero == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ $expediente->genero == 'Otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="domicilio" class="form-label">Domicilio *</label>
                                <textarea name="domicilio" id="domicilio" class="form-control" rows="2" required>{{ old('domicilio', $expediente->domicilio) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="ocupacion" class="form-label">Ocupación</label>
                                <input type="text" name="ocupacion" id="ocupacion" class="form-control" value="{{ old('ocupacion', $expediente->ocupacion) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentesco_1" class="form-label">Parentesco 1</label>
                                <input type="text" name="parentesco_1" id="parentesco_1" class="form-control" value="{{ old('parentesco_1', $expediente->parentesco_1) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="parentesco_2" class="form-label">Parentesco 2</label>
                                <input type="text" name="parentesco_2" id="parentesco_2" class="form-control" value="{{ old('parentesco_2', $expediente->parentesco_2) }}">
                            </div>
                        </div>

                        <!-- Sección de Antecedentes -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-history"></i> Antecedentes
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="antecedentes_heredo_familiares" class="form-label">Antecedentes Heredo-Familiares</label>
                                <textarea name="antecedentes_heredo_familiares" id="antecedentes_heredo_familiares" 
                                          class="form-control" rows="3">{{ old('antecedentes_heredo_familiares', $expediente->antecedentes_heredo_familiares) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="antecedentes_personales_no_patologicos" class="form-label">Antecedentes Personales No Patológicos</label>
                                <textarea name="antecedentes_personales_no_patologicos" id="antecedentes_personales_no_patologicos" 
                                          class="form-control" rows="3">{{ old('antecedentes_personales_no_patologicos', $expediente->antecedentes_personales_no_patologicos) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="antecedentes_perinatales" class="form-label">Antecedentes Perinatales</label>
                                <textarea name="antecedentes_perinatales" id="antecedentes_perinatales" 
                                          class="form-control" rows="3">{{ old('antecedentes_perinatales', $expediente->antecedentes_perinatales) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="alimentacion" class="form-label">Alimentación</label>
                                <textarea name="alimentacion" id="alimentacion" class="form-control" rows="3">{{ old('alimentacion', $expediente->alimentacion) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="inmunizaciones" class="form-label">Inmunizaciones</label>
                                <textarea name="inmunizaciones" id="inmunizaciones" class="form-control" rows="3">{{ old('inmunizaciones', $expediente->inmunizaciones) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="desarrollo_psicomotor" class="form-label">Desarrollo Psicomotor</label>
                                <textarea name="desarrollo_psicomotor" id="desarrollo_psicomotor" 
                                          class="form-control" rows="3">{{ old('desarrollo_psicomotor', $expediente->desarrollo_psicomotor) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="antecedentes_personales_patologicos" class="form-label">Antecedentes Personales Patológicos</label>
                                <textarea name="antecedentes_personales_patologicos" id="antecedentes_personales_patologicos" 
                                          class="form-control" rows="3">{{ old('antecedentes_personales_patologicos', $expediente->antecedentes_personales_patologicos) }}</textarea>
                            </div>
                        </div>

                        <!-- Sección de Padecimiento Actual -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-stethoscope"></i> Padecimiento Actual
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="padecimiento_actual" class="form-label">Padecimiento Actual *</label>
                                <textarea name="padecimiento_actual" id="padecimiento_actual" 
                                          class="form-control" rows="4" required>{{ old('padecimiento_actual', $expediente->padecimiento_actual) }}</textarea>
                            </div>
                        </div>

                        <!-- Sección de Interrogatorio por Sistemas -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-clipboard-list"></i> Interrogatorio por Sistemas
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_cardiovascular" class="form-label">Cardiovascular</label>
                                <textarea name="interrogatorio_cardiovascular" id="interrogatorio_cardiovascular" 
                                          class="form-control" rows="3">{{ old('interrogatorio_cardiovascular', $expediente->interrogatorio_cardiovascular) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_respiratorio" class="form-label">Respiratorio</label>
                                <textarea name="interrogatorio_respiratorio" id="interrogatorio_respiratorio" 
                                          class="form-control" rows="3">{{ old('interrogatorio_respiratorio', $expediente->interrogatorio_respiratorio) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_gastrointestinal" class="form-label">Gastrointestinal</label>
                                <textarea name="interrogatorio_gastrointestinal" id="interrogatorio_gastrointestinal" 
                                          class="form-control" rows="3">{{ old('interrogatorio_gastrointestinal', $expediente->interrogatorio_gastrointestinal) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_genitourinario" class="form-label">Genitourinario</label>
                                <textarea name="interrogatorio_genitourinario" id="interrogatorio_genitourinario" 
                                          class="form-control" rows="3">{{ old('interrogatorio_genitourinario', $expediente->interrogatorio_genitourinario) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_hematolinfatico" class="form-label">Hematolinfático</label>
                                <textarea name="interrogatorio_hematolinfatico" id="interrogatorio_hematolinfatico" 
                                          class="form-control" rows="3">{{ old('interrogatorio_hematolinfatico', $expediente->interrogatorio_hematolinfatico) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_nervioso" class="form-label">Nervioso</label>
                                <textarea name="interrogatorio_nervioso" id="interrogatorio_nervioso" 
                                          class="form-control" rows="3">{{ old('interrogatorio_nervioso', $expediente->interrogatorio_nervioso) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_musculo_esqueletico" class="form-label">Musculoesquelético</label>
                                <textarea name="interrogatorio_musculo_esqueletico" id="interrogatorio_musculo_esqueletico" 
                                          class="form-control" rows="3">{{ old('interrogatorio_musculo_esqueletico', $expediente->interrogatorio_musculo_esqueletico) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_piel_mucosas" class="form-label">Piel y Mucosas</label>
                                <textarea name="interrogatorio_piel_mucosas" id="interrogatorio_piel_mucosas" 
                                          class="form-control" rows="3">{{ old('interrogatorio_piel_mucosas', $expediente->interrogatorio_piel_mucosas) }}</textarea>
                            </div>
                        </div>

                        <!-- Sección de Signos Vitales -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-heartbeat"></i> Signos Vitales
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="signos_ta" class="form-label">T.A.</label>
                                <input type="text" name="signos_ta" id="signos_ta" class="form-control" maxlength="10" value="{{ old('signos_ta', $expediente->signos_ta) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_temp" class="form-label">Temp.</label>
                                <input type="text" name="signos_temp" id="signos_temp" class="form-control" maxlength="10" value="{{ old('signos_temp', $expediente->signos_temp) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_frec_c" class="form-label">F.C.</label>
                                <input type="text" name="signos_frec_c" id="signos_frec_c" class="form-control" maxlength="10" value="{{ old('signos_frec_c', $expediente->signos_frec_c) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_frec_r" class="form-label">F.R.</label>
                                <input type="text" name="signos_frec_r" id="signos_frec_r" class="form-control" maxlength="10" value="{{ old('signos_frec_r', $expediente->signos_frec_r) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_peso" class="form-label">Peso</label>
                                <input type="text" name="signos_peso" id="signos_peso" class="form-control" maxlength="10" value="{{ old('signos_peso', $expediente->signos_peso) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_talla" class="form-label">Talla</label>
                                <input type="text" name="signos_talla" id="signos_talla" class="form-control" maxlength="10" value="{{ old('signos_talla', $expediente->signos_talla) }}">
                            </div>
                        </div>

                        <!-- Sección de Exploración Física -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-user-md"></i> Exploración Física
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_habitus" class="form-label">Habitus Exterior</label>
                                <textarea name="exploracion_habitus" id="exploracion_habitus" 
                                          class="form-control" rows="3">{{ old('exploracion_habitus', $expediente->exploracion_habitus) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_cabeza" class="form-label">Cabeza</label>
                                <textarea name="exploracion_cabeza" id="exploracion_cabeza" 
                                          class="form-control" rows="3">{{ old('exploracion_cabeza', $expediente->exploracion_cabeza) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_cuello" class="form-label">Cuello</label>
                                <textarea name="exploracion_cuello" id="exploracion_cuello" 
                                          class="form-control" rows="3">{{ old('exploracion_cuello', $expediente->exploracion_cuello) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_torax" class="form-label">Tórax</label>
                                <textarea name="exploracion_torax" id="exploracion_torax" 
                                          class="form-control" rows="3">{{ old('exploracion_torax', $expediente->exploracion_torax) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_abdomen" class="form-label">Abdomen</label>
                                <textarea name="exploracion_abdomen" id="exploracion_abdomen" 
                                          class="form-control" rows="3">{{ old('exploracion_abdomen', $expediente->exploracion_abdomen) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_genitales" class="form-label">Genitales</label>
                                <textarea name="exploracion_genitales" id="exploracion_genitales" 
                                          class="form-control" rows="3">{{ old('exploracion_genitales', $expediente->exploracion_genitales) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_extremidades" class="form-label">Extremidades</label>
                                <textarea name="exploracion_extremidades" id="exploracion_extremidades" 
                                          class="form-control" rows="3">{{ old('exploracion_extremidades', $expediente->exploracion_extremidades) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_piel" class="form-label">Piel</label>
                                <textarea name="exploracion_piel" id="exploracion_piel" 
                                          class="form-control" rows="3">{{ old('exploracion_piel', $expediente->exploracion_piel) }}</textarea>
                            </div>
                        </div>

                        <!-- Sección de Resultados y Diagnóstico -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-microscope"></i> Resultados y Diagnóstico
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="resultados_laboratorio" class="form-label">Resultados de Laboratorio</label>
                                <textarea name="resultados_laboratorio" id="resultados_laboratorio" 
                                          class="form-control" rows="4">{{ old('resultados_laboratorio', $expediente->resultados_laboratorio) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="diagnosticos" class="form-label">Diagnósticos *</label>
                                <textarea name="diagnosticos" id="diagnosticos" 
                                          class="form-control" rows="4" required>{{ old('diagnosticos', $expediente->diagnosticos) }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tratamiento" class="form-label">Tratamiento *</label>
                                <textarea name="tratamiento" id="tratamiento" 
                                          class="form-control" rows="4" required>{{ old('tratamiento', $expediente->tratamiento) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="pronostico" class="form-label">Pronóstico</label>
                                <textarea name="pronostico" id="pronostico" 
                                          class="form-control" rows="4">{{ old('pronostico', $expediente->pronostico) }}</textarea>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-2">
                                    <i class="fas fa-save"></i> Actualizar Expediente
                                </button>
                                <a href="{{ route('expedientes.show', $expediente->id) }}" class="btn btn-info btn-lg me-2">
                                    <i class="fas fa-eye"></i> Ver Expediente
                                </a>
                                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 10px;
    }
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    .border-bottom {
        border-color: #dee2e6 !important;
    }
</style>
@endsection 