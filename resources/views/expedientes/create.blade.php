@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0 rounded-4 mt-4 mb-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h4 class="mb-0"><i class="fas fa-file-medical"></i> Crear Nuevo Expediente Clínico</h4>
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

                    <form method="POST" action="{{ route('expedientes.store') }}" id="expedienteForm">
                        @csrf
                        
                        <!-- Eliminado campo de cita, solo se muestran los datos del paciente y expediente -->
                        <!-- Sección de Identificación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2">
                                    <i class="fas fa-user"></i> Identificación del Paciente
                                </h5>
                            </div>
                        </div>

                        @if(isset($paciente))
                            <input type="hidden" name="id_paciente" value="{{ $paciente->id }}">
                            <div class="mb-3">
                                <label class="form-label">Paciente</label>
                                <input type="text" class="form-control" value="{{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}" disabled>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="id_paciente" class="form-label">Paciente</label>
                                <select name="id_paciente" id="id_paciente" class="form-select" required>
                                    <option value="">Seleccione un paciente</option>
                                    @foreach(App\Models\Paciente::orderBy('nombre')->get() as $p)
                                        <option value="{{ $p->id }}" {{ old('id_paciente') == $p->id ? 'selected' : '' }}>{{ $p->nombre }} {{ $p->apellido_paterno }} {{ $p->apellido_materno }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre_paciente" class="form-label">Nombre Completo del Paciente *</label>
                                <input type="text" name="nombre_paciente" id="nombre_paciente" 
                                       class="form-control" required 
                                       value="{{ $paciente ? $paciente->nombre . ' ' . $paciente->apellido_paterno . ' ' . $paciente->apellido_materno : '' }}"
                                       {{ $paciente ? 'readonly' : '' }}>
                            </div>
                            <div class="col-md-3">
                                <label for="edad" class="form-label">Edad *</label>
                                <input type="number" name="edad" id="edad" class="form-control" 
                                       min="0" max="150" required>
                            </div>
                            <div class="col-md-3">
                                <label for="genero" class="form-label">Género *</label>
                                <select name="genero" id="genero" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="domicilio" class="form-label">Domicilio *</label>
                                <textarea name="domicilio" id="domicilio" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="ocupacion" class="form-label">Ocupación</label>
                                <input type="text" name="ocupacion" id="ocupacion" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="parentesco_1" class="form-label">Parentesco 1</label>
                                <input type="text" name="parentesco_1" id="parentesco_1" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="parentesco_2" class="form-label">Parentesco 2</label>
                                <input type="text" name="parentesco_2" id="parentesco_2" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="tipo_interrogatorio" class="form-label">Tipo de Interrogatorio *</label>
                                <input type="text" name="tipo_interrogatorio" id="tipo_interrogatorio" 
                                       class="form-control" required>
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
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="antecedentes_personales_no_patologicos" class="form-label">Antecedentes Personales No Patológicos</label>
                                <textarea name="antecedentes_personales_no_patologicos" id="antecedentes_personales_no_patologicos" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fecha_atencion" class="form-label">Fecha de Atención *</label>
                                <input type="date" name="fecha_atencion" id="fecha_atencion" class="form-control" required value="{{ old('fecha_atencion', date('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="antecedentes_perinatales" class="form-label">Antecedentes Perinatales</label>
                                <textarea name="antecedentes_perinatales" id="antecedentes_perinatales" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="alimentacion" class="form-label">Alimentación</label>
                                <textarea name="alimentacion" id="alimentacion" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="inmunizaciones" class="form-label">Inmunizaciones</label>
                                <textarea name="inmunizaciones" id="inmunizaciones" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="desarrollo_psicomotor" class="form-label">Desarrollo Psicomotor</label>
                                <textarea name="desarrollo_psicomotor" id="desarrollo_psicomotor" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="antecedentes_personales_patologicos" class="form-label">Antecedentes Personales Patológicos</label>
                                <textarea name="antecedentes_personales_patologicos" id="antecedentes_personales_patologicos" 
                                          class="form-control" rows="3"></textarea>
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
                                <textarea name="padecimiento_actual" id="padecimiento_actual" 
                                          class="form-control" rows="4" required></textarea>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarPadecimiento()">
                                        <i class="fas fa-plus"></i> Agregar Otro Padecimiento
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="numero_visita" class="form-label">Número de Visita</label>
                                @if(isset($paciente))
                                    @php
                                        // Contar padecimientos anteriores del mismo paciente
                                        $padecimientosAnteriores = \App\Models\ExpedienteClinico::where('id_paciente', $paciente->id)
                                            ->whereNotNull('padecimiento_actual')
                                            ->where('padecimiento_actual', '!=', '')
                                            ->count();
                                        $numeroVisita = $padecimientosAnteriores + 1;
                                    @endphp
                                    <input type="number" name="numero_visita" id="numero_visita" 
                                           class="form-control" min="1" value="{{ $numeroVisita }}" readonly>
                                @else
                                    <input type="number" name="numero_visita" id="numero_visita" 
                                           class="form-control" min="1" value="1" readonly>
                                @endif
                                <small class="text-muted">Basado en padecimientos agregados</small>
                            </div>
                        </div>

                        <!-- Campos adicionales de padecimiento (se agregan dinámicamente) -->
                        <div id="padecimientos-adicionales">
                            <!-- Aquí se agregarán campos adicionales dinámicamente -->
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
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_respiratorio" class="form-label">Respiratorio</label>
                                <textarea name="interrogatorio_respiratorio" id="interrogatorio_respiratorio" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_gastrointestinal" class="form-label">Gastrointestinal</label>
                                <textarea name="interrogatorio_gastrointestinal" id="interrogatorio_gastrointestinal" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_genitourinario" class="form-label">Genitourinario</label>
                                <textarea name="interrogatorio_genitourinario" id="interrogatorio_genitourinario" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_hematolinfatico" class="form-label">Hematolinfático</label>
                                <textarea name="interrogatorio_hematolinfatico" id="interrogatorio_hematolinfatico" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_nervioso" class="form-label">Nervioso</label>
                                <textarea name="interrogatorio_nervioso" id="interrogatorio_nervioso" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="interrogatorio_musculo_esqueletico" class="form-label">Musculoesquelético</label>
                                <textarea name="interrogatorio_musculo_esqueletico" id="interrogatorio_musculo_esqueletico" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="interrogatorio_piel_mucosas" class="form-label">Piel y Mucosas</label>
                                <textarea name="interrogatorio_piel_mucosas" id="interrogatorio_piel_mucosas" 
                                          class="form-control" rows="3"></textarea>
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
                                <input type="text" name="signos_ta" id="signos_ta" class="form-control" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_temp" class="form-label">Temp.</label>
                                <input type="text" name="signos_temp" id="signos_temp" class="form-control" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_frec_c" class="form-label">F.C.</label>
                                <input type="text" name="signos_frec_c" id="signos_frec_c" class="form-control" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_frec_r" class="form-label">F.R.</label>
                                <input type="text" name="signos_frec_r" id="signos_frec_r" class="form-control" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_peso" class="form-label">Peso</label>
                                <input type="text" name="signos_peso" id="signos_peso" class="form-control" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="signos_talla" class="form-label">Talla</label>
                                <input type="text" name="signos_talla" id="signos_talla" class="form-control" maxlength="10">
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
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_cabeza" class="form-label">Cabeza</label>
                                <textarea name="exploracion_cabeza" id="exploracion_cabeza" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_cuello" class="form-label">Cuello</label>
                                <textarea name="exploracion_cuello" id="exploracion_cuello" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_torax" class="form-label">Tórax</label>
                                <textarea name="exploracion_torax" id="exploracion_torax" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_abdomen" class="form-label">Abdomen</label>
                                <textarea name="exploracion_abdomen" id="exploracion_abdomen" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_genitales" class="form-label">Genitales</label>
                                <textarea name="exploracion_genitales" id="exploracion_genitales" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="exploracion_extremidades" class="form-label">Extremidades</label>
                                <textarea name="exploracion_extremidades" id="exploracion_extremidades" 
                                          class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exploracion_piel" class="form-label">Piel</label>
                                <textarea name="exploracion_piel" id="exploracion_piel" 
                                          class="form-control" rows="3"></textarea>
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
                                          class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="estudios_gabinete" class="form-label">Estudios de Gabinete</label>
                                <textarea name="estudios_gabinete" id="estudios_gabinete" 
                                          class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="diagnosticos" class="form-label">Diagnósticos *</label>
                                <textarea name="diagnosticos" id="diagnosticos" 
                                          class="form-control" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tratamiento" class="form-label">Tratamiento *</label>
                                <textarea name="tratamiento" id="tratamiento" 
                                          class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="pronostico" class="form-label">Pronóstico</label>
                                <textarea name="pronostico" id="pronostico" 
                                          class="form-control" rows="4"></textarea>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg me-2">
                                    <i class="fas fa-save"></i> Guardar Expediente
                                </button>
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
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }
</style>

<script>
let contadorPadecimientos = 0;

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