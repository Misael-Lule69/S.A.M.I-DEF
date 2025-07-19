@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-file-medical"></i> Expediente Clínico #{{ $expediente->id }}
                    </h4>
                    <div>
                        <a href="{{ route('expedientes.edit', $expediente->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-user"></i> Información del Paciente
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nombre del Paciente:</strong>
                            <p class="text-muted">{{ $expediente->nombre_paciente }}</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Edad:</strong>
                            <p class="text-muted">{{ $expediente->edad }} años</p>
                        </div>
                        <div class="col-md-3">
                            <strong>Género:</strong>
                            <p class="text-muted">{{ $expediente->genero }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Domicilio:</strong>
                            <p class="text-muted">{{ $expediente->domicilio }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Ocupación:</strong>
                            <p class="text-muted">{{ $expediente->ocupacion ?: 'No especificada' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Parentesco 1:</strong>
                            <p class="text-muted">{{ $expediente->parentesco_1 ?: 'No especificado' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Parentesco 2:</strong>
                            <p class="text-muted">{{ $expediente->parentesco_2 ?: 'No especificado' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tipo de Interrogatorio:</strong>
                            <p class="text-muted">{{ $expediente->tipo_interrogatorio }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Elaboración:</strong>
                            <p class="text-muted">
                                {{ $expediente->fecha_elaboracion ? \Carbon\Carbon::parse($expediente->fecha_elaboracion)->format('d/m/Y') : 'No especificada' }}
                                @if($expediente->hora_elaboracion)
                                    - {{ \Carbon\Carbon::parse($expediente->hora_elaboracion)->format('H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Antecedentes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-history"></i> Antecedentes
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Antecedentes Heredo-Familiares:</strong>
                            <p class="text-muted">{{ $expediente->antecedentes_heredo_familiares ?: 'No especificados' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Antecedentes Personales No Patológicos:</strong>
                            <p class="text-muted">{{ $expediente->antecedentes_personales_no_patologicos ?: 'No especificados' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Antecedentes Perinatales:</strong>
                            <p class="text-muted">{{ $expediente->antecedentes_perinatales ?: 'No especificados' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Alimentación:</strong>
                            <p class="text-muted">{{ $expediente->alimentacion ?: 'No especificada' }}</p>
                        </div>
                        <div class="col-md-4">
                            <strong>Inmunizaciones:</strong>
                            <p class="text-muted">{{ $expediente->inmunizaciones ?: 'No especificadas' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Desarrollo Psicomotor:</strong>
                            <p class="text-muted">{{ $expediente->desarrollo_psicomotor ?: 'No especificado' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Antecedentes Personales Patológicos:</strong>
                            <p class="text-muted">{{ $expediente->antecedentes_personales_patologicos ?: 'No especificados' }}</p>
                        </div>
                    </div>

                    <!-- Padecimiento Actual -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-stethoscope"></i> Padecimiento Actual
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Padecimiento Actual:</strong>
                            <p class="text-muted">{{ $expediente->padecimiento_actual }}</p>
                        </div>
                    </div>

                    @if($expediente->padecimientos_adicionales && count($expediente->padecimientos_adicionales) > 0)
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Padecimientos Adicionales:</strong>
                                @foreach($expediente->padecimientos_adicionales as $padecimiento)
                                    <div class="card mt-2 mb-2">
                                        <div class="card-body">
                                            <h6 class="card-title text-primary">Padecimiento Adicional #{{ $padecimiento['numero'] }}</h6>
                                            <p class="card-text">{{ $padecimiento['descripcion'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Interrogatorio por Sistemas -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-clipboard-list"></i> Interrogatorio por Sistemas
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Cardiovascular:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_cardiovascular ?: 'Sin alteraciones' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Respiratorio:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_respiratorio ?: 'Sin alteraciones' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Gastrointestinal:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_gastrointestinal ?: 'Sin alteraciones' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Genitourinario:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_genitourinario ?: 'Sin alteraciones' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Hematolinfático:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_hematolinfatico ?: 'Sin alteraciones' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Nervioso:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_nervioso ?: 'Sin alteraciones' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Musculoesquelético:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_musculo_esqueletico ?: 'Sin alteraciones' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Piel y Mucosas:</strong>
                            <p class="text-muted">{{ $expediente->interrogatorio_piel_mucosas ?: 'Sin alteraciones' }}</p>
                        </div>
                    </div>

                    <!-- Signos Vitales -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-heartbeat"></i> Signos Vitales
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <strong>T.A.:</strong>
                            <p class="text-muted">{{ $expediente->signos_ta ?: 'No registrado' }}</p>
                        </div>
                        <div class="col-md-2">
                            <strong>Temp.:</strong>
                            <p class="text-muted">{{ $expediente->signos_temp ?: 'No registrado' }}</p>
                        </div>
                        <div class="col-md-2">
                            <strong>F.C.:</strong>
                            <p class="text-muted">{{ $expediente->signos_frec_c ?: 'No registrado' }}</p>
                        </div>
                        <div class="col-md-2">
                            <strong>F.R.:</strong>
                            <p class="text-muted">{{ $expediente->signos_frec_r ?: 'No registrado' }}</p>
                        </div>
                        <div class="col-md-2">
                            <strong>Peso:</strong>
                            <p class="text-muted">{{ $expediente->signos_peso ?: 'No registrado' }}</p>
                        </div>
                        <div class="col-md-2">
                            <strong>Talla:</strong>
                            <p class="text-muted">{{ $expediente->signos_talla ?: 'No registrado' }}</p>
                        </div>
                    </div>

                    <!-- Exploración Física -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-user-md"></i> Exploración Física
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Habitus Exterior:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_habitus ?: 'Normal' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Cabeza:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_cabeza ?: 'Normal' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Cuello:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_cuello ?: 'Normal' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tórax:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_torax ?: 'Normal' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Abdomen:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_abdomen ?: 'Normal' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Genitales:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_genitales ?: 'Normal' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Extremidades:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_extremidades ?: 'Normal' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Piel:</strong>
                            <p class="text-muted">{{ $expediente->exploracion_piel ?: 'Normal' }}</p>
                        </div>
                    </div>

                    <!-- Resultados y Diagnóstico -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-microscope"></i> Resultados y Diagnóstico
                            </h5>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Resultados de Laboratorio:</strong>
                            <p class="text-muted">{{ $expediente->resultados_laboratorio ?: 'No especificados' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Diagnósticos:</strong>
                            <p class="text-muted">{{ $expediente->diagnosticos }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tratamiento:</strong>
                            <p class="text-muted">{{ $expediente->tratamiento }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Pronóstico:</strong>
                            <p class="text-muted">{{ $expediente->pronostico ?: 'No especificado' }}</p>
                        </div>
                    </div>
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
    .text-primary {
        color: #667eea !important;
    }
    .border-bottom {
        border-color: #dee2e6 !important;
    }
    strong {
        color: #495057;
        font-weight: 600;
    }
    .text-muted {
        color: #6c757d !important;
        margin-bottom: 0.5rem;
    }
</style>
@endsection 