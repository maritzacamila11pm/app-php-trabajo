<?php
class TareaController {

    private $db;
    private $tarea;

    public function __construct() 
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $datebase = new Database();
        $this->db = $datebase->connect();
        $this->tarea = new Tarea($this->db);
    }    

    public function index() {
        include 'views/layouts/header.php';
        include 'views/tarea/index.php';
        include 'views/layouts/footer.php';
    }

//    

//FORMA 2 
public function obtenerTareas() {
    header('Content-Type: application/json');
    try {
        $resultado = $this->tarea->obtenerTareas();
        $tareas = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => $tareas
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

public function crearTarea() {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    // Validaciones básicas
    if (empty($data['tarea']) || empty($data['equipo'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tarea y equipo son obligatorios.'
        ]);
        return;
    }

    $this->tarea->tarea = $data['tarea'];
    $this->tarea->equipo = $data['equipo'];
    $this->tarea->responsable = $data['responsable'] ?? null;
    $this->tarea->descripcion = $data['descripcion'] ?? null;
    $this->tarea->fecha_limite = $data['fecha_limite'] ?? null;
    $this->tarea->fase = $data['fase'] ?? 'Inicio';

    try {
        $resultado = $this->tarea->crearTarea();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tarea creada exitosamente.',
            'id' => $this->tarea->id_tareas
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

// Métodos adicionales para actualizar, eliminar, etc.
public function actualizarTarea() {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id_tareas'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de tarea es obligatorio.'
        ]);
        return;
    }

    $this->tarea->id_tareas = $data['id_tareas'];
    $this->tarea->tarea = $data['tarea'];
    $this->tarea->equipo = $data['equipo'];
    $this->tarea->responsable = $data['responsable'] ?? null;
    $this->tarea->descripcion = $data['descripcion'] ?? null;
    $this->tarea->fecha_limite = $data['fecha_limite'] ?? null;
    $this->tarea->fase = $data['fase'] ?? 'Inicio';

    try {
        $resultado = $this->tarea->actualizarTarea();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tarea actualizada exitosamente.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

public function eliminarTarea() {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id_tareas'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de tarea es obligatorio.'
        ]);
        return;
    }

    $this->tarea->id_tareas = $data['id_tareas'];

    try {
        $resultado = $this->tarea->eliminarTarea();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Tarea eliminada exitosamente.'
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

}