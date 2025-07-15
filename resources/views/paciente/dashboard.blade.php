@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <span class="mb-2 mb-md-0">Bienvenido, {{ auth()->user()->nombre }} {{ auth()->user()->apellido_paterno }}</span>
                    <a href="{{ route('paciente.calendario-citas') }}" class="btn btn-sm btn-light text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-calendar-plus"></i> Nueva Cita
                    </a>
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
                                <thead class="table-dark">
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
                                            <td data-label="Fecha">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                            <td data-label="Hora">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</td>
                                            <td data-label="Consultorio">{{ $cita->consultorio->nombre }}</td>
                                            <td data-label="Motivo">{{ $cita->motivo }}</td>
                                            <td data-label="Estado">
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
                                            <td data-label="Acciones">
                                                @if($cita->estado == 'pendiente')
                                                    <form action="{{ route('paciente.cancelar-cita', $cita->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Cancelar
                                                        </button>
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
    font-weight: bold;
}
.alert {
    border-radius: 8px;
    font-size: 14px;
}
.table th {
    white-space: nowrap;
}
.table td {
    vertical-align: middle;
    word-break: break-word;
    max-width: 300px;
}

/* Responsividad solo para vista móvil */
@media (max-width: 768px) {
    .card-header {
        text-align: center;
        flex-direction: column !important;
    }

    .card-header a.btn {
        width: 100%;
        margin-top: 10px;
        font-size: 13px;
        padding: 6px 12px;
    }

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
        margin-bottom: 12px;
        padding: 10px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        text-align: right;
        font-size: 14px;
        word-wrap: break-word;
    }

    td::before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 45%;
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

    td[data-label="Consultorio"],
    td[data-label="Motivo"] {
        padding-left: 50%;
        white-space: normal;
        text-align: right;
    }

    td[data-label="Acciones"] {
        text-align: center;
        padding: 12px;
    }

    td[data-label="Acciones"] button {
        width: 100%;
        font-size: 13px;
        margin-top: 6px;
    }
     td[data-label="Acciones"] button.btn-danger {
        font-size: 12px;
        padding: 6px 10px;
        width: 80px;
        margin-top: 30px;
        
    }

    td[data-label="Acciones"] {
        text-align: center;
        padding-left: 10px;
        padding-right: 10px;
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
        margin: auto;
    }

    td[data-label="Acciones"] form {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: inline-block;
        width: auto;
        margin-top: 10px;
    }

    td[data-label="Acciones"] form button.btn-danger {
        display: block;
        font-size: 12px;
        padding: 6px 10px;
        width: 90px;
        margin: 0 auto;
    }
}
</style>
@endsection

