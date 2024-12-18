document.addEventListener('DOMContentLoaded', function() {
    obtenerTipoDocumento();
});

// Obtener todos los tipos de documentos y cargarlos en la tabla
async function obtenerTipoDocumento() {
    try {
        const respuesta = await fetch('tipo_documento/obtenerTipoDocumento');
        const resultado = await respuesta.json();
        
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        const tiposDocumento = resultado.data;
        const tbody = document.getElementById('tipoDocumentoTableBody');

        tbody.innerHTML = ''; // Limpiar el contenido previo de la tabla

        // Añadir los tipos de documento a la tabla
        tiposDocumento.forEach(tipo => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${tipo.id_tipo_documento}</td>
                <td>${tipo.nombre}</td>
                <td>${tipo.descripcion || '<span class="text-muted">Sin descripción</span>'}</td>
                <td>${tipo.fecha_creacion ? new Date(tipo.fecha_creacion).toLocaleDateString() : ''}</td>
                <td>
                    <span class="badge ${tipo.esta_activo ? 'bg-success' : 'bg-danger'}">
                        ${tipo.esta_activo ? 'Activo' : 'Inactivo'}
                    </span>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary" onclick="mostrarDataEditar(${JSON.stringify(tipo).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarTipoDocumento(${tipo.id_tipo_documento})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        showAlert('error', 'Error al cargar los tipos de documento: ' + error.message);
    }
}

// Guardar un nuevo tipo de documento
async function saveTipoDocumento() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const estaActivo = document.getElementById('esta_activo').checked;

    // Validar los campos
    if (!name) {
        showAlert('error', 'El nombre del tipo de documento es obligatorio.');
        return;
    }

    try {
        const response = await fetch('tipo_documento/crearTipoDocumento', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nombre: name,
                descripcion: description,
                esta_activo: estaActivo
            })
        });

        const responseJson = await response.json();

        if (responseJson.status === 'error') {
            showAlert('error', responseJson.message);
            return;
        }

        showAlert('success', responseJson.message);

        // Recargar la lista de tipos de documento después de 1 segundo
        setTimeout(() => {
            obtenerTipoDocumento();
            const modal = bootstrap.Modal.getInstance(document.getElementById('tipoDocumentoModal'));
            modal.hide();
        }, 1000);

    } catch (error) {
        showAlert('error', 'Error al guardar el tipo de documento: ' + error);
    }
}
async function actualizarDocumento(){
    try {
        const formData = new FormData();
        const id = document.getElementById('tipoDocumentoId').value;
        const nombre = document.getElementById('name').value;
        const descripcion = document.getElementById('description').value;
        const estado = document.getElementById('esta_activo').value;
  
        formData.append('id', id);
        formData.append('name', nombre);
        formData.append('description', descripcion);
        formData.append('esta_activo', estado);

        const response = await fetch('tipo_documento/actualizarDocumento', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'error') {
            throw new Error(result.message);
        }
        // Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('tipoDocumentoModal'));
        modal.hide();

        // Mostrar mensaje de éxito
        showAlert('success', result.message);

        // Recargar la lista de productos
        obtenerTipoDocumento();

        // Resetear el formulario
        // resetForm();

        // console.log('ffffffffffffffffffffffffffff');
        
    } catch (error) {
        showAlert('error', error.message);
    }
}
async function eliminarTipoDocumento(id) {
    console.log("entraste a eliminar");
    try {
        if (!confirm('¿Está seguro de que desea eliminar?')) {
            return;
        }

        const respuesta = await fetch('tipo_documento/eliminar-documento', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_tipo_documento:id ,
            })
        });

        const resultado = await respuesta.json();

        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        showAlert('success', resultado.message);
        obtenerTipoDocumento();

    } catch (error) {
        showAlert('error', error.message);
    }

}
function mostrarDataEditar(tipo_documento) {
    console.log(tipo_documento);
    // Aquí se debe usar 'tipo_documento' en lugar de 'producto'
    document.getElementById('tipoDocumentoId').value = tipo_documento.id_tipo_documento;
    document.getElementById('name').value = tipo_documento.nombre;
    document.getElementById('description').value = tipo_documento.descripcion;
    document.getElementById('esta_activo').checked = tipo_documento.esta_activo; 

    document.getElementById('modalTitle').textContent = 'Editar Tipo de Documento';

    const modal = new bootstrap.Modal(document.getElementById('tipoDocumentoModal'));
    modal.show();
}


function almacenar(){
if (document.getElementById('tipoDocumentoId').value ) {
    //actualizar producto   
    actualizarDocumento();
}else{
    //crear prodcuto
    saveTipoDocumento();
}
}

function resetForm() {
    document.getElementById('tipoDocumentoId').value = '';
    document.getElementById('productForm').reset();
    document.getElementById('modalTitle').textContent = 'Nuevo Documento';
}
