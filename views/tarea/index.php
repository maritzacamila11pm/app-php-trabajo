<!-- Listado de Tareas -->
<div class="row mb-4">
    <div class="col">
        <h2 class="text-primary">Listado de Tareas</h2>
    </div>
    <div class="col text-end">
        <a href="<?= BASE_URL ?>/reporteTarea/pdf" class="btn btn-danger shadow">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
        <a href="<?= BASE_URL ?>/reporteTarea/excel" class="btn btn-success shadow">
            <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
        <button type="button" class="btn btn-warning shadow" data-bs-toggle="modal" data-bs-target="#tareaModal">
            <i class="fas fa-plus"></i> Nueva Tarea
        </button>
    </div>
</div>

<!-- Modal para Crear/Editar Tarea -->
<div class="modal fade" id="tareaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tareaForm">
                    <input type="hidden" id="tareaId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tarea" class="form-label">Tarea</label>
                            <input type="text" class="form-control" id="tarea" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="equipo" class="form-label">Equipo</label>
                            <input type="text" class="form-control" id="equipo" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" class="form-control" id="responsable">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_limite" class="form-label">Fecha Límite</label>
                            <input type="datetime-local" class="form-control" id="fecha_limite">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fase" class="form-label">Fase</label>
                            <select class="form-select" id="fase">
                                <option value="Inicio">Inicio</option>
                                <option value="Desarrollo">Desarrollo</option>
                                <option value="Cierre">Cierre</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success" onclick="guardarTarea()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Tareas -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tarea</th>
                <th>Equipo</th>
                <th>Responsable</th>
                <th>Fase</th>
                <th>Fecha Límite</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tareaTableBody">
            <!-- Las tareas se cargarán aquí dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Alert Container -->
<div id="alertContainer"></div>

<!-- CSS Personalizado -->
<style>
    /* Estilo para la tabla */
    .table-dark th {
        background-color:rgb(155, 64, 241);  /* Fondo oscuro para encabezados */
        color: white;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;  /* Fondo alternado para filas */
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;  /* Fondo al pasar el mouse sobre las filas */
    }

    /* Estilo para los botones */
    .btn {
        transition: transform 0.3s ease-in-out;
    }
 /* Efecto hover para botones */
    .btn:hover {
        transform: translateY(-5px); 
    }

    .btn-secondary {
        background-color: #6c757d;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn-outline-primary {
        border-color: #007bff;
    }

    .btn-success {
        background-color: #28a745;
    }

    /* Estilo para el modal */
    .modal-header {
        background-color:rgb(232, 179, 250);  /* Fondo azul para el encabezado del modal */
    }

    /* Estilo de alerta */
    #alertContainer {
        margin-top: 20px;
    }
</style>
