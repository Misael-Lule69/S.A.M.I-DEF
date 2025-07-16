@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-users"></i> Gestión de Pacientes y Expedientes
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('expedientes.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="busqueda" class="form-control" 
                                           placeholder="Buscar por nombre, apellido o ID del paciente..." 
                                           value="{{ $busqueda ?? '' }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Tabla de pacientes -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Registro</th>
                                    <th>Expedientes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
    @forelse($pacientes as $paciente)
        <tr>
            <td data-label="ID">{{ $paciente->id }}</td>
            <td data-label="Nombre Completo">
                <strong>{{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}</strong>
            </td>
            <td data-label="Teléfono">{{ $paciente->telefono }}</td>
            <td data-label="Fecha Registro">{{ $paciente->created_at ? $paciente->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
            <td data-label="Expedientes">
                @php
                    $expedientesCount = \App\Models\ExpedienteClinico::whereHas('cita', function($query) use ($paciente) {
                        $query->where('id_paciente', $paciente->id);
                    })->count();
                    $ultimoExpediente = \App\Models\ExpedienteClinico::whereHas('cita', function($query) use ($paciente) {
                        $query->where('id_paciente', $paciente->id);
                    })->orderBy('fecha_elaboracion', 'desc')->first();
                @endphp
                <span class="badge bg-{{ $expedientesCount > 0 ? 'success' : 'secondary' }}">
                    {{ $expedientesCount }} expediente{{ $expedientesCount != 1 ? 's' : '' }}
                </span>
            </td>
            <td data-label="Acciones">
                <div class="btn-group" role="group">
                    <a href="{{ route('expedientes.expedientes-paciente', $paciente->id) }}" 
                       class="btn btn-sm btn-info" title="Ver Expedientes">
                        <i class="fas fa-folder-open"></i> Ver Expedientes
                    </a>
                    @if($expedientesCount == 0)
                        <a href="{{ route('expedientes.create') }}?paciente_id={{ $paciente->id }}" 
                           class="btn btn-sm btn-success" title="Agregar Expediente">
                            <i class="fas fa-plus-circle"></i> Agregar Expediente
                        </a>
                    @else
                        <a href="{{ route('expedientes.edit', $ultimoExpediente->id) }}" 
                           class="btn btn-sm btn-warning" title="Actualizar Expediente">
                            <i class="fas fa-edit"></i> Actualizar Expediente
                        </a>
                    @endif
                    <button type="button" class="btn btn-sm btn-warning" 
                            onclick="editarPaciente({{ $paciente->id }})" title="Editar Paciente">
                        <i class="fas fa-user-edit"></i> Editar
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="eliminarPaciente({{ $paciente->id }}, '{{ $paciente->nombre }}')" title="Eliminar Paciente">
                        <i class="fas fa-user-times"></i> Eliminar
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    No se encontraron pacientes.
                    @if($busqueda)
                        <br>Intente con otros términos de búsqueda.
                    @endif
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($pacientes->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $pacientes->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar paciente -->
<div class="modal fade" id="editarPacienteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editarPacienteForm">
                    <div class="mb-3">
                        <label for="edit_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="edit_apellido_paterno" name="apellido_paterno" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="edit_apellido_materno" name="apellido_materno">
                    </div>
                    <div class="mb-3">
                        <label for="edit_telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="edit_telefono" name="telefono" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarPaciente" onclick="guardarPaciente()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 10px;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .btn-group .btn {
        margin-right: 2px;
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }

    .table th {
        white-space: nowrap;
    }

    .badge {
        font-size: 0.8em;
    }

    .btn i {
        margin-right: 3px;
    }

    .alert {
        border-radius: 8px;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #6c757d;
    }

    .input-group .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .input-group .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
    }

    .input-group .btn-primary:hover {
        background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        border-color: #5a6fd8;
    }

    /* Vista móvil */
    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }

        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        td::before {
        position: absolute;
        top: 6px;
        left: 6px;
        width: 40%; /* Menos ancho para la etiqueta */
        padding-right: 10px;
        white-space: nowrap;
        content: attr(data-label);
        font-weight: bold;
        text-align: left;
        color: white;
        background-color: #212529;
        padding: 4px 6px;
        border-radius: 5px;
        font-size: 12px;
    }

    td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 60%; /* Aumentamos este valor */
        padding-right: 10px;
        text-align: right;
        font-size: 14px;
        word-break: break-word;
        white-space: normal;
    }

    td[data-label="Nombre Completo"] {
        font-weight: bold;
        text-align: left;
        padding-left: 60%;
    }

        td[data-label="Acciones"] {
            padding-left: 10px;
            padding-right: 10px;
            text-align: center;
        }

        td[data-label="Acciones"]::before {
            position: relative;
            display: block;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
            color: #fff;
            background-color: #212529;
            padding: 6px;
            border-radius: 8px;
            font-size: 13px;
            width: 240px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        td[data-label="Acciones"] .btn-group {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        td[data-label="Acciones"] .btn-group .btn {
            width: 100%;
            margin-bottom: 6px;
            font-size: 13px;
        }

        td[data-label="Acciones"] .btn-group .btn:last-child {
            margin-bottom: 0;
        }
    }
</style>


<script>
let pacienteActualId = null;

function editarPaciente(id) {
    pacienteActualId = id;
    
    // Cargar datos del paciente
    fetch(`/expedientes/paciente/${id}`)
        .then(response => response.json())
        .then(paciente => {
            document.getElementById('edit_nombre').value = paciente.nombre;
            document.getElementById('edit_apellido_paterno').value = paciente.apellido_paterno;
            document.getElementById('edit_apellido_materno').value = paciente.apellido_materno;
            document.getElementById('edit_telefono').value = paciente.telefono;
            
            const modal = new bootstrap.Modal(document.getElementById('editarPacienteModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar los datos del paciente');
        });
}

function guardarPaciente() {
    if (!pacienteActualId) return;
    
    // Obtener los valores del formulario
    const formData = {
        nombre: document.getElementById('edit_nombre').value.trim(),
        apellido_paterno: document.getElementById('edit_apellido_paterno').value.trim(),
        apellido_materno: document.getElementById('edit_apellido_materno').value.trim(),
        telefono: document.getElementById('edit_telefono').value.trim()
    };
    
    // Validación básica en el frontend
    if (!formData.nombre) {
        alert('El nombre es requerido');
        document.getElementById('edit_nombre').focus();
        return;
    }
    
    if (!formData.apellido_paterno) {
        alert('El apellido paterno es requerido');
        document.getElementById('edit_apellido_paterno').focus();
        return;
    }
    
    if (!formData.telefono) {
        alert('El teléfono es requerido');
        document.getElementById('edit_telefono').focus();
        return;
    }
    
    // Mostrar estado de carga
    const btnGuardar = document.getElementById('btnGuardarPaciente');
    const originalText = btnGuardar.innerHTML;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    btnGuardar.disabled = true;
    
    fetch(`/expedientes/pacientes/${pacienteActualId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        // Restaurar botón
        btnGuardar.innerHTML = originalText;
        btnGuardar.disabled = false;
        
        if (data.success) {
            alert('Paciente actualizado correctamente');
            location.reload();
        } else {
            if (data.errors) {
                // Mostrar errores de validación específicos
                let errorMessage = 'Errores de validación:\n';
                Object.keys(data.errors).forEach(field => {
                    errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
                });
                alert(errorMessage);
            } else {
                alert(data.message || 'Error al actualizar el paciente');
            }
        }
    })
    .catch(error => {
        // Restaurar botón en caso de error
        btnGuardar.innerHTML = originalText;
        btnGuardar.disabled = false;
        
        console.error('Error:', error);
        alert('Error de conexión al actualizar el paciente');
    });
}

function eliminarPaciente(id, nombre) {
    if (confirm(`¿Está seguro de que desea eliminar al paciente "${nombre}"? Esta acción no se puede deshacer.`)) {
        fetch(`/expedientes/pacientes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Paciente eliminado correctamente');
                location.reload();
            } else {
                alert(data.message || 'Error al eliminar el paciente');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión al eliminar el paciente');
        });
    }
}
</script>
@endsection 