@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-folder-open"></i> Expedientes de {{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}
                    </h4>
                    <div>
                        <a href="{{ route('expedientes.create') }}?paciente_id={{ $paciente->id }}" class="btn btn-success me-2">
                            <i class="fas fa-plus-circle"></i> Nuevo Expediente
                        </a>
                        <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Información del paciente -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary">Información del Paciente</h5>
                            <p><strong>Nombre:</strong> {{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}</p>
                            <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
                            <p><strong>ID:</strong> {{ $paciente->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary">Resumen</h5>
                            <p><strong>Total de Expedientes:</strong> {{ $expedientes->count() }}</p>
                            <p><strong>Último Expediente:</strong> 
                                @if($expedientes->count() > 0)
                                    {{ $expedientes->first()->fecha_elaboracion ? \Carbon\Carbon::parse($expedientes->first()->fecha_elaboracion)->format('d/m/Y') : 'N/A' }}
                                @else
                                    No hay expedientes
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($expedientes->count() > 0)
                        <!-- Tabla de expedientes -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha Elaboración</th>
                                        <th>Hora</th>
                                        <th>Tipo Interrogatorio</th>
                                        <th>Diagnóstico</th>
                                        <th>Tratamiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expedientes as $expediente)
                                        <tr>
                                            <td data-label="ID">{{ $expediente->id }}</td>
                                            <td data-label="Fecha Elaboración">{{ $expediente->fecha_elaboracion ? \Carbon\Carbon::parse($expediente->fecha_elaboracion)->format('d/m/Y') : 'N/A' }}</td>
                                            <td data-label="Hora">{{ $expediente->hora_elaboracion ? \Carbon\Carbon::parse($expediente->hora_elaboracion)->format('H:i') : 'N/A' }}</td>
                                            <td data-label="Tipo Interrogatorio">{{ Str::limit($expediente->tipo_interrogatorio, 30) }}</td>
                                            <td data-label="Diagnóstico">{{ Str::limit($expediente->diagnosticos, 50) }}</td>
                                            <td data-label="Tratamiento">{{ Str::limit($expediente->tratamiento, 50) }}</td>
                                            <td data-label="Acciones">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('expedientes.show', $expediente->id) }}" 
                                                       class="btn btn-sm btn-info" title="Ver">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                    <a href="{{ route('expedientes.pdf', $expediente->id) }}" 
                                                       class="btn btn-sm btn-success" title="Generar PDF" target="_blank">
                                                        <i class="fas fa-file-pdf"></i> PDF
                                                    </a>
                                                    <a href="{{ route('expedientes.edit', $expediente->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Editar">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>
                                                    <form action="{{ route('expedientes.destroy', $expediente->id) }}" 
                                                          method="POST" class="d-inline" 
                                                          onsubmit="return confirm('¿Está seguro de que desea eliminar este expediente?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle"></i>
                            Este paciente no tiene expedientes clínicos registrados.
                            <br>
                            <a href="{{ route('expedientes.create') }}?paciente_id={{ $paciente->id }}" class="btn btn-success mt-2">
                                <i class="fas fa-plus-circle"></i> Crear Primer Expediente
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
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

    .btn-group .btn {
        margin-right: 2px;
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }

    .table th {
        white-space: nowrap;
    }

    .text-primary {
        color: #667eea !important;
    }

    .btn i {
        margin-right: 3px;
    }

    /* Estilos solo para vista móvil */
   @media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }

    thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }

    tr {
        border: 1px solid #ccc;
        margin-bottom: 10px;
        padding: 10px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 60%;
        padding-right: 10px;
        text-align: right;
        font-size: 14px;
        word-break: break-word;
        white-space: normal;
    }

    td::before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 40%;
        padding-right: 10px;
        white-space: nowrap;
        content: attr(data-label);
        font-weight: bold;
        text-align: left;
        color: white;
        background-color: #212529;
        padding: 4px 6px;
        border-radius: 5px;
        font-size: 12px;
    }

    td[data-label="Tipo Interrogatorio"],
    td[data-label="Diagnóstico"],
    td[data-label="Tratamiento"] {
        padding-left: 60%;
        padding-right: 10px;
        text-align: left;
        font-size: 14px;
        word-break: break-word;
        white-space: normal;
    }

    td[data-label="Acciones"] {
        padding-left: 10px;
        padding-right: 10px;
        text-align: center;
    }

    td[data-label="Acciones"]::before {
        position: relative;
        display: block;
        margin-bottom: 10px;
        text-align: center;
        font-weight: bold;
        color: #fff;
        background-color: #212529;
        padding: 6px;
        border-radius: 8px;
        font-size: 13px;
        width: 240px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    td[data-label="Acciones"] .btn-group {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    td[data-label="Acciones"] .btn-group .btn {
        width: 100%;
        margin-bottom: 6px;
        font-size: 13px;
    }

    td[data-label="Acciones"] .btn-group .btn:last-child {
        margin-bottom: 0;
    }
}

</style>
@endpush

@endsection
