@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid">
    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-white border-0">
                <h2>Configuración de Horarios</h2>
                <p class="text-muted">Configure sus bloques de trabajo y descansos de manera visual e intuitiva.</p>
            </div>
            
            <div class="card-body">
                <!-- Pestañas -->
                <ul class="nav nav-tabs mb-4" id="scheduleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="blocks-tab" data-bs-toggle="tab" data-bs-target="#blocks-tab-pane" type="button" role="tab">Configuración de Bloques</button>
                    </li>
                </ul>

                <!-- Contenido de pestañas -->
                <div class="tab-content" id="scheduleTabsContent">
                    <!-- Pestaña de Bloques -->
                    <div class="tab-pane fade show active" id="blocks-tab-pane" role="tabpanel" aria-labelledby="blocks-tab">
                        <!-- Estadísticas -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card text-white bg-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Días activos</h5>
                                        <p class="card-text display-4" id="active-days-count">0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-success">
                                    <div class="card-body">
                                        <h5 class="card-title">Horas semanales</h5>
                                        <p class="card-text display-4" id="weekly-hours">0h</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-white bg-info">
                                    <div class="card-body">
                                        <h5 class="card-title">Bloques de trabajo</h5>
                                        <p class="card-text display-4" id="work-blocks">0</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <button id="save-schedule" class="btn btn-primary btn-lg">Guardar Horarios</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuración de Bloques -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4>Configuración de Bloques de Tiempo</h4>
                                <p class="mb-0">Configure bloques de trabajo y descansos para cada día</p>
                            </div>
                            <div class="card-body">
                                <!-- Controles superiores -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary" id="add-work-block">
                                                <i class="fas fa-briefcase"></i> Trabajo
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="add-break-block">
                                                <i class="fas fa-coffee"></i> Descanso
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="template-select">
                                            <option value="">Seleccionar plantilla...</option>
                                            <option value="full-day">Jornada Completa</option>
                                            <option value="morning">Solo Mañana</option>
                                            <option value="afternoon">Solo Tarde</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Selección de días de descanso -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">Días de Descanso</h5>
                                                <p class="mb-0 text-muted">Seleccione los días que desea marcar como descanso completo</p>
                                            </div>
                                            <div class="card-body">
                                                <div class="days-off-container" role="group">
    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
    <input type="checkbox" class="btn-check day-off-checkbox" id="day-off-{{ strtolower($day) }}" autocomplete="off" data-day="{{ strtolower($day) }}">
    <label class="btn btn-outline-danger" for="day-off-{{ strtolower($day) }}">{{ $day }}</label>
    @endforeach
</div>
                                                <div class="mt-2">
                                                    <button class="btn btn-sm btn-outline-secondary" id="clear-days-off">Limpiar selección</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Días de la semana -->
                                <div class="row">
                                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                    <div class="col-md-6 mb-4">
                                        <div class="card day-card" data-day="{{ strtolower($day) }}">
                                            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input day-toggle" type="checkbox" id="toggle-{{ strtolower($day) }}">
                                                    <label class="form-check-label" for="toggle-{{ strtolower($day) }}"><h5 class="mb-0">{{ $day }}</h5></label>
                                                </div>
                                                <div class="day-stats badge bg-info">0 bloques</div>
                                            </div>
                                            <div class="card-body day-configuration">
                                                <div class="no-blocks-message text-muted">
                                                    No hay bloques configurados. Use los botones de arriba para agregar horarios de trabajo o descansos
                                                </div>
                                                <div class="timeline-container d-none">
                                                    <div class="timeline-header d-flex justify-content-between mb-2">
                                                        <small>Horario</small>
                                                        <small>Tipo</small>
                                                    </div>
                                                    <div class="timeline-items"></div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-light">
                                                <button class="btn btn-sm btn-outline-primary add-block-btn" data-day="{{ strtolower($day) }}">
                                                    <i class="fas fa-plus"></i> Agregar bloque
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña de Calendario -->
                    <div class="tab-pane fade" id="calendar-tab-pane" role="tabpanel" aria-labelledby="calendar-tab">
                        <div class="card">
                            <div class="card-header">
                                <h4>Vista Semanal de Horarios</h4>
                                <p class="mb-0">Visualización de todos los bloques programados</p>
                            </div>
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para agregar/editar bloques -->
                <div class="modal fade" id="blockModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Bloque</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="block-form">
                                    <input type="hidden" id="block-id">
                                    <div class="mb-3">
                                        <label class="form-label">Día de la semana</label>
                                        <select class="form-select" id="block-day" required>
                                            <option value="">Seleccionar día...</option>
                                            <option value="lunes">Lunes</option>
                                            <option value="martes">Martes</option>
                                            <option value="miércoles">Miércoles</option>
                                            <option value="jueves">Jueves</option>
                                            <option value="viernes">Viernes</option>
                                            <option value="sábado">Sábado</option>
                                            <option value="domingo">Domingo</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de bloque</label>
                                        <div class="btn-group w-100" role="group">
                                            <input type="radio" class="btn-check" name="block-type" id="block-type-work" value="work" checked>
                                            <label class="btn btn-outline-primary" for="block-type-work">
                                                <i class="fas fa-briefcase"></i> Trabajo
                                            </label>
                                            <input type="radio" class="btn-check" name="block-type" id="block-type-break" value="break">
                                            <label class="btn btn-outline-secondary" for="block-type-break">
                                                <i class="fas fa-coffee"></i> Descanso
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="start-time" class="form-label">Hora inicio</label>
                                            <input type="time" class="form-control" id="start-time" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end-time" class="form-label">Hora fin</label>
                                            <input type="time" class="form-control" id="end-time" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="block-label" class="form-label">Etiqueta (opcional)</label>
                                        <input type="text" class="form-control" id="block-label" placeholder="Ej: Consultas matutinas">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="save-block">Guardar Bloque</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para agregar descanso -->
                <div class="modal fade" id="restDayModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Día de Descanso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="rest-day-form">
                                    <div class="mb-3">
                                        <label class="form-label">Seleccionar día(s)</label>
                                        <div class="btn-group-vertical w-100" role="group">
                                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="rest-day-{{ strtolower($day) }}" value="{{ strtolower($day) }}">
                                                <label class="form-check-label" for="rest-day-{{ strtolower($day) }}">
                                                    {{ $day }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="save-rest-day">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    .day-card {
        transition: all 0.3s ease;
    }
    
    .day-card .card-header {
        cursor: pointer;
    }
    
    .day-toggle:checked ~ label h5 {
        font-weight: bold;
        color: #0d6efd;
    }
    
    .timeline-items {
        border-left: 2px solid #dee2e6;
        padding-left: 15px;
    }
    
    .timeline-item {
        position: relative;
        padding: 5px 10px;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -20px;
        top: 12px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #0d6efd;
    }
    
    .timeline-item.work {
        background-color: rgba(13, 110, 253, 0.1);
        border-left: 3px solid #0d6efd;
    }
    
    .timeline-item.break {
        background-color: rgba(108, 117, 125, 0.1);
        border-left: 3px solid #6c757d;
    }
    
    .block-label {
        font-weight: 500;
    }
    
    .block-actions {
        position: absolute;
        right: 10px;
        top: 5px;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        margin-left: 0;
        margin-right: 10px;
    }

    .nav-tabs .nav-link {
        font-weight: 500;
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        font-weight: 600;
        color: #0d6efd;
    }

    #calendar {
        width: 100%;
        min-height: 70vh;
        padding: 15px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .fc-header-toolbar {
        margin-bottom: 1em;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #343a40;
    }

    .fc-button {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
        font-weight: 500;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s;
    }

    .fc-button:hover {
        background-color: #e9ecef;
        color: #0d6efd;
    }

    .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .fc-col-header-cell {
        background-color: #f8f9fa;
        padding: 10px 0;
        border-color: #dee2e6 !important;
    }

    .fc-col-header-cell-cushion {
        color: #495057;
        font-weight: 500;
        text-decoration: none;
    }

    .fc-timegrid-slot {
        height: 2.5em;
        border-color: #f1f3f5 !important;
    }

    .fc-timegrid-slot-label-cushion {
        color: #6c757d;
        font-size: 0.85em;
    }

    .fc-event {
        border: none;
        border-radius: 4px;
        padding: 3px 6px;
        font-size: 0.85em;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.2s;
    }

    .fc-event:hover {
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transform: translateY(-1px);
    }

    .fc-event-work {
        background-color: #0d6efd;
        border-left: 3px solid #0b5ed7;
    }

    .fc-event-break {
        background-color: #6c757d;
        border-left: 3px solid #5c636a;
    }

    .fc-event-main {
        display: flex;
        flex-direction: column;
    }

    .fc-event-title {
        font-weight: 500;
        margin-bottom: 2px;
    }

    .fc-event-time {
        font-size: 0.8em;
        opacity: 0.9;
    }

    .fc-timegrid-now-indicator-line {
        border-color: #dc3545;
        border-width: 2px;
    }

    .fc-scroller::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .fc-scroller::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .fc-scroller::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }

    .fc-scroller::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .day-off-checkbox:checked + label {
        background-color: #dc3545 !important;
        color: white !important;
    }

    #clear-days-off {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }

    /* Estilos responsivos para los botones de días de descanso */
.days-off-container {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.days-off-container .btn {
    flex: 1 0 calc(14.28% - 5px); /* 7 botones por fila */
    min-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 992px) {
    .days-off-container .btn {
        flex: 1 0 calc(25% - 5px); /* 4 botones por fila */
    }
}

@media (max-width: 768px) {
    .days-off-container .btn {
        flex: 1 0 calc(33.33% - 5px); /* 3 botones por fila */
    }
}

@media (max-width: 576px) {
    .days-off-container .btn {
        flex: 1 0 calc(50% - 5px); /* 2 botones por fila */
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales necesarias
    let scheduleData = {
        'lunes': { active: false, blocks: [] },
        'martes': { active: false, blocks: [] },
        'miércoles': { active: false, blocks: [] },
        'jueves': { active: false, blocks: [] },
        'viernes': { active: false, blocks: [] },
        'sábado': { active: false, blocks: [] },
        'domingo': { active: false, blocks: [] }
    };
    
    // Duración mínima de bloque en minutos (15 minutos)
    const MIN_BLOCK_DURATION_MINUTES = 15;
    
    let calendar = null;
    let isEditing = false;
    const blockModal = new bootstrap.Modal(document.getElementById('blockModal'));
    const restDayModal = new bootstrap.Modal(document.getElementById('restDayModal'));
    
    // Cargar horarios automáticamente al iniciar
    loadSchedules();

    // Función mejorada para cargar horarios
    function loadSchedules() {
        fetch("{{ route('horarios.eventos') }}")
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta');
                return response.json();
            })
            .then(data => {
                // Reiniciar los datos
                Object.keys(scheduleData).forEach(day => {
                    scheduleData[day].active = false;
                    scheduleData[day].blocks = [];
                });

                // Cargar datos del servidor
                for (const day in data) {
                    if (scheduleData[day]) {
                        scheduleData[day].active = data[day].active;
                        scheduleData[day].blocks = data[day].blocks || [];
                        
                        // Actualizar UI
                        const toggle = document.getElementById(`toggle-${day}`);
                        if (toggle) {
                            toggle.checked = data[day].active;
                        }
                        updateDayCard(day);
                    }
                }
                updateGlobalStats();
            })
            .catch(error => {
                console.error("Error al cargar horarios:", error);
            });
    }
    
    // Inicializar FullCalendar
    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            allDaySlot: false,
            slotMinTime: '06:00:00',
            slotMaxTime: '22:00:00',
            slotDuration: '01:00:00',
            firstDay: 1, // Lunes como primer día de la semana
            events: generateCalendarEvents(),
            eventContent: function(arg) {
                return {
                    html: `<div class="fc-event-title">${arg.event.title}</div>
                           <div class="fc-event-time">${arg.timeText}</div>`
                };
            },
            eventDidMount: function(arg) {
                arg.el.classList.add(`fc-event-${arg.event.extendedProps.type}`);
                
                // Tooltip para mostrar más información
                arg.el.setAttribute('data-bs-toggle', 'tooltip');
                arg.el.setAttribute('title', `${arg.event.extendedProps.type === 'work' ? 'Trabajo' : 'Descanso'}: ${arg.event.title}`);
                new bootstrap.Tooltip(arg.el);
            },
            slotLabelFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            dayHeaderFormat: { weekday: 'long', day: 'numeric' },
            height: 'auto',
            nowIndicator: true,
            scrollTime: '08:00:00',
            stickyHeaderDates: true,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }
        });
        calendar.render();
    }

    // Generar eventos para el calendario basados en scheduleData
    function generateCalendarEvents() {
        const events = [];
        const daysMap = {
            'lunes': 1,
            'martes': 2,
            'miércoles': 3,
            'jueves': 4,
            'viernes': 5,
            'sábado': 6,
            'domingo': 0
        };

        for (const day in scheduleData) {
            if (scheduleData[day].active && scheduleData[day].blocks.length > 0) {
                scheduleData[day].blocks.forEach(block => {
                    // Filtrar bloques que no cumplan con la duración mínima
                    const startParts = block.startTime ? block.startTime.split(':') : block.start.split(':');
                    const endParts = block.endTime ? block.endTime.split(':') : block.end.split(':');
                    const startDate = new Date(2000, 0, 1, parseInt(startParts[0]), parseInt(startParts[1]));
                    const endDate = new Date(2000, 0, 1, parseInt(endParts[0]), parseInt(endParts[1]));
                    const durationMinutes = (endDate - startDate) / (1000 * 60);
                    
                    if (durationMinutes >= MIN_BLOCK_DURATION_MINUTES) {
                        events.push({
                            title: block.label || (block.type === 'work' ? 'Trabajo' : 'Descanso'),
                            startTime: block.startTime || block.start,
                            endTime: block.endTime || block.end,
                            daysOfWeek: [daysMap[day]],
                            type: block.type,
                            backgroundColor: block.type === 'work' ? '#0d6efd' : '#6c757d',
                            borderColor: block.type === 'work' ? '#0b5ed7' : '#5c636a',
                            extendedProps: {
                                type: block.type
                            }
                        });
                    }
                });
            }
        }
        return events;
    }

    // Actualizar calendario
    function updateCalendar() {
        if (calendar) {
            calendar.removeAllEvents();
            calendar.addEventSource(generateCalendarEvents());
        }
    }
    
    // Función para actualizar estadísticas globales
    function updateGlobalStats() {
        let activeDays = 0;
        let totalBlocks = 0;
        let totalMinutes = 0;
        
        // Calcular días activos y bloques
        for (const day in scheduleData) {
            if (scheduleData[day].active) {
                activeDays++;
            }
            
            // Solo contar bloques que cumplan con la duración mínima
            const validBlocks = scheduleData[day].blocks.filter(block => {
                const startParts = block.startTime ? block.startTime.split(':') : block.start.split(':');
                const endParts = block.endTime ? block.endTime.split(':') : block.end.split(':');
                const startDate = new Date(2000, 0, 1, parseInt(startParts[0]), parseInt(startParts[1]));
                const endDate = new Date(2000, 0, 1, parseInt(endParts[0]), parseInt(endParts[1]));
                const durationMinutes = (endDate - startDate) / (1000 * 60);
                return durationMinutes >= MIN_BLOCK_DURATION_MINUTES;
            });
            
            totalBlocks += validBlocks.length;
            
            // Calcular horas totales
            validBlocks.forEach(block => {
                const start = block.startTime || block.start;
                const end = block.endTime || block.end;
                
                if (start && end) {
                    const startTime = new Date(`2000-01-01T${start}:00`);
                    const endTime = new Date(`2000-01-01T${end}:00`);
                    const diff = (endTime - startTime) / (1000 * 60); // diferencia en minutos
                    totalMinutes += diff;
                }
            });
        }
        
        const totalHours = Math.round(totalMinutes / 60);
        
        // Actualizar UI
        document.getElementById('active-days-count').textContent = activeDays;
        document.getElementById('work-blocks').textContent = totalBlocks;
        document.getElementById('weekly-hours').textContent = `${totalHours}h`;
    }
    
    // Manejar clic en "Agregar bloque" (día específico)
    document.querySelectorAll('.add-block-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const day = this.dataset.day;
            document.getElementById('block-day').value = day;
            document.getElementById('block-id').value = '';
            isEditing = false;
            document.getElementById('block-form').reset();
            document.getElementById('block-type-work').checked = true;
            document.getElementById('blockModal').querySelector('.modal-title').textContent = 'Agregar Bloque';
            blockModal.show();
        });
    });
    
    // Botones superiores para agregar bloques
    document.getElementById('add-work-block').addEventListener('click', function() {
        document.getElementById('block-type-work').checked = true;
        document.getElementById('block-id').value = '';
        isEditing = false;
        document.getElementById('block-form').reset();
        document.getElementById('blockModal').querySelector('.modal-title').textContent = 'Agregar Bloque de Trabajo';
        blockModal.show();
    });
    
    document.getElementById('add-break-block').addEventListener('click', function() {
        document.getElementById('block-type-break').checked = true;
        document.getElementById('block-id').value = '';
        isEditing = false;
        document.getElementById('block-form').reset();
        document.getElementById('blockModal').querySelector('.modal-title').textContent = 'Agregar Bloque de Descanso';
        blockModal.show();
    });
    
    // Guardar bloque con validación de duración mínima
    document.getElementById('save-block').addEventListener('click', function() {
        const day = document.getElementById('block-day').value;
        const blockId = document.getElementById('block-id').value;
        
        if (!day) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, selecciona un día primero',
                icon: 'error'
            });
            return;
        }
        
        const type = document.querySelector('input[name="block-type"]:checked').value;
        const startTime = document.getElementById('start-time').value;
        const endTime = document.getElementById('end-time').value;
        const label = document.getElementById('block-label').value || (type === 'work' ? 'Trabajo' : 'Descanso');
        
        if (!startTime || !endTime) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, completa las horas de inicio y fin',
                icon: 'error'
            });
            return;
        }
        
        // Validar que la hora de fin sea mayor que la de inicio
        if (startTime >= endTime) {
            Swal.fire({
                title: 'Error',
                text: 'La hora de fin debe ser mayor que la hora de inicio',
                icon: 'error'
            });
            return;
        }
        
        // Calcular duración en minutos
        const startParts = startTime.split(':').map(Number);
        const endParts = endTime.split(':').map(Number);
        const startDate = new Date(2000, 0, 1, startParts[0], startParts[1]);
        const endDate = new Date(2000, 0, 1, endParts[0], endParts[1]);
        const durationMinutes = (endDate - startDate) / (1000 * 60);
        
        // Validar duración mínima
        if (durationMinutes < MIN_BLOCK_DURATION_MINUTES) {
            Swal.fire({
                title: 'Error',
                text: `La duración mínima de un bloque es de ${MIN_BLOCK_DURATION_MINUTES} minutos`,
                icon: 'error'
            });
            return;
        }
        
        // Crear o actualizar bloque
        const block = {
            type,
            startTime: startTime,
            endTime: endTime,
            start: startTime, // Compatibilidad con backend
            end: endTime,    // Compatibilidad con backend
            label,
            id: blockId || Date.now().toString()
        };
        
        if (isEditing && blockId) {
            // Editar bloque existente
            const index = scheduleData[day].blocks.findIndex(b => b.id == blockId);
            if (index !== -1) {
                scheduleData[day].blocks[index] = block;
            }
        } else {
            // Agregar nuevo bloque
            scheduleData[day].blocks.push(block);
        }
        
        // Activar el día si no estaba activo
        if (!scheduleData[day].active) {
            scheduleData[day].active = true;
            document.getElementById(`toggle-${day}`).checked = true;
        }
        
        updateDayCard(day);
        
        // Resetear formulario y cerrar modal
        document.getElementById('block-form').reset();
        blockModal.hide();
    });
    
    // Selección de plantilla con validación de duración
    document.getElementById('template-select').addEventListener('change', function() {
        const template = this.value;
        if (!template) return;
        
        Swal.fire({
            title: 'Aplicar plantilla',
            text: '¿A qué día quieres aplicar esta plantilla? (lunes, martes, etc.)',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Aplicar',
            cancelButtonText: 'Cancelar',
            preConfirm: (day) => {
                if (!day || !scheduleData[day.toLowerCase()]) {
                    Swal.showValidationMessage('Día no válido');
                    this.value = '';
                    return false;
                }
                return day.toLowerCase();
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const day = result.value;
                const dayData = scheduleData[day];
                
                // Limpiar bloques existentes
                dayData.blocks = [];
                
                // Aplicar plantilla seleccionada
                switch(template) {
                    case 'full-day':
                        dayData.blocks = [
                            { type: 'work', startTime: '09:00', start: '09:00', endTime: '13:00', end: '13:00', label: 'Mañana', id: Date.now().toString() + 1 },
                            { type: 'break', startTime: '13:00', start: '13:00', endTime: '14:00', end: '14:00', label: 'Almuerzo', id: Date.now().toString() + 2 },
                            { type: 'work', startTime: '14:00', start: '14:00', endTime: '18:00', end: '18:00', label: 'Tarde', id: Date.now().toString() + 3 }
                        ];
                        break;
                    case 'morning':
                        dayData.blocks = [
                            { type: 'work', startTime: '09:00', start: '09:00', endTime: '13:00', end: '13:00', label: 'Mañana', id: Date.now().toString() + 1 }
                        ];
                        break;
                    case 'afternoon':
                        dayData.blocks = [
                            { type: 'work', startTime: '14:00', start: '14:00', endTime: '18:00', end: '18:00', label: 'Tarde', id: Date.now().toString() + 1 }
                        ];
                        break;
                }
                
                // Validar que los bloques de la plantilla cumplan con la duración mínima
                dayData.blocks = dayData.blocks.filter(block => {
                    const startParts = block.startTime.split(':').map(Number);
                    const endParts = block.endTime.split(':').map(Number);
                    const startDate = new Date(2000, 0, 1, startParts[0], startParts[1]);
                    const endDate = new Date(2000, 0, 1, endParts[0], endParts[1]);
                    const durationMinutes = (endDate - startDate) / (1000 * 60);
                    return durationMinutes >= MIN_BLOCK_DURATION_MINUTES;
                });
                
                // Activar el día si no estaba activo y hay bloques válidos
                if (!dayData.active && dayData.blocks.length > 0) {
                    document.getElementById(`toggle-${day}`).checked = true;
                    dayData.active = true;
                }
                
                updateDayCard(day);
                this.value = ''; // Resetear el selector
            }
        });
    });
    
    // Toggle para activar/desactivar día
    document.querySelectorAll('.day-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const day = this.id.replace('toggle-', '');
            
            // No permitir activar si no hay bloques
            if (this.checked && scheduleData[day].blocks.length === 0) {
                this.checked = false;
                Swal.fire({
                    title: 'Error',
                    text: 'No puedes activar un día sin bloques definidos. Por favor, agrega al menos un bloque primero.',
                    icon: 'error'
                });
                return;
            }
            
            scheduleData[day].active = this.checked;
            
            if (!this.checked) {
                scheduleData[day].blocks = [];
            }
            
            updateDayCard(day);
            updateGlobalStats();
        });
    });
    
    // Manejar días de descanso
    document.querySelectorAll('.day-off-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const day = this.dataset.day;
            const isDayOff = this.checked;
            
            if (isDayOff) {
                // Marcar como día de descanso completo
                scheduleData[day].active = true;
                scheduleData[day].blocks = [
                    { type: 'break', startTime: '00:00', start: '00:00', endTime: '23:59', end: '23:59', label: 'Día de descanso', id: Date.now().toString() }
                ];
                document.getElementById(`toggle-${day}`).checked = true;
            } else {
                // Quitar día de descanso
                scheduleData[day].blocks = [];
                document.getElementById(`toggle-${day}`).checked = false;
                scheduleData[day].active = false;
            }
            
            updateDayCard(day);
            updateGlobalStats();
        });
    });
    
    // Limpiar selección de días de descanso
    document.getElementById('clear-days-off').addEventListener('click', function() {
        document.querySelectorAll('.day-off-checkbox').forEach(checkbox => {
            checkbox.checked = false;
            const day = checkbox.dataset.day;
            
            // Solo limpiar si el día solo tenía el bloque de descanso completo
            if (scheduleData[day].blocks.length === 1 && 
                scheduleData[day].blocks[0].label === 'Día de descanso') {
                scheduleData[day].blocks = [];
                document.getElementById(`toggle-${day}`).checked = false;
                scheduleData[day].active = false;
                updateDayCard(day);
            }
        });
        
        updateGlobalStats();
    });
    
    // Eliminar bloque
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-block') || e.target.closest('.delete-block')) {
            const button = e.target.classList.contains('delete-block') ? e.target : e.target.closest('.delete-block');
            const blockId = button.dataset.id;
            
            for (const day in scheduleData) {
                const index = scheduleData[day].blocks.findIndex(b => b.id === blockId);
                if (index !== -1) {
                    scheduleData[day].blocks.splice(index, 1);
                    
                    // Si era el último bloque, desactivar el día
                    if (scheduleData[day].blocks.length === 0 && scheduleData[day].active) {
                        scheduleData[day].active = false;
                        document.getElementById(`toggle-${day}`).checked = false;
                    }
                    
                    updateDayCard(day);
                    break;
                }
            }
        }
        
        // Editar bloque
        if (e.target.classList.contains('edit-block') || e.target.closest('.edit-block')) {
            const button = e.target.classList.contains('edit-block') ? e.target : e.target.closest('.edit-block');
            const blockId = button.dataset.id;
            
            for (const day in scheduleData) {
                const block = scheduleData[day].blocks.find(b => b.id === blockId);
                if (block) {
                    // Llenar el modal con los datos del bloque
                    document.getElementById('block-day').value = day;
                    document.getElementById('block-id').value = block.id;
                    document.getElementById(`block-type-${block.type}`).checked = true;
                    document.getElementById('start-time').value = block.startTime || block.start;
                    document.getElementById('end-time').value = block.endTime || block.end;
                    document.getElementById('block-label').value = block.label;
                    
                    isEditing = true;
                    document.getElementById('blockModal').querySelector('.modal-title').textContent = 'Editar Bloque';
                    blockModal.show();
                    break;
                }
            }
        }
    });
    
    // Función para actualizar la tarjeta de un día
    function updateDayCard(day) {
        const dayData = scheduleData[day];
        const dayCard = document.querySelector(`.day-card[data-day="${day}"]`);
        
        if (!dayCard) return;
        
        const noBlocksMsg = dayCard.querySelector('.no-blocks-message');
        const timelineContainer = dayCard.querySelector('.timeline-container');
        const timelineItems = dayCard.querySelector('.timeline-items');
        const dayStats = dayCard.querySelector('.day-stats');
        const dayToggle = document.getElementById(`toggle-${day}`);
        
        // Filtrar bloques que no cumplan con la duración mínima
        const validBlocks = dayData.blocks.filter(block => {
            const startParts = block.startTime ? block.startTime.split(':') : block.start.split(':');
            const endParts = block.endTime ? block.endTime.split(':') : block.end.split(':');
            const startDate = new Date(2000, 0, 1, parseInt(startParts[0]), parseInt(startParts[1]));
            const endDate = new Date(2000, 0, 1, parseInt(endParts[0]), parseInt(endParts[1]));
            const durationMinutes = (endDate - startDate) / (1000 * 60);
            return durationMinutes >= MIN_BLOCK_DURATION_MINUTES;
        });
        
        // Si no hay bloques válidos pero el día está activo, desactivarlo
        if (validBlocks.length === 0 && dayData.active) {
            dayData.active = false;
            if (dayToggle) dayToggle.checked = false;
        }
        
        // Actualizar estadísticas del día
        if (dayStats) {
            dayStats.textContent = `${validBlocks.length} ${validBlocks.length === 1 ? 'bloque' : 'bloques'}`;
        }
        
        // Mostrar u ocultar mensaje de no bloques
        if (validBlocks.length === 0) {
            noBlocksMsg?.classList.remove('d-none');
            timelineContainer?.classList.add('d-none');
        } else {
            noBlocksMsg?.classList.add('d-none');
            timelineContainer?.classList.remove('d-none');
            
            // Ordenar bloques por hora de inicio
            validBlocks.sort((a, b) => {
                const aTime = a.startTime || a.start;
                const bTime = b.startTime || b.start;
                return aTime.localeCompare(bTime);
            });
            
            // Generar timeline
            if (timelineItems) {
                timelineItems.innerHTML = '';
                validBlocks.forEach(block => {
                    const timelineItem = document.createElement('div');
                    timelineItem.className = `timeline-item ${block.type} position-relative`;
                    timelineItem.dataset.id = block.id;
                    
                    const startTime = block.startTime || block.start;
                    const endTime = block.endTime || block.end;
                    
                    timelineItem.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <span class="block-time">${startTime} - ${endTime}</span>
                            <span class="badge ${block.type === 'work' ? 'bg-primary' : 'bg-secondary'}">
                                ${block.type === 'work' ? 'Trabajo' : 'Descanso'}
                            </span>
                        </div>
                        <div class="block-label">${block.label || (block.type === 'work' ? 'Trabajo' : 'Descanso')}</div>
                        <div class="block-actions">
                            <button class="btn btn-sm btn-primary edit-block me-1" data-id="${block.id}">Editar</button>
                            <button class="btn btn-sm btn-outline-danger delete-block" data-id="${block.id}">Eliminar</button>
                        </div>
                    `;
                    
                    timelineItems.appendChild(timelineItem);
                });
            }
        }
        
        // Actualizar estadísticas globales
        updateGlobalStats();
        // Actualizar calendario
        updateCalendar();
        
        // Actualizar checkboxes de días de descanso
        const dayOffCheckbox = document.querySelector(`.day-off-checkbox[data-day="${day}"]`);
        if (dayData.blocks.length === 1 && dayData.blocks[0].label === 'Día de descanso') {
            if (dayOffCheckbox) dayOffCheckbox.checked = true;
        } else {
            if (dayOffCheckbox) dayOffCheckbox.checked = false;
        }
    }
    
    // Guardar horario con validación de días activos sin bloques
    document.getElementById('save-schedule').addEventListener('click', function() {
        // Validar que no haya días activos sin bloques
        const daysWithoutBlocks = [];
        for (const day in scheduleData) {
            if (scheduleData[day].active && scheduleData[day].blocks.length === 0) {
                daysWithoutBlocks.push(day.charAt(0).toUpperCase() + day.slice(1)); // Capitalizar nombre del día
            }
        }
        
        if (daysWithoutBlocks.length > 0) {
            Swal.fire({
                title: 'Error',
                html: `Los siguientes días están activos pero no tienen bloques definidos:<br><strong>${daysWithoutBlocks.join(', ')}</strong><br><br>Por favor, agregue bloques o desactive estos días.`,
                icon: 'error'
            });
            return;
        }
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Prepara los datos para enviar
        const dataToSend = {};
        for (const day in scheduleData) {
            dataToSend[day] = {
                active: scheduleData[day].active,
                blocks: scheduleData[day].blocks.map(block => ({
                    type: block.type,
                    start: block.startTime || block.start,
                    end: block.endTime || block.end,
                    label: block.label
                }))
            };
        }

        fetch("{{ route('horarios.guardar') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Éxito',
                    text: 'Horarios guardados correctamente',
                    icon: 'success'
                });
                // Recargar los datos después de guardar
                loadSchedules();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Error al guardar: ' + (data.message || 'Error desconocido'),
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error al conectar con el servidor',
                icon: 'error'
            });
        });
    });

    // Cambio de pestaña
    document.getElementById('calendar-tab').addEventListener('click', function() {
        if (!calendar) {
            initCalendar();
        }
    });
    
    // Inicializar tooltips de Bootstrap
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

</script>
@endsection