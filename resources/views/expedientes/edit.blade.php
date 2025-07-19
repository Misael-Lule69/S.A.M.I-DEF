@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0 rounded-4 mt-4 mb-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0"><i class="fas fa-file-medical"></i> Editar Expediente Clínico #{{ $expediente->id }}</h4>
                </div>
                <div class="card-body p-4">
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
                        
                        <div class="mb-3">
                            <label class="form-label">Paciente</label>
                            <input type="text" class="form-control" value="{{ $expediente->paciente ? $expediente->paciente->nombre : '' }}" readonly>
                            <input type="hidden" name="id_paciente" value="{{ $expediente->id_paciente }}">
                        </div>

                        <!-- Sección de Identificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-user"></i> Identificación del Paciente
                                </h5>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Eliminado campo de cita -->
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
                                <label for="fecha_atencion" class="form-label">Fecha de Atención *</label>
                                <input type="date" name="fecha_atencion" id="fecha_atencion" class="form-control" required value="{{ old('fecha_atencion', $expediente->fecha_atencion ?? $expediente->fecha_elaboracion ?? date('Y-m-d')) }}">
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
                            <div class="col-md-8">
                                <label for="padecimiento_actual" class="form-label">Padecimiento Actual *</label>
                                <div class="input-group mb-2">
                                    <textarea name="padecimiento_actual" id="padecimiento_actual" 
                                              class="form-control" rows="4" required>{{ old('padecimiento_actual', $expediente->padecimiento_actual) }}</textarea>
                                    <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('padecimiento_actual').value = ''">Limpiar</button>
                                </div>
                                <small class="text-muted">Puedes limpiar y volver a llenar este campo para cada consulta subsecuente.</small>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarPadecimiento()">
                                        <i class="fas fa-plus"></i> Agregar Otro Padecimiento
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="numero_visita" class="form-label">Número de Visita</label>
                                @php
                                    // Contar cuántas veces se ha agregado padecimiento actual (basado en el historial)
                                    $padecimientosAnteriores = \App\Models\ExpedienteClinico::where('id_paciente', $expediente->id_paciente)
                                        ->where('id', '<=', $expediente->id)
                                        ->whereNotNull('padecimiento_actual')
                                        ->where('padecimiento_actual', '!=', '')
                                        ->count();
                                    $numeroVisita = $padecimientosAnteriores;
                                @endphp
                                <input type="number" name="numero_visita" id="numero_visita" 
                                       class="form-control" min="1" value="{{ old('numero_visita', $numeroVisita) }}" readonly>
                                <small class="text-muted">Basado en padecimientos agregados</small>
                            </div>
                        </div>

                        <!-- Campos adicionales de padecimiento (se agregan dinámicamente) -->
                        <div id="padecimientos-adicionales">
                            <!-- Aquí se agregarán campos adicionales dinámicamente -->
                            @if($expediente->padecimientos_adicionales && count($expediente->padecimientos_adicionales) > 0)
                                @foreach($expediente->padecimientos_adicionales as $index => $padecimiento)
                                    <div class="row mb-3 padecimiento-adicional">
                                        <div class="col-md-8">
                                            <label class="form-label">Padecimiento Adicional {{ $index + 1 }}</label>
                                            <div class="input-group">
                                                <textarea name="padecimiento_adicional_{{ $index + 1 }}" 
                                                          class="form-control padecimiento-adicional-text" rows="3" placeholder="Describa el padecimiento adicional...">{{ $padecimiento['descripcion'] }}</textarea>
                                                <button type="button" class="btn btn-outline-danger" onclick="eliminarPadecimiento(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Número de Visita</label>
                                            <input type="number" class="form-control" value="{{ $index + 2 }}" readonly>
                                            <small class="text-muted">Visita adicional</small>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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
                                <label for="estudios_gabinete" class="form-label">Estudios de Gabinete</label>
                                <textarea name="estudios_gabinete" id="estudios_gabinete" 
                                          class="form-control" rows="4">{{ old('estudios_gabinete', $expediente->estudios_gabinete ?? '') }}</textarea>
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
                            <div class="col-12 text-center btn-group-mobile">
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
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.10), 0 1.5px 4px rgba(118, 75, 162, 0.08);
        border: none;
        border-radius: 1.5rem;
    }
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: #fff !important;
        border-radius: 1.5rem 1.5rem 0 0 !important;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
    }
    .form-label {
        font-weight: 600;
        color: #4B3869;
        letter-spacing: 0.5px;
    }
    .form-control, .form-select, textarea {
        border-radius: 0.75rem;
        border: 1.5px solid #d1d5db;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus, .form-select:focus, textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.15);
    }
    .input-group .btn {
        border-radius: 0.75rem;
    }
    .section-title {
        font-size: 1.15rem;
        color: #764ba2;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }
    .border-bottom {
        border-color: #dee2e6 !important;
    }
    .btn-primary, .btn-info, .btn-success, .btn-warning, .btn-danger {
        border-radius: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .btn-lg {
        padding: 0.7rem 2.2rem;
        font-size: 1.1rem;
    }
    @media (max-width: 991.98px) {
        .card {
            border-radius: 1rem;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }
    }
    @media (max-width: 767.98px) {
        .card {
            border-radius: 0.5rem;
        }
        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        .btn-group-mobile > * {
            display: block;
            margin-bottom: 12px;
            width: 100%;
        }
        .btn-group-mobile > *:last-child {
            margin-bottom: 0;
        }
    }
    .input-group.mb-2 > textarea.form-control {
        min-height: 90px;
    }
    .row.mb-3, .row.mb-4 {
        margin-bottom: 1.5rem !important;
    }
    .alert {
        border-radius: 0.75rem;
    }
</style>

<script>
let contadorPadecimientos = {{ $expediente->padecimientos_adicionales ? count($expediente->padecimientos_adicionales) : 0 }};

function agregarPadecimiento() {
    contadorPadecimientos++;
    const container = document.getElementById('padecimientos-adicionales');
    
    const nuevoPadecimiento = document.createElement('div');
    nuevoPadecimiento.className = 'row mb-3 padecimiento-adicional';
    nuevoPadecimiento.innerHTML = `
        <div class="col-md-8">
            <label class="form-label">Padecimiento Adicional ${contadorPadecimientos}</label>
            <div class="input-group">
                <textarea name="padecimiento_adicional_${contadorPadecimientos}" 
                          class="form-control padecimiento-adicional-text" rows="3" placeholder="Describa el padecimiento adicional..."></textarea>
                <button type="button" class="btn btn-outline-danger" onclick="eliminarPadecimiento(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Número de Visita</label>
            <input type="number" class="form-control" value="${contadorPadecimientos + 1}" readonly>
            <small class="text-muted">Visita adicional</small>
        </div>
    `;
    
    container.appendChild(nuevoPadecimiento);
    actualizarNumeroVisita();
    actualizarPadecimientosOcultos();
}

function eliminarPadecimiento(button) {
    const padecimientoDiv = button.closest('.padecimiento-adicional');
    padecimientoDiv.remove();
    actualizarNumeroVisita();
    actualizarPadecimientosOcultos();
}

function actualizarNumeroVisita() {
    const padecimientosAdicionales = document.querySelectorAll('.padecimiento-adicional').length;
    const numeroVisita = document.getElementById('numero_visita');
    const padecimientoActual = document.getElementById('padecimiento_actual').value;
    
    // Si hay padecimiento actual, cuenta como 1, más los adicionales
    let total = padecimientosAdicionales;
    if (padecimientoActual && padecimientoActual.trim() !== '') {
        total += 1;
    }
    
    numeroVisita.value = total;
}

function actualizarPadecimientosOcultos() {
    // Eliminar campo oculto anterior si existe
    let campoOculto = document.getElementById('padecimientos_adicionales_json');
    if (campoOculto) {
        campoOculto.remove();
    }
    
    // Recolectar todos los padecimientos adicionales
    const padecimientosAdicionales = [];
    document.querySelectorAll('.padecimiento-adicional-text').forEach((textarea, index) => {
        if (textarea.value.trim() !== '') {
            padecimientosAdicionales.push({
                numero: index + 1,
                descripcion: textarea.value.trim()
            });
        }
    });
    
    // Crear campo oculto con los datos
    if (padecimientosAdicionales.length > 0) {
        const inputOculto = document.createElement('input');
        inputOculto.type = 'hidden';
        inputOculto.name = 'padecimientos_adicionales_json';
        inputOculto.id = 'padecimientos_adicionales_json';
        inputOculto.value = JSON.stringify(padecimientosAdicionales);
        document.getElementById('expedienteForm').appendChild(inputOculto);
    }
}

// Agregar event listeners para actualizar el campo oculto cuando cambien los valores
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('padecimiento-adicional-text')) {
            actualizarPadecimientosOcultos();
        }
    });
});
</script>
@endsection 