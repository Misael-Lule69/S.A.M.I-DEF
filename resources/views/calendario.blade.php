<!-- calendario.blade.php -->
<div class="calendar-container">
    <div class="calendar-header">
        <h4 class="calendar-title">Calendario de Citas.</h4>
        <div class="calendar-actions">
            <button class="btn btn-sm btn-outline-primary prev-month"><i class="bi bi-chevron-left"></i></button>
            <span class="current-month" id="currentMonth">Junio 2023</span>
            <button class="btn btn-sm btn-outline-primary next-month"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>
    
    <div class="calendar-grid">
        <!-- Días de la semana -->
        <div class="calendar-weekdays">
            <div class="weekday">Dom</div>
            <div class="weekday">Lun</div>
            <div class="weekday">Mar</div>
            <div class="weekday">Mié</div>
            <div class="weekday">Jue</div>
            <div class="weekday">Vie</div>
            <div class="weekday">Sáb</div>
        </div>
        
        <!-- Días del mes -->
        <div class="calendar-days" id="calendarDays">
            <!-- Los días se generarán dinámicamente con JavaScript -->
        </div>
    </div>
</div>

<style>
/* Estilos específicos para el calendario */
.calendar-container {
    margin-top: 2rem;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    overflow: hidden;
}

.calendar-header {
    display: flex;
    flex-direction: column;
    padding: 1rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.calendar-title {
    margin: 0;
    color: #6C5CE7;
    font-weight: 600;
}

.calendar-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-top: 0.5rem;
}

.current-month {
    font-weight: 500;
    min-width: 120px;
    text-align: center;
}

.calendar-grid {
    display: flex;
    flex-direction: column;
}

.calendar-weekdays {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background-color: #6C5CE7;
    color: white;
    text-align: center;
    font-weight: 500;
    padding: 0.5rem 0;
}

.weekday {
    padding: 0.25rem;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #dee2e6;
}

.calendar-day {
    min-height: 100px;
    background: white;
    padding: 0.25rem;
    position: relative;
}

.calendar-day.empty {
    background: #f8f9fa;
}

.calendar-day.today {
    background-color: #e6f7ff;
}

.day-number {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.calendar-event {
    font-size: 0.75rem;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
    color: white;
    margin-bottom: 0.125rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
}

/* Estilos responsivos */
@media (max-width: 768px) {
    .calendar-day {
        min-height: 80px;
    }
    
    .weekday, .day-number {
        font-size: 0.8rem;
    }
    
    .calendar-event {
        font-size: 0.65rem;
        padding: 0.1rem 0.2rem;
    }
}

@media (max-width: 576px) {
    .calendar-header {
        flex-direction: column;
        align-items: center;
    }
    
    .calendar-title {
        margin-bottom: 0.5rem;
    }
    
    .calendar-day {
        min-height: 60px;
    }
    
    .day-number {
        font-size: 0.7rem;
    }
    
    .calendar-event {
        display: block; /* Mostramos los eventos */
        font-size: 0.6rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables para controlar el mes actual
    let currentDate = new Date();
    
    // Función para renderizar el calendario
    function renderCalendar() {
        const calendarDays = document.getElementById('calendarDays');
        const currentMonthElement = document.getElementById('currentMonth');
        
        // Limpiar el calendario
        calendarDays.innerHTML = '';
        
        // Establecer el mes y año actual
        const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
                          "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        currentMonthElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        
        // Obtener primer día del mes y último día del mes
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
        
        // Obtener el día de la semana del primer día (0-6 donde 0 es domingo)
        const firstDayOfWeek = firstDay.getDay();
        
        // Obtener el día actual para resaltarlo
        const today = new Date();
        const isCurrentMonth = currentDate.getMonth() === today.getMonth() && 
                              currentDate.getFullYear() === today.getFullYear();
        
        // Añadir días vacíos para alinear el primer día
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendarDays.appendChild(emptyDay);
        }
        
        // Añadir los días del mes
        for (let i = 1; i <= lastDay.getDate(); i++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            
            // Resaltar el día actual
            if (isCurrentMonth && i === today.getDate()) {
                dayElement.classList.add('today');
            }
            
            // Número del día
            const dayNumber = document.createElement('div');
            dayNumber.className = 'day-number';
            dayNumber.textContent = i;
            dayElement.appendChild(dayNumber);
            
            // Aquí puedes añadir eventos (simulamos algunos eventos)
            if (i === 1) {
                const event = document.createElement('div');
                event.className = 'calendar-event';
                event.style.backgroundColor = '#6C5CE7';
                event.textContent = '09:00';
                dayElement.appendChild(event);
            }
            
            calendarDays.appendChild(dayElement);
        }
    }
    
    // Botones de navegación
    document.querySelector('.prev-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    
    document.querySelector('.next-month').addEventListener('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Renderizar el calendario inicial
    renderCalendar();
});
</script>