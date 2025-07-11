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
                                            <td>{{ $expediente->id }}</td>
                                            <td>{{ $expediente->fecha_elaboracion ? \Carbon\Carbon::parse($expediente->fecha_elaboracion)->format('d/m/Y') : 'N/A' }}</td>
                                            <td>{{ $expediente->hora_elaboracion ? \Carbon\Carbon::parse($expediente->hora_elaboracion)->format('H:i') : 'N/A' }}</td>
                                            <td>{{ Str::limit($expediente->tipo_interrogatorio, 30) }}</td>
                                            <td>{{ Str::limit($expediente->diagnosticos, 50) }}</td>
                                            <td>{{ Str::limit($expediente->tratamiento, 50) }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('expedientes.show', $expediente->id) }}" 
                                                       class="btn btn-sm btn-info" title="Ver">
                                                        <i class="fas fa-eye"></i> Ver
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
</style>
@endsection 