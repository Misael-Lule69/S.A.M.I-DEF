@extends('layouts.app')

@section('content')
<style>
    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .dashboard-card .card-body {
        padding: 2rem;
        text-align: center;
    }
    
    .dashboard-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    
    .dashboard-card .display-4 {
        font-weight: 700;
        margin: 0;
        font-size: 2.5rem;
    }
    
    .bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .bg-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    }
    
    .bg-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .welcome-section h3 {
        margin: 0;
        font-weight: 600;
        font-size: 1.8rem;
    }
    
    .calendar-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .calendar-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }

    .calendar-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        margin-bottom: 1rem;
    }

    .calendar-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1rem;
    }

    .nav-btn {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 50px;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        min-width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-btn:hover {
        background: rgba(255,255,255,0.4);
        border-color: rgba(255,255,255,0.6);
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .nav-btn i {
        transition: all 0.3s ease;
    }

    .nav-btn:hover i {
        transform: scale(1.2);
    }

    .current-month {
        font-size: 1.5rem;
        font-weight: 600;
        min-width: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .current-month i {
        font-size: 1.3rem;
        opacity: 0.9;
    }

    .view-toggle {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .view-btn {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .view-btn:hover {
        background: rgba(255,255,255,0.4);
        border-color: rgba(255,255,255,0.6);
        color: white;
        text-decoration: none;
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .view-btn.active {
        background: rgba(255,255,255,0.5);
        border-color: rgba(255,255,255,0.8);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .calendar-grid {
        display: flex;
        flex-direction: column;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }

    .weekday {
        padding: 1rem;
        text-align: center;
        font-weight: 700;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: #e9ecef;
    }

    .calendar-day {
        min-height: 120px;
        background: white;
        padding: 0.5rem;
        position: relative;
        transition: all 0.3s ease;
    }

    .calendar-day:hover {
        background: #f8f9fa;
        transform: scale(1.02);
        z-index: 10;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .calendar-day.empty {
        background: #f8f9fa;
    }

    .calendar-day.today {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border: 2px solid #2196f3;
    }

    .calendar-day.other-month {
        background: #fafafa;
        color: #ccc;
    }

    .day-number {
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .calendar-event {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        color: white;
        margin-bottom: 0.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .calendar-event:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .event-pendiente {
        background: linear-gradient(135deg, #e8d5ff 0%, #d4b5ff 100%);
        color: #6a4c93;
        border: 1px solid #c8a2c8;
    }

    .event-realizada {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        color: #7b1fa2;
        border: 1px solid #ce93d8;
    }

    .event-cancelada {
        background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%);
        color: #c2185b;
        border: 1px solid #f48fb1;
    }

    .event-confirmada {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
        border: 1px solid #90caf9;
    }

    .event-time {
        font-weight: 600;
        font-size: 0.7rem;
    }

    .event-patient {
        font-size: 0.65rem;
        opacity: 0.9;
    }

    .stats-bar {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 600;
    }
    
    .stats-row {
        margin-bottom: 2rem;
    }
    
    .container {
        max-width: 1200px;
    }
    
    @media (max-width: 768px) {
        .dashboard-card .card-body {
            padding: 1.5rem;
        }
        
        .dashboard-card .display-4 {
            font-size: 2rem;
        }
        
        .welcome-section {
            padding: 1.5rem;
        }
        
        .welcome-section h3 {
            font-size: 1.5rem;
        }
        
        .calendar-day {
            min-height: 80px;
            padding: 0.25rem;
        }
        
        .day-number {
            font-size: 0.9rem;
        }
        
        .calendar-event {
            font-size: 0.6rem;
            padding: 0.15rem 0.3rem;
        }
        
        .calendar-title {
            font-size: 1.5rem;
        }
        
        .current-month {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Sección de Bienvenida -->
            <div class="welcome-section">
                <h3>👋 Bienvenido(a) de vuelta, {{ Auth::user()->name }}</h3>
                <p class="mb-0 mt-2" style="opacity: 0.9;">Aquí tienes un resumen de tus citas médicas</p>
            </div>

            <!-- Cards de Estadísticas -->
            <div class="row stats-row">
                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">📅 Citas Hoy</h5>
                            <p class="card-text display-4">{{ $citasHoy }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">⏳ Pendientes</h5>
                            <p class="card-text display-4">{{ $citasPendientes }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card dashboard-card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">✅ Completadas</h5>
                            <p class="card-text display-4">{{ $citasRealizadas }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Barra de Estadísticas del Mes -->
            <div class="stats-bar">
                <h5 class="mb-3">📊 Estadísticas del Mes</h5>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">{{ $citas->where('estado', 'pendiente')->count() }}</div>
                        <div class="stat-label">Pendientes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $citas->whereIn('estado', ['realizada', 'completada'])->count() }}</div>
                        <div class="stat-label">Completadas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $citas->where('estado', 'cancelada')->count() }}</div>
                        <div class="stat-label">Canceladas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $citas->where('confirmada', true)->count() }}</div>
                        <div class="stat-label">Confirmadas</div>
                    </div>
                </div>
            </div>

            <!-- Calendario Mensual -->
            <div class="calendar-container">
                <div class="calendar-header">
                    <h1 class="calendar-title">📅 Calendario de Citas</h1>
                    
                    <div class="calendar-actions">
                        <button class="nav-btn" onclick="changeMonth(-1)" title="Mes anterior (←)">
                            <i class="fas fa-arrow-circle-left"></i>
                        </button>
                        <span class="current-month" id="currentMonth">
                            <i class="fas fa-calendar-alt me-2"></i>{{ $fecha->format('F Y') }}
                        </span>
                        <button class="nav-btn" onclick="changeMonth(1)" title="Mes siguiente (→)">
                            <i class="fas fa-arrow-circle-right"></i>
                        </button>
                    </div>
                    
                    <div class="text-center mt-2" style="opacity: 0.8; font-size: 0.8rem;">
                        <i class="fas fa-keyboard me-1"></i>
                        Usa las flechas ← → para navegar o la tecla Home para ir al mes actual
                    </div>
                    
                    <div class="view-toggle">
                        <button class="view-btn active" onclick="goToCurrentMonth()" title="Ir al mes actual (Home)">
                            <i class="fas fa-home me-2"></i>Mes Actual
                        </button>
                    </div>
                </div>
                
                <div class="calendar-grid">
                    <div class="calendar-weekdays">
                        <div class="weekday">Dom</div>
                        <div class="weekday">Lun</div>
                        <div class="weekday">Mar</div>
                        <div class="weekday">Mié</div>
                        <div class="weekday">Jue</div>
                        <div class="weekday">Vie</div>
                        <div class="weekday">Sáb</div>
                    </div>
                    
                    <div class="calendar-days" id="calendarDays">
                        @php
                            $firstDay = $fecha->copy()->startOfMonth();
                            $lastDay = $fecha->copy()->endOfMonth();
                            $startDate = $firstDay->copy()->startOfWeek();
                            $endDate = $lastDay->copy()->endOfWeek();
                            $currentDate = $startDate->copy();
                            $today = Carbon\Carbon::today();
                        @endphp
                        
                        @while($currentDate <= $endDate)
                            @php
                                $isCurrentMonth = $currentDate->month === $fecha->month;
                                $isToday = $currentDate->format('Y-m-d') === $today->format('Y-m-d');
                                $dayNumber = $currentDate->format('j');
                                $dayCitas = $citasPorDia[$dayNumber] ?? [];
                            @endphp
                            
                            <div class="calendar-day {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }}">
                                <div class="day-number">{{ $dayNumber }}</div>
                                
                                @foreach($dayCitas as $cita)
                                    <div class="calendar-event event-{{ $cita->estado }}" 
                                         title="{{ $cita->paciente ? $cita->paciente->nombre . ' ' . $cita->paciente->apellido_paterno : 'N/A' }} - {{ $cita->motivo }}">
                                        <div class="event-time">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</div>
                                        <div class="event-patient">
                                            {{ $cita->paciente ? Str::limit($cita->paciente->nombre . ' ' . $cita->paciente->apellido_paterno, 15) : 'N/A' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @php
                                $currentDate->addDay();
                            @endphp
                        @endwhile
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeMonth(direction) {
    const currentUrl = new URL(window.location);
    let mes = parseInt(currentUrl.searchParams.get('mes')) || {{ $fecha->month }};
    let anio = parseInt(currentUrl.searchParams.get('anio')) || {{ $fecha->year }};
    
    mes += direction;
    
    if (mes > 12) {
        mes = 1;
        anio++;
    } else if (mes < 1) {
        mes = 12;
        anio--;
    }
    
    // Construir la nueva URL
    const baseUrl = window.location.pathname.split('/').slice(0, -2).join('/') + '/home';
    const newUrl = `${baseUrl}?mes=${mes}&anio=${anio}`;
    window.location.href = newUrl;
}

function goToCurrentMonth() {
    const today = new Date();
    const currentMonth = today.getMonth() + 1; // getMonth() devuelve 0-11
    const currentYear = today.getFullYear();
    
    // Construir la nueva URL
    const baseUrl = window.location.pathname.split('/').slice(0, -2).join('/') + '/home';
    const newUrl = `${baseUrl}?mes=${currentMonth}&anio=${currentYear}`;
    window.location.href = newUrl;
}

// Agregar navegación con teclado
document.addEventListener('keydown', function(event) {
    if (event.key === 'ArrowLeft') {
        changeMonth(-1);
    } else if (event.key === 'ArrowRight') {
        changeMonth(1);
    } else if (event.key === 'Home') {
        goToCurrentMonth();
    }
});
</script>

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
         role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@endsection