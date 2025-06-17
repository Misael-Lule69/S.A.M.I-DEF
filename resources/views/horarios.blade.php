@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Configuración de Horarios</h2>
            <p class="lead">Configure sus horarios disponibles para atención médica</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Calendario de Horarios</h5>
            <div>
                <button id="prev-btn" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-chevron-left"></i> Anterior
                </button>
                <button id="next-btn" class="btn btn-sm btn-outline-primary">
                    Siguiente <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    #calendar {
        margin: 0 auto;
        max-width: 100%;
        height: 600px;
    }
    .fc-event {
        cursor: pointer;
        font-size: 0.85em;
        padding: 2px 4px;
    }
    .fc-toolbar-title {
        font-size: 1.2em;
    }
</style>
@endsection

@section('scripts')
@vite(['resources/js/calendar.js'])
@endsection
@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    #calendar {
        margin: 0 auto;
        max-width: 100%;
        height: 600px;
    }
    .fc-event {
        cursor: pointer;
        font-size: 0.85em;
        padding: 2px 4px;
    }
    .fc-daygrid-event {
        border-radius: 4px;
    }
    .fc-toolbar-title {
        font-size: 1.2em;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endsection

@section('scripts')
@vite(['resources/js/calendar.js'])
@endsection