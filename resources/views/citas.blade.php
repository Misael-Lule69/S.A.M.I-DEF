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
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
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
                                        <td data-label="Fecha">{{ $cita->fecha->format('d/m/Y') }}</td>
                                        <td data-label="Hora">{{ $cita->hora->format('H:i') }}</td>
                                        <td data-label="Paciente">{{ $cita->paciente->nombre }} {{ $cita->paciente->apellido_paterno }}</td>
                                        <td data-label="Teléfono">{{ $cita->paciente->telefono }}</td>
                                        <td data-label="Consultorio">{{ $cita->consultorio->nombre }}</td>
                                        <td data-label="Motivo">{{ $cita->motivo }}</td>
                                        <td data-label="Acciones">
    <div class="acciones-movil">
        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                data-bs-target="#cancelarModal{{ $cita->id }}">
            Cancelar
        </button>
    </div>
</td>


                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="cancelarModal{{ $cita->id }}" tabindex="-1" aria-labelledby="cancelarModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Cancelar Cita</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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

{{-- ESTILOS RESPONSIVOS --}}
<style>
/* --- Estilos generales --- */
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

.table th {
    white-space: nowrap;
}

/* --- Estilo solo para vista móvil --- */
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
        margin-bottom: 15px;
        padding: 10px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 45%;
        padding-right: 10px;
        text-align: right;
        font-size: 14px;
        word-break: break-word;
    }

    td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        top: 10px;
        background: #212529;
        color: white;
        font-weight: bold;
        padding: 4px 6px;
        border-radius: 5px;
        font-size: 12px;
        width: 40%;
        white-space: nowrap;
    }
    td[data-label="Fecha"],
    td[data-label="Hora"],
    td[data-label="Paciente"],
    td[data-label="Consultorio"],
    td[data-label="Motivo"],
    td[data-label="Teléfono"] {
        text-align: right;
        font-size: 14px;
        padding-left: 45%;
    }

    td[data-label="Acciones"] {
        text-align: center;
        padding: 30px 10px 15px 10px;
        height: auto;
        
    }

    .acciones-movil {
        margin-top: 12px;
        display: flex;
        justify-content: center;
        background-color: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        width: 107px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .acciones-movil .btn {
       font-size: 14px;
        padding: 6px 12px;
        width: 100%;
        max-width: 240px;
    }
}
</style>

@endsection
