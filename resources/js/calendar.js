document.addEventListener('DOMContentLoaded', function() {
    // Carga los módulos de FullCalendar dinámicamente
    Promise.all([
        import('@fullcalendar/core'),
        import('@fullcalendar/daygrid'),
        import('@fullcalendar/timegrid'),
        import('@fullcalendar/interaction'),
        import('@fullcalendar/core/locales/es')
    ]).then(([
        { Calendar },
        dayGridPlugin,
        timeGridPlugin,
        interactionPlugin,
        { esLocale }
    ]) => {
        const calendarEl = document.getElementById('calendar');
        
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin.default, timeGridPlugin.default, interactionPlugin.default],
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: esLocale,
            firstDay: 1, // Lunes como primer día
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',
            events: '/horarios/eventos',
            eventClick: function(info) {
                alert('Evento: ' + info.event.title);
            }
        });

        calendar.render();

        // Navegación
        document.getElementById('prev-btn').addEventListener('click', () => calendar.prev());
        document.getElementById('next-btn').addEventListener('click', () => calendar.next());
    }).catch(error => {
        console.error('Error al cargar FullCalendar:', error);
    });
});