@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</span>
                    <a href="{{ route('paciente.calendario-citas') }}" class="btn btn-primary btn-sm">Agendar Nueva Cita</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h5 class="mb-4">Mis Citas Programadas</h5>
                    
                    @if($citas->isEmpty())
                        <div class="alert alert-info">No tienes citas programadas.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Consultorio</th>
                                        <th>Motivo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $cita)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</td>
                                            <td>{{ $cita->consultorio->nombre }}</td>
                                            <td>{{ $cita->motivo }}</td>
                                            <td>
                                                @if($cita->estado == 'pendiente')
                                                    <span class="badge bg-warning">Pendiente</span>
                                                @elseif($cita->estado == 'confirmada')
                                                    <span class="badge bg-success">Confirmada</span>
                                                @elseif($cita->estado == 'cancelada')
                                                    <span class="badge bg-danger">Cancelada</span>
                                                @else
                                                    <span class="badge bg-secondary">Realizada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($cita->estado == 'pendiente')
                                                    <form action="{{ route('paciente.cancelar-cita', $cita->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection