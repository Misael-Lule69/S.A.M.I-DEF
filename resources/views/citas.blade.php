@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Citas Pendientes</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Teléfono</th>
                                    <th>Consultorio</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citas as $cita)
                                    <tr>
                                        <td>{{ $cita->fecha->format('d/m/Y') }}</td>
                                        <td>{{ $cita->hora->format('H:i') }}</td>
                                        <td>{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_paterno }}</td>
                                        <td>{{ $cita->paciente->telefono }}</td>
                                        <td>{{ $cita->consultorio->nombre }}</td>
                                        <td>{{ $cita->motivo }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                                                    data-bs-target="#cancelarModal{{ $cita->id }}">
                                                Cancelar
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal de cancelación -->
                                    <div class="modal fade" id="cancelarModal{{ $cita->id }}" tabindex="-1" aria-labelledby="cancelarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cancelarModalLabel">Cancelar Cita</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('citas.cancelar', $cita->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de cancelar la cita de <strong>{{ $cita->paciente->nombre }}</strong> 
                                                        para el {{ $cita->fecha->format('d/m/Y') }} a las {{ $cita->hora->format('H:i') }}?</p>
                                                        
                                                        <div class="mb-3">
                                                            <label for="motivo_cancelacion" class="form-label">Motivo de cancelación (opcional)</label>
                                                            <textarea class="form-control" id="motivo_cancelacion" name="motivo_cancelacion" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-danger">Confirmar Cancelación</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay citas pendientes</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection