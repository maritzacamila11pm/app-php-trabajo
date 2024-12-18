<?php
//include "./config/Database.php";

//$db = new Database();
//$valida = $db->connect();

//if($valida){
  //  echo"conexion establecida correctamente";
//}else{
 //   echo"error de conexion";
//}


error_reporting(E_ALL);
ini_set('display_errors',1);

//cargar el archivo de configuracion
require_once 'config/config.php';

//Autoload de clases
spl_autoload_register(function ($class_name) {
    $directories = [
        'controllers/',
        'models/',
        'config/',
        'utils/',
        ''
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            // var_dump($file);
            require_once $file;
            return;
        }
    }
});

//crear una instancia de router
$router = new Router();

$public_routes =[
    '/web',
    '/login',
    '/register',
    

];

//optener la ruta actual
$current_route = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$current_route = str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$current_route);

//$current_route = 

//var_dump(dirname($_SERVER['SCRIPT_NAME']));
//var_dump($current_route);

$router->add('GET','/web','WebController','index',);

// loguin and registro
$router->add('GET','/login','AuthController','showLogin',);
$router->add('GET','/register','AuthController','showRegister',);
/// post
$router->add('POST', 'auth/login', 'AuthController', 'login');
$router->add('POST', 'auth/register', 'AuthController', 'register');

/// HOME CONTROLLER
$router->add('GET', '/home', 'HomeController', 'index');

/// CRUD PRODUCTOS 
$router->add('GET', 'productos/', 'ProductoController', 'index');
$router->add('GET', 'productos/obtener-todo', 'ProductoController', 'obtenerProducto');
$router->add('POST', 'productos/guardar-producto', 'ProductoController', 'guardarProducto');
$router->add('POST', 'productos/actualizar-producto', 'ProductoController', 'actualizarProducto');
$router->add('DELETE', 'productos/eliminar-producto', 'ProductoController', 'eliminarProducto');
$router->add('GET', 'productos/buscar-producto', 'ProductoController', 'buscarProducto');

//CRUD DOCUMENTOS
$router->add('GET', '/tipo_documento', 'TipoDocumentoController', 'index');
$router->add('GET', '/tipo_documento/obtenerTipoDocumento', 'TipoDocumentoController', 'obtenerTipoDocumento');
$router->add('POST', '/tipo_documento/crearTipoDocumento', 'TipoDocumentoController', 'guardarTipoDocumento');
$router->add('DELETE', 'tipo_documento/eliminar-documento', 'TipoDocumentoController', 'eliminarDocumento');
$router->add('POST', 'tipo_documento/actualizarDocumento', 'TipoDocumentoController', 'actualizarDocumento');
$router->add('GET', 'reportetd/pdf', 'ReporteTdController', 'reportetdPdf');
$router->add('GET', 'reporteDoc/excel', 'ReporteTdController', 'reporteExcelTipoDocumento');

//PDF EXCEL
$router->add('GET', 'reporte/pdf', 'ReporteController', 'reportePdf');
$router->add('GET', 'reporte/excel', 'ReporteController', 'reporteExcel');
//cambia la ruta en tu controlador reporte/excel ejemplo

// //CRUD TAREAS

// $router->add('GET', 'tareas/', 'TareaController', 'index');
// $router->add('GET', 'tareas/obtener-todo', 'TareaController', 'obtenerTarea');
// $router->add('POST', 'tareas/guardar-tarea', 'TareaController', 'guardarTarea');
// $router->add('POST', 'tareas/actualizar-tarea', 'TareaController', 'actualizarTarea');
// $router->add('DELETE', 'tareas/eliminar-tarea', 'TareaController', 'eliminarTarea');

/// CRUD TAREAS 
$router->add('GET', 'tarea/', 'TareaController', 'index');
$router->add('GET', '/tarea/obtenerTareas', 'TareaController', 'obtenerTareas');
$router->add('POST', 'tarea/crearTarea', 'TareaController', 'crearTarea');
$router->add('PUT', 'tarea/actualizarTarea', 'TareaController', 'actualizarTarea');
$router->add('DELETE', 'tarea/eliminarTarea', 'TareaController', 'eliminarTarea');
$router->add('GET', 'reporteTarea/pdf', 'ReporteTController', 'reporteTPdf');
$router->add('GET', 'reporteTarea/excel', 'ReporteTController', 'reporteExcelTareas');

//Despachar la ruta
try {
    $router->dispatch($current_route, $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    // Manejar el error
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        include 'views/errors/404.php';
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} 