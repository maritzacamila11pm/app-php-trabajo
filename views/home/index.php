<!-- views/home/index.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
<script>
        // Alerta al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              //  icon: 'info',
                title: 'Bienvenido !!',
                text: 'Estas en el sistema!!',
                confirmButtonText: 'Comenzar',
                imageUrl: 'https://static.vecteezy.com/system/resources/previews/010/869/739/original/file-management-concept-illustration-modern-concept-of-file-management-system-online-document-storage-service-free-png.png', // URL de tu imagen
                imageWidth: 300,  // Ancho de la imagen
                imageHeight: 200, // Alto de la imagen
            });
        });

       
    </script>
    
<div class="row">
    <div class="col-md-12 text-center mb-4">
        <h1>Bienvenido al Sistema de Gestión de Productos</h1>
        <p class="lead">Administra tu inventario de manera fácil y eficiente</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-box fa-3x mb-3 text-primary"></i>
                <h5 class="card-title">Gestión de Productos</h5>
                <p class="card-text">Administra tu catálogo de productos de manera eficiente.</p>
                <a href="<?= BASE_URL ?>/productos" class="btn btn-primary">Ir a Productos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-chart-bar fa-3x mb-3 text-success"></i>
                <h5 class="card-title">Estadísticas</h5>
                <p class="card-text">Visualiza estadísticas y reportes de tu inventario.</p>
                <a href="<?= BASE_URL ?>/stats" class="btn btn-success">Ver Estadísticas</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-cog fa-3x mb-3 text-info"></i>
                <h5 class="card-title">Configuración</h5>
                <p class="card-text">Personaliza las opciones del sistema.</p>
                <a href="<?= BASE_URL ?>/settings" class="btn btn-info">Configurar</a>
            </div>
        </div>
    </div>
</div>