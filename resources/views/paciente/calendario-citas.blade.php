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
                            <select class="form-select @error('consultorio') is-invalid @enderror" id="consultorio" name="consultorio" required>
                                <option value="">Seleccione un consultorio</option>
                                @foreach($consultorios as $consultorio)
                                    <option value="{{ $consultorio->id }}" {{ old('consultorio') == $consultorio->id ? 'selected' : '' }}>
                                        {{ $consultorio->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('consultorio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha" name="fecha" 
                                   min="{{ date('Y-m-d') }}" 
                                   value="{{ old('fecha') }}" required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <select class="form-select @error('hora') is-invalid @enderror" 
                                    id="hora" name="hora" required disabled>
                                <option value="">Primero seleccione fecha y consultorio</option>
                            </select>
                            @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de la consulta</label>
                            <textarea class="form-control @error('motivo') is-invalid @enderror" 
                                      id="motivo" name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                            @error('motivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary" id="btn-submit">
                            Agendar Cita
                        </button>
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
    
    // Función para cargar horarios
    async function cargarHorarios() {
        // Validar selección previa
        if (!consultorioSelect.value || !fechaInput.value) {
            horaSelect.innerHTML = '<option value="">Primero seleccione consultorio y fecha</option>';
            horaSelect.disabled = true;
            return;
        }
        
        // Mostrar estado de carga
        horaSelect.innerHTML = '<option value="">Cargando horarios...</option>';
        horaSelect.disabled = true;
        
        try {
            // Realizar petición al servidor
            const response = await fetch(`/paciente/horarios-disponibles?fecha=${fechaInput.value}&consultorio=${consultorioSelect.value}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            
            const data = await response.json();
            
            // Limpiar select
            horaSelect.innerHTML = '<option value="">Seleccione una hora</option>';
            
            // Manejar respuesta
            if (!data.success || !data.horarios || data.horarios.length === 0) {
                horaSelect.innerHTML += `<option value="" disabled>${data.message || 'No hay horarios disponibles'}</option>`;
                horaSelect.disabled = true;
                return;
            }
            
            // Llenar con horarios disponibles
            data.horarios.forEach(horario => {
                const option = document.createElement('option');
                option.value = horario.start;
                
                // Formatear horas para mostrar (09:00 AM - 09:30 AM)
                const startTime = formatHoraAMPM(horario.start);
                const endTime = formatHoraAMPM(horario.end);
                
                option.textContent = `${startTime} - ${endTime} (${horario.label})`;
                horaSelect.appendChild(option);
            });
            
            horaSelect.disabled = false;
            
        } catch (error) {
            console.error('Error al cargar horarios:', error);
            horaSelect.innerHTML = '<option value="">Error al cargar horarios. Intente nuevamente.</option>';
            horaSelect.disabled = true;
        }
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
    document.getElementById('form-cita').addEventListener('submit', function(e) {
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