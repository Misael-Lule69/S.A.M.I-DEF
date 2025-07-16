@extends('layouts.app')

@section('content')
<!-- FLATPICKR -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<!-- TOM SELECT -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<style>
    @media (max-width: 576px) {
        .form-label {
            font-size: 0.9rem;
        }

        .form-select,
        .form-control,
        .flatpickr-calendar {
            max-width: 100% !important;
            width: 100% !important;
            box-sizing: border-box;
            font-size: 0.9rem;
        }

        .flatpickr-calendar {
            left: 0 !important;
            right: 0 !important;
            margin: 0 auto;
        }

        .form-control[readonly] {
            background-color: #fff;
        }
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8">
            <div class="card shadow">
                <div class="card-header text-center">Agendar Nueva Cita</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="form-cita" method="POST" action="{{ route('paciente.agendar-cita') }}">
                        @csrf

                        <!-- CONSULTORIO -->
                        <div class="mb-3">
                            <label for="consultorio" class="form-label">Consultorio</label>
                            <select id="consultorio" name="consultorio" required>
                                <option value="">Seleccione un consultorio</option>
                                @foreach($consultorios as $consultorio)
                                <option value="{{ $consultorio->id }}">{{ $consultorio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- FECHA -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="text" id="fecha" name="fecha"
                                class="form-control w-100 border-2 shadow-sm"
                                style="border-color: #6C5CE7; color: #6C5CE7;" required>
                        </div>

                        <!-- HORA -->
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <select id="hora" name="hora" required disabled>
                                <option value="">Seleccione una hora</option>
                            </select>
                        </div>

                        <!-- MOTIVO -->
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de la consulta</label>
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                        </div>

                        <!-- BOTÓN -->
                        <div class="text-center">
                            <button type="submit" id="btn-submit" class="btn btn-primary px-4">
                                Agendar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Flatpickr para fecha
        flatpickr("#fecha", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: "es"
        });

        // Tom Select para consultorio
        const consultorioTom = new TomSelect('#consultorio', {
            placeholder: 'Seleccione un consultorio',
            allowEmptyOption: true
        });

        // Variable para hora
        let horaTom = null;

        const consultorioSelect = document.getElementById('consultorio');
        const fechaInput = document.getElementById('fecha');
        const horaSelect = document.getElementById('hora');
        const btnSubmit = document.getElementById('btn-submit');
        const formCita = document.getElementById('form-cita');

        async function cargarHorarios() {
            const fecha = fechaInput.value;
            const consultorio = consultorioSelect.value;

            if (!fecha || !consultorio) {
                horaSelect.innerHTML = '<option value="">Primero seleccione consultorio y fecha</option>';
                horaSelect.disabled = true;
                btnSubmit.disabled = true;
                if (horaTom) horaTom.destroy(); // Eliminar TomSelect anterior
                return;
            }

            horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';
            horaSelect.disabled = true;
            btnSubmit.disabled = true;
            if (horaTom) horaTom.destroy(); // Reiniciar

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

                horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';

                if (!data.success || !data.horarios || data.horarios.length === 0) {
                    horaSelect.innerHTML += `<option value="" disabled>${data.message || 'No hay horarios disponibles'}</option>`;
                    return;
                }

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

                // Inicializar Tom Select para hora
                horaTom = new TomSelect('#hora', {
                    placeholder: 'Seleccione una hora',
                    allowEmptyOption: true
                });

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

        fechaInput.addEventListener('change', cargarHorarios);
        consultorioSelect.addEventListener('change', cargarHorarios);

        formCita.addEventListener('submit', function (e) {
            if (!horaSelect.value || horaSelect.disabled) {
                e.preventDefault();
                alert('Por favor seleccione un horario válido');
                return;
            }

            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agendando...';
        });
    });
</script>
@endsection

