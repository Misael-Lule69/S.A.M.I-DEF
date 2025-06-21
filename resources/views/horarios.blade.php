@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Contenido Principal -->
    <div class="col-md-12">
        <div class="card border-0">
            <div class="card-header bg-white border-0">
                <h2>Configuración de Horarios</h2>
                <p class="text-muted">Configure sus bloques de trabajo y descansos de manera visual e intuitiva</p>
            </div>
            
            <div class="card-body">
                <!-- Pestañas -->
                <ul class="nav nav-tabs mb-4" id="scheduleTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="blocks-tab" data-bs-toggle="tab" data-bs-target="#blocks-tab-pane" type="button" role="tab">Configuración de Bloques</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-tab-pane" type="button" role="tab">Vista de Calendario</button>
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
                                            <option value="pientiles">Pientiles</option>
                                        </select>
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

                <!-- Modal para agregar bloques -->
                <div class="modal fade" id="blockModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Bloque</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="block-form">
                                    <input type="hidden" id="block-day">
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
    /* Estilos esenciales */
    html, body {
        height: 100%;
    }
    
    /* Estilos para las tarjetas de días */
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

    /* Estilos para pestañas */
    .nav-tabs .nav-link {
        font-weight: 500;
        color: #495057;
    }

    .nav-tabs .nav-link.active {
        font-weight: 600;
        color: #0d6efd;
    }

    /* Estilos mejorados para el calendario */
    #calendar {
        width: 100%;
        min-height: 70vh;
        padding: 15px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    /* Cabecera del calendario */
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

    /* Botones del calendario */
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

    /* Días de la semana */
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

    /* Celdas del calendario */
    .fc-timegrid-slot {
        height: 2.5em;
        border-color: #f1f3f5 !important;
    }

    .fc-timegrid-slot-label-cushion {
        color: #6c757d;
        font-size: 0.85em;
    }

    /* Eventos del calendario */
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

    /* Hora actual */
    .fc-timegrid-now-indicator-line {
        border-color: #dc3545;
        border-width: 2px;
    }

    /* Scrollbar del calendario */
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
</style>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const scheduleData = {};
    const blockModal = new bootstrap.Modal(document.getElementById('blockModal'));
    let calendar; // Variable para el calendario
    
    // Inicializar datos para cada día
    document.querySelectorAll('.day-card').forEach(card => {
        const day = card.dataset.day;
        scheduleData[day] = {
            active: false,
            blocks: []
        };
    });
    
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
                    events.push({
                        title: block.label,
                        startTime: block.startTime,
                        endTime: block.endTime,
                        daysOfWeek: [daysMap[day]],
                        type: block.type,
                        backgroundColor: block.type === 'work' ? '#0d6efd' : '#6c757d',
                        borderColor: block.type === 'work' ? '#0b5ed7' : '#5c636a',
                        extendedProps: {
                            type: block.type
                        }
                    });
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
            totalBlocks += scheduleData[day].blocks.length;
            
            // Calcular horas totales
            scheduleData[day].blocks.forEach(block => {
                const start = new Date(`2000-01-01T${block.startTime}:00`);
                const end = new Date(`2000-01-01T${block.endTime}:00`);
                const diff = (end - start) / (1000 * 60); // diferencia en minutos
                totalMinutes += diff;
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
            blockModal.show();
        });
    });
    
    // Botones superiores para agregar bloques
    document.getElementById('add-work-block').addEventListener('click', function() {
        document.getElementById('block-type-work').checked = true;
        // No establecemos día específico para estos botones
        document.getElementById('block-day').value = '';
        blockModal.show();
    });
    
    document.getElementById('add-break-block').addEventListener('click', function() {
        document.getElementById('block-type-break').checked = true;
        document.getElementById('block-day').value = '';
        blockModal.show();
    });
    
    // Guardar bloque
    document.getElementById('save-block').addEventListener('click', function() {
        const day = document.getElementById('block-day').value;
        if (!day) {
            alert('Por favor, selecciona un día primero');
            return;
        }
        
        const type = document.querySelector('input[name="block-type"]:checked').value;
        const startTime = document.getElementById('start-time').value;
        const endTime = document.getElementById('end-time').value;
        const label = document.getElementById('block-label').value || (type === 'work' ? 'Trabajo' : 'Descanso');
        
        if (!startTime || !endTime) {
            alert('Por favor, completa las horas de inicio y fin');
            return;
        }
        
        // Validar que la hora de fin sea mayor que la de inicio
        if (startTime >= endTime) {
            alert('La hora de fin debe ser mayor que la hora de inicio');
            return;
        }
        
        // Agregar bloque a los datos
        const block = {
            type,
            startTime,
            endTime,
            label,
            id: Date.now()
        };
        
        scheduleData[day].blocks.push(block);
        updateDayCard(day);
        
        // Resetear formulario y cerrar modal
        document.getElementById('block-form').reset();
        blockModal.hide();
    });
    
    // Selección de plantilla
    document.getElementById('template-select').addEventListener('change', function() {
        const template = this.value;
        if (!template) return;
        
        const day = prompt("¿A qué día quieres aplicar esta plantilla? (lunes, martes, etc.)");
        if (!day || !scheduleData[day.toLowerCase()]) {
            alert('Día no válido');
            this.value = '';
            return;
        }
        
        const dayData = scheduleData[day.toLowerCase()];
        
        // Limpiar bloques existentes
        dayData.blocks = [];
        
        // Aplicar plantilla seleccionada
        switch(template) {
            case 'full-day':
                dayData.blocks = [
                    { type: 'work', startTime: '09:00', endTime: '13:00', label: 'Mañana', id: Date.now() + 1 },
                    { type: 'break', startTime: '13:00', endTime: '14:00', label: 'Almuerzo', id: Date.now() + 2 },
                    { type: 'work', startTime: '14:00', endTime: '18:00', label: 'Tarde', id: Date.now() + 3 }
                ];
                break;
            case 'morning':
                dayData.blocks = [
                    { type: 'work', startTime: '09:00', endTime: '13:00', label: 'Mañana', id: Date.now() + 1 }
                ];
                break;
            case 'afternoon':
                dayData.blocks = [
                    { type: 'work', startTime: '14:00', endTime: '18:00', label: 'Tarde', id: Date.now() + 1 }
                ];
                break;
            case 'pientiles':
                dayData.blocks = [
                    { type: 'work', startTime: '08:00', endTime: '11:00', label: 'Turno 1', id: Date.now() + 1 },
                    { type: 'break', startTime: '11:00', endTime: '12:00', label: 'Descanso', id: Date.now() + 2 },
                    { type: 'work', startTime: '12:00', endTime: '15:00', label: 'Turno 2', id: Date.now() + 3 },
                    { type: 'break', startTime: '15:00', endTime: '16:00', label: 'Descanso', id: Date.now() + 4 },
                    { type: 'work', startTime: '16:00', endTime: '19:00', label: 'Turno 3', id: Date.now() + 5 }
                ];
                break;
        }
        
        // Activar el día si no estaba activo
        if (!dayData.active) {
            document.getElementById(`toggle-${day.toLowerCase()}`).checked = true;
            dayData.active = true;
        }
        
        updateDayCard(day.toLowerCase());
        this.value = ''; // Resetear el selector
    });
    
    // Toggle para activar/desactivar día
    document.querySelectorAll('.day-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const day = this.id.replace('toggle-', '');
            scheduleData[day].active = this.checked;
            
            if (!this.checked) {
                scheduleData[day].blocks = [];
            }
            
            updateDayCard(day);
            updateGlobalStats();
        });
    });
    
    // Eliminar bloque
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-block') || e.target.closest('.delete-block')) {
            const button = e.target.classList.contains('delete-block') ? e.target : e.target.closest('.delete-block');
            const blockId = parseInt(button.dataset.id);
            
            for (const day in scheduleData) {
                const index = scheduleData[day].blocks.findIndex(b => b.id === blockId);
                if (index !== -1) {
                    scheduleData[day].blocks.splice(index, 1);
                    updateDayCard(day);
                    break;
                }
            }
        }
    });
    
    // Función para actualizar la tarjeta de un día
    function updateDayCard(day) {
        const dayData = scheduleData[day];
        const dayCard = document.querySelector(`.day-card[data-day="${day}"]`);
        const noBlocksMsg = dayCard.querySelector('.no-blocks-message');
        const timelineContainer = dayCard.querySelector('.timeline-container');
        const timelineItems = dayCard.querySelector('.timeline-items');
        const dayStats = dayCard.querySelector('.day-stats');
        
        // Actualizar estadísticas del día
        dayStats.textContent = `${dayData.blocks.length} ${dayData.blocks.length === 1 ? 'bloque' : 'bloques'}`;
        
        // Mostrar u ocultar mensaje de no bloques
        if (dayData.blocks.length === 0) {
            noBlocksMsg.classList.remove('d-none');
            timelineContainer.classList.add('d-none');
        } else {
            noBlocksMsg.classList.add('d-none');
            timelineContainer.classList.remove('d-none');
            
            // Ordenar bloques por hora de inicio
            dayData.blocks.sort((a, b) => a.startTime.localeCompare(b.startTime));
            
            // Generar timeline
            timelineItems.innerHTML = '';
            dayData.blocks.forEach(block => {
                const timelineItem = document.createElement('div');
                timelineItem.className = `timeline-item ${block.type} position-relative`;
                timelineItem.dataset.id = block.id;
                
                timelineItem.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span class="block-time">${block.startTime} - ${block.endTime}</span>
                        <span class="badge ${block.type === 'work' ? 'bg-primary' : 'bg-secondary'}">
                            ${block.type === 'work' ? 'Trabajo' : 'Descanso'}
                        </span>
                    </div>
                    <div class="block-label">${block.label}</div>
                    <div class="block-actions">
                        <button class="btn btn-sm btn-outline-danger delete-block" data-id="${block.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                
                timelineItems.appendChild(timelineItem);
            });
        }
        
        // Actualizar estadísticas globales
        updateGlobalStats();
        // Actualizar calendario
        updateCalendar();
    }
    
    // Guardar horario
    document.getElementById('save-schedule').addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/guardar-horarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(scheduleData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Horarios guardados correctamente.');
            } else {
                alert('No se pudo guardar. Revisa el servidor.');
            }
        })
        .catch(error => {
            console.error('Error al guardar:', error);
            alert('Error al guardar los horarios.');
        });
    });

    // Cambio de pestaña
    document.getElementById('calendar-tab').addEventListener('click', function() {
        if (!calendar) {
            initCalendar();
        }
    });
    
    // Inicializar estadísticas
    updateGlobalStats();
});
</script>
@endsection