<!-- Listado de Tipos de Documento -->
<div class="row mb-4">
    <div class="col">
        <h2 class="text-danger">Listado de Tipos de Documento</h2>
    </div>
    <div class="col text-end">
        <a href="<?= BASE_URL ?>/reportetd/pdf" class="btn btn-danger shadow">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
        <a href="<?= BASE_URL ?>/reporteDoc/excel" class="btn btn-success shadow">
            <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
        <button type="button" class="btn btn-warning shadow" data-bs-toggle="modal" data-bs-target="#tipoDocumentoModal">
            <i class="fas fa-plus"></i> Registrar Tipo de Documento
        </button>
    </div>
</div>

<!-- Modal para Crear/Editar Tipo de Documento -->
<div class="modal fade" id="tipoDocumentoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalTitle">Nuevo Tipo de Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="tipoDocumentoForm">
                    <input type="hidden" id="tipoDocumentoId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tipo de Documento</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Titular</label>
                        <input type="text" class="form-control" id="description" required>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="esta_activo">
                        <label class="form-check-label" for="esta_activo">¿Está activo?</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-success" onclick="almacenar()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Tipos de Documento -->
<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="custom-header">
            <tr>
                <th>ID</th>
                <th>Tipo de Documento</th>
                <th>Titular</th>
                <th>Fecha de Creación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tipoDocumentoTableBody" class="custom-tbody">
            <!-- Los tipos de documentos se cargarán aquí dinámicamente -->
        </tbody>
    </table>
</div>

<!-- CSS Personalizado -->
<style>
    .custom-header th {
        background-color: #dc3545;  /* Rojo vibrante para el encabezado */
        color: white;
        font-weight: bold;
        border: 1px solid #ffffff;
    }

    /* Colores de la tabla */
    .custom-tbody tr {
        background-color: #f8f9fa;  /* Fondo suave para las filas */
    }

    .custom-tbody tr:nth-child(even) {
        background-color: #f1f1f1;  /* Fondo alternado en gris suave */
    }

    .custom-tbody tr:hover {
        background-color: #d3e0ea;  /* Fondo azul claro cuando pasa el mouse */
    }

    .custom-tbody .activo {
        background-color: #28a745;  /* Verde para estado activo */
        color: white;
    }

    .custom-tbody .inactivo {
        background-color: #6c757d;  /* Gris para estado inactivo */
        color: white;
    }

    /* Colores para botones */
    .btn {
        transition: transform 0.2s ease-in-out;
    }

    .btn:hover {
        transform: translateY(-5px);  /* Hover para los botones */
    }

    .btn-danger {
        background-color: #dc3545;
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-warning {
        background-color: #ffc107;
    }

    .btn-outline-dark {
        border-color: #343a40;
    }

    /* Estilo del modal */
    .modal-header {
        background-color: #343a40;  /* Fondo oscuro para el encabezado del modal */
    }
</style>
