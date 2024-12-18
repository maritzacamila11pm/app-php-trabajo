// document.addEventListener('DOMContentLoaded', function() {
//     obtenerTareas();
// });

// async function obtenerTareas() {
//     try {
//         const respuesta = await fetch('tareas/obtener-todo');
//         const resultado = await respuesta.json();
        
//         if (resultado.status === 'error') {
//             throw new Error(resultado.message);
//         }

//         const tareas = resultado.data;
//         console.log(tareas);

//         const tbody = document.getElementById('tasksTableBody');
//         tbody.innerHTML = '';
        
//         tareas.forEach(tarea => {
//             const tr = document.createElement('tr');
//             tr.innerHTML = `
//                 <td>${tarea.id_tareas}</td>
//                 <td>${tarea.equipo}</td>
//                 <td>${tarea.responsable || '<span class="text-muted">Sin asignar</span>'}</td>
//                 <td>${tarea.tarea}</td>
//                 <td>${tarea.descripcion || '<span class="text-muted">Sin descripción</span>'}</td>
//                 <td>${new Date(tarea.fecha_limite).toLocaleString()}</td>
//                 <td>
//                     <span class="badge 
//                         ${tarea.fase === 'Inicio' ? 'bg-warning' : 
//                           tarea.fase === 'Desarrollo' ? 'bg-info' : 
//                           'bg-success'}">
//                         ${tarea.fase}
//                     </span>
//                 </td>
//                 <td>
//                     <div class="btn-group" role="group">
//                         <button class="btn btn-sm btn-primary" onclick="mostrarDataEditar(${JSON.stringify(tarea).replace(/"/g, '&quot;')})">
//                             <i class="fas fa-edit"></i>
//                         </button>
//                         <button class="btn btn-sm btn-danger" onclick="eliminarTarea(${tarea.id_tareas})">
//                             <i class="fas fa-trash"></i>
//                         </button>
//                     </div>
//                 </td>
//             `;
//             tbody.appendChild(tr);
//         });
//     } catch (error) {
//         showAlert('error', 'Error al cargar las tareas: ' + error.message);
//     }
// }

// function showAlert(type, message) {
//     const alertContainer = document.getElementById('alertContainer');
//     const alertDiv = document.createElement('div');
//     alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
//     alertDiv.innerHTML = `
//         ${message}
//         <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
//     `;
//     alertContainer.appendChild(alertDiv);

//     setTimeout(() => {
//         alertDiv.remove();
//     }, 5000);
// }

// async function guardarTarea() {
//     try {
//         const formData = new FormData();
//         const equipo = document.getElementById('team').value;
//         const responsable = document.getElementById('responsible').value;
//         const tarea = document.getElementById('task').value;
//         const descripcion = document.getElementById('description').value;
//         const fechaLimite = document.getElementById('deadline').value;
//         const fase = document.getElementById('phase').value;

//         formData.append('equipo', equipo);
//         formData.append('responsable', responsable);
//         formData.append('tarea', tarea);
//         formData.append('descripcion', descripcion);
//         formData.append('fecha_limite', fechaLimite);
//         formData.append('fase', fase);

//         const response = await fetch('tareas/guardar-tarea', {
//             method: 'POST',
//             body: formData
//         });

//         const result = await response.json();

//         if (result.status === 'error') {
//             throw new Error(result.message);
//         }

        

//         showAlert('success', result.message);
//         obtenerTareas();
//         resetForm();

//     } catch (error) {
//         showAlert('error', error.message);
//     }
// }

// async function actualizarTarea() {
//     try {
//         const formData = new FormData();
//         const id = document.getElementById('taskId').value;
//         const equipo = document.getElementById('team').value;
//         const responsable = document.getElementById('responsible').value;
//         const tarea = document.getElementById('task').value;
//         const descripcion = document.getElementById('description').value;
//         const fechaLimite = document.getElementById('deadline').value;
//         const fase = document.getElementById('phase').value;

//         formData.append('id', id);
//         formData.append('equipo', equipo);
//         formData.append('responsable', responsable);
//         formData.append('tarea', tarea);
//         formData.append('descripcion', descripcion);
//         formData.append('fecha_limite', fechaLimite);
//         formData.append('fase', fase);

//         const response = await fetch('tareas/actualizar-tarea', {
//             method: 'POST',
//             body: formData
//         });

//         const result = await response.json();

//         if (result.status === 'error') {
//             throw new Error(result.message);
//         }

//         const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
//         modal.hide();

//         showAlert('success', result.message);
//         obtenerTareas();
//         resetForm();

//     } catch (error) {
//         showAlert('error', error.message);
//     }
// }

// async function eliminarTarea(id) {
//     try {
//         if (!confirm('¿Está seguro de que desea eliminar esta tarea?')) {
//             return;
//         }

//         const respuesta = await fetch('tareas/eliminar-tarea', {
//             method: 'DELETE',
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({
//                 id_tareas: id,
//             })
//         });

//         const resultado = await respuesta.json();

//         if (resultado.status === 'error') {
//             throw new Error(resultado.message);
//         }

//         showAlert('success', resultado.message);
//         obtenerTareas();

//     } catch (error) {
//         showAlert('error', error.message);
//     }
// }

// function mostrarDataEditar(tarea) {
//     document.getElementById('taskId').value = tarea.id_tareas;
//     document.getElementById('team').value = tarea.equipo;
//     document.getElementById('responsible').value = tarea.responsable;
//     document.getElementById('task').value = tarea.tarea;
//     document.getElementById('description').value = tarea.descripcion;
//     document.getElementById('deadline').value = new Date(tarea.fecha_limite).toISOString().slice(0, 16);
//     document.getElementById('phase').value = tarea.fase;

//     document.getElementById('modalTitle').textContent = 'Editar Tarea';

//     const modal = new bootstrap.Modal(document.getElementById('taskModal'));
//     modal.show();
// }

// function almacenar() {
//     if (document.getElementById('taskId').value) {
//         actualizarTarea();
//     } else {
//         guardarTarea();
//     }
// }

// function resetForm() {
//     document.getElementById('taskId').value = '';
//     document.getElementById('taskForm').reset();
//     document.getElementById('modalTitle').textContent = 'Nueva Tarea';
// }

//FORMA 2 

document.addEventListener('DOMContentLoaded', function() {
    obtenerTareas();
});

// Obtener todas las tareas
async function obtenerTareas() {
    try {
        const respuesta = await fetch('tarea/obtenerTareas');
        const resultado = await respuesta.json();
        
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        const tareas = resultado.data;
        const tbody = document.getElementById('tareaTableBody');

        tbody.innerHTML = ''; // Limpiar contenido previo

        tareas.forEach(tarea => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${tarea.id_tareas}</td>
                <td>${tarea.tarea}</td>
                <td>${tarea.equipo}</td>
                <td>${tarea.responsable || '<span class="text-muted">Sin asignar</span>'}</td>
                <td>
                    <span class="badge 
                        ${tarea.fase === 'Inicio' ? 'bg-warning' : 
                          tarea.fase === 'Desarrollo' ? 'bg-info' : 
                          'bg-success'}">
                        ${tarea.fase}
                    </span>
                </td>
                <td>${tarea.fecha_limite ? new Date(tarea.fecha_limite).toLocaleString() : 'Sin fecha'}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary" onclick="editarTarea(${tarea.id_tareas}, ${JSON.stringify(tarea).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarTarea(${tarea.id_tareas})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        mostrarAlerta('error', 'Error al cargar las tareas: ' + error.message);
    }
}

// Guardar tarea
async function guardarTarea() {
    const id = document.getElementById('tareaId').value;
    const tarea = document.getElementById('tarea').value.trim();
    const equipo = document.getElementById('equipo').value.trim();
    const responsable = document.getElementById('responsable').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const fecha_limite = document.getElementById('fecha_limite').value;
    const fase = document.getElementById('fase').value;

    // Validaciones
    if (!tarea || !equipo) {
        mostrarAlerta('error', 'Tarea y Equipo son obligatorios');
        return;
    }

    const url = id ? 'tarea/actualizarTarea' : 'tarea/crearTarea';
    const metodo = id ? 'PUT' : 'POST';

    const datos = {
        ...(id && { id_tareas: id }),
        tarea,
        equipo,
        responsable: responsable || null,
        descripcion: descripcion || null,
        fecha_limite: fecha_limite || null,
        fase
    };
    console.log('URL:', url);

    try {
        const respuesta = await fetch(url, {
            method: metodo,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (resultado.status === 'error') {
            mostrarAlerta('error', resultado.message);
            return;
        }

        mostrarAlerta('success', resultado.message);
        
        // Recargar tareas y cerrar modal
        setTimeout(() => {
            obtenerTareas();
            const modal = bootstrap.Modal.getInstance(document.getElementById('tareaModal'));
            modal.hide();
            limpiarFormulario();
        }, 1000);

    } catch (error) {
        mostrarAlerta('error', 'Error al guardar la tarea: ' + error);
    }
}

// Editar tarea
function editarTarea(id, tarea) {
    document.getElementById('modalTitle').textContent = 'Editar Tarea';
    document.getElementById('tareaId').value = id;
    document.getElementById('tarea').value = tarea.tarea;
    document.getElementById('equipo').value = tarea.equipo;
    document.getElementById('responsable').value = tarea.responsable || '';
    document.getElementById('descripcion').value = tarea.descripcion || '';
    document.getElementById('fecha_limite').value = tarea.fecha_limite ? 
        new Date(tarea.fecha_limite).toISOString().slice(0,16) : '';
    document.getElementById('fase').value = tarea.fase;

    const modal = new bootstrap.Modal(document.getElementById('tareaModal'));
    modal.show();
}

// Eliminar tarea
async function eliminarTarea(id) {
    if (!confirm('¿Estás seguro de eliminar esta tarea?')) return;

    try {
        const respuesta = await fetch('tarea/eliminarTarea', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id_tareas: id })
        });

        const resultado = await respuesta.json();

        if (resultado.status === 'error') {
            mostrarAlerta('error', resultado.message);
            return;
        }

        mostrarAlerta('success', resultado.message);
        obtenerTareas();
    } catch (error) {
        mostrarAlerta('error', 'Error al eliminar la tarea: ' + error);
    }
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('modalTitle').textContent = 'Nueva Tarea';
    document.getElementById('tareaId').value = '';
    document.getElementById('tarea').value = '';
    document.getElementById('equipo').value = '';
    document.getElementById('responsable').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('fecha_limite').value = '';
    document.getElementById('fase').value = 'Inicio';
}

// Mostrar alertas (similar a tu implementación anterior)
function mostrarAlerta(tipo, mensaje) {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${tipo === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
