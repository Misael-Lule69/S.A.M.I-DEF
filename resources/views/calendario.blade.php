<!DOCTYPE html>
<html>
<head>
    <title>Calendario de Horarios</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #calendar {
            width: 100%;
            height: 600px;
            margin: 20px auto;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .fc-event-work {
            background-color: #0d6efd;
            border-left: 3px solid #0b5ed7;
        }
        
        .fc-event-break {
            background-color: #6c757d;
            border-left: 3px solid #5c636a;
        }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Mi Calendario de Horarios</h1>
        <div id="calendar"></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuración de headers para AJAX
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        };

        // Obtener los datos del horario desde el backend
        fetch("/schedules", {
            headers: headers,
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(schedules => {
            if (schedules.error) {
                throw new Error(schedules.error);
            }

            // Mapeo de días a números que usa FullCalendar
            const daysMap = {
                'lunes': 1,
                'martes': 2,
                'miércoles': 3,
                'jueves': 4,
                'viernes': 5,
                'sábado': 6,
                'domingo': 0
            };
            
            // Generar eventos para el calendario
            const events = [];
            
            schedules.forEach(schedule => {
                if (schedule.active == 1 && schedule.blocks) {
                    try {
                        // Parsear el JSON de blocks si viene como string
                        const blocks = typeof schedule.blocks === 'string' ? 
                            JSON.parse(schedule.blocks) : 
                            schedule.blocks;
                        
                        if (Array.isArray(blocks)) {
                            blocks.forEach(block => {
                                const startTime = block.start || block.startTime || '00:00';
                                const endTime = block.end || block.endTime || '23:59';
                                
                                events.push({
                                    title: block.label || (block.type === 'work' ? 'Trabajo' : 'Descanso'),
                                    startTime: startTime,
                                    endTime: endTime,
                                    daysOfWeek: [daysMap[schedule.day]],
                                    backgroundColor: block.type === 'work' ? '#0d6efd' : '#6c757d',
                                    borderColor: block.type === 'work' ? '#0b5ed7' : '#5c636a',
                                    extendedProps: {
                                        type: block.type,
                                        scheduleId: schedule.id
                                    }
                                });
                            });
                        }
                    } catch (e) {
                        console.error('Error procesando bloques para', schedule.day, e);
                    }
                }
            });
            
            // Inicializar el calendario
            initCalendar(events);
        })
        .catch(error => {
            console.error('Error al cargar horarios:', error);
            // Mostrar calendario vacío con mensaje
            initCalendar([]);
            
            // Mostrar mensaje de error más detallado
            const errorMsg = error.message || 'Error al cargar los horarios.';
            alert(`${errorMsg}\n\nPor favor verifica tu conexión o contacta al administrador.`);
        });

        function initCalendar(events) {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                allDaySlot: false,
                slotMinTime: '00:00:00',
                slotMaxTime: '24:00:00',
                slotDuration: '01:00:00',
                firstDay: 1, // Lunes como primer día
                events: events,
                eventContent: function(arg) {
                    return {
                        html: `<div class="fc-event-title">${arg.event.title}</div>
                               <div class="fc-event-time">${arg.timeText}</div>`
                    };
                },
                eventDidMount: function(arg) {
                    arg.el.classList.add(`fc-event-${arg.event.extendedProps.type}`);
                }
            });
            
            calendar.render();
        }
    });
    </script>
</body>
</html>