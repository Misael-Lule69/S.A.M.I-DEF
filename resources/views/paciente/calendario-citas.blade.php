@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Agendar Nueva Cita</div>

                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form id="form-cita" method="POST" action="{{ route('paciente.agendar-cita') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="consultorio" class="form-label">Consultorio</label>
                            <select class="form-select" id="consultorio" name="consultorio" required>
                                <option value="">Seleccione un consultorio</option>
                                @foreach($consultorios as $consultorio)
                                <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha"
                                min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <select class="form-select" id="hora" name="hora" required disabled>
                                <option value="">Seleccione una hora</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de la consulta</label>
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                        </div>

                        <button type="submit" id="btn-submit" class="btn btn-primary">Agendar Cita</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const consultorioSelect = document.getElementById('consultorio');
        const fechaInput = document.getElementById('fecha');
        const horaSelect = document.getElementById('hora');
        const btnSubmit = document.getElementById('btn-submit');
        const formCita = document.getElementById('form-cita');

        // Función para cargar horarios
        async function cargarHorarios() {
            const consultorioSelect = document.getElementById('consultorio');
            const fechaInput = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');
            const btnSubmit = document.getElementById('btn-submit');

            const fecha = fechaInput.value;
            const consultorio = consultorioSelect.value;

            // Validar selección previa
            if (!fecha || !consultorio) {
                horaSelect.innerHTML = '<option value="">Primero seleccione consultorio y fecha</option>';
                horaSelect.disabled = true;
                btnSubmit.disabled = true;
                return;
            }

            // Mostrar estado de carga
            horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';
            horaSelect.disabled = true;
            btnSubmit.disabled = true;

            try {
                const response = await fetch(`/paciente/horarios-disponibles?fecha=${fecha}&consultorio=${consultorio}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Error en la respuesta del servidor');
                }

                console.log('Respuesta del servidor:', data);

                // Limpiar select
                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';

                if (!data.success || !data.horarios || data.horarios.length === 0) {
                    const mensaje = data.message || 'No hay horarios disponibles';
                    horaSelect.innerHTML += `<option value="" disabled>${mensaje}</option>`;
                    return;
                }

                // Llenar con horarios disponibles
                data.horarios.forEach(horario => {
                    const option = document.createElement('option');
                    option.value = horario.start;

                    const startTime = formatHoraAMPM(horario.start);
                    const endTime = formatHoraAMPM(horario.end);

                    option.textContent = `${startTime} - ${endTime}`;
                    if (horario.label) {
                        option.textContent += ` (${horario.label})`;
                    }

                    horaSelect.appendChild(option);
                });

                horaSelect.disabled = false;
                btnSubmit.disabled = false;

            } catch (error) {
                console.error('Error al cargar horarios:', error);
                horaSelect.innerHTML = `<option value="">Error: ${error.message}</option>`;
                horaSelect.disabled = true;
                btnSubmit.disabled = true;
            }
        }

        function formatHoraAMPM(hora24) {
            const [hours, minutes] = hora24.split(':');
            const period = hours >= 12 ? 'PM' : 'AM';
            const hours12 = hours % 12 || 12;
            return `${hours12}:${minutes} ${period}`;
        }

        // Función para formatear hora a AM/PM
        function formatHoraAMPM(hora24) {
            const [hours, minutes] = hora24.split(':');
            const period = hours >= 12 ? 'PM' : 'AM';
            const hours12 = hours % 12 || 12;
            return `${hours12}:${minutes} ${period}`;
        }

        // Event listeners
        fechaInput.addEventListener('change', cargarHorarios);
        consultorioSelect.addEventListener('change', cargarHorarios);

        // Manejar envío del formulario
        formCita.addEventListener('submit', function(e) {
            if (!horaSelect.value || horaSelect.disabled) {
                e.preventDefault();
                alert('Por favor seleccione un horario válido');
                return;
            }

            // Mostrar indicador de carga
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agendando...';
        });
    });
</script>
@endsection