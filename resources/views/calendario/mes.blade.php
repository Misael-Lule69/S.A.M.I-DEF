@extends('layouts.app')

@section('content')
<style>
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
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .nav-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
    }

    .current-month {
        font-size: 1.5rem;
        font-weight: 600;
        min-width: 200px;
    }

    .view-toggle {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .view-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .view-btn:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        text-decoration: none;
    }

    .view-btn.active {
        background: rgba(255,255,255,0.4);
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
        background: linear-gradient(135deg, #ff9800 0%, #ff5722 100%);
    }

    .event-realizada {
        background: linear-gradient(135deg, #4caf50 0%, #8bc34a 100%);
    }

    .event-cancelada {
        background: linear-gradient(135deg, #f44336 0%, #e91e63 100%);
    }

    .event-confirmada {
        background: linear-gradient(135deg, #2196f3 0%, #03a9f4 100%);
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

    @media (max-width: 768px) {
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
            <!-- Barra de Estadísticas -->
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

            <!-- Calendario -->
            <div class="calendar-container">
                <div class="calendar-header">
                    <h1 class="calendar-title">📅 Calendario de Citas</h1>
                    
                    <div class="calendar-actions">
                        <button class="nav-btn" onclick="changeMonth(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="current-month" id="currentMonth">
                            {{ $fecha->format('F Y') }}
                        </span>
                        <button class="nav-btn" onclick="changeMonth(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <div class="view-toggle">
                        <a href="{{ route('calendario.mes', ['mes' => $fecha->month, 'anio' => $fecha->year]) }}" 
                           class="view-btn active">📅 Calendario Mensual</a>
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
                                        <div class="event-time">{{ $cita->hora }}</div>
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
    
    currentUrl.searchParams.set('mes', mes);
    currentUrl.searchParams.set('anio', anio);
    window.location.href = currentUrl.toString();
}
</script>
@endsection 