<?php
// controllers/TipoDocumentoController.php

class TipoDocumentoController
{
    private $db;
    private $tipoDocumento;

    public function __construct()
    {
        // Conectar a la base de datos
        $database = new Database();
        $this->db = $database->connect();
        $this->tipoDocumento = new TipoDocumento($this->db);
    }

    public function index()
    {
        include 'views/layouts/header.php';
        include 'views/tipo_documento/index.php';
        include 'views/layouts/footer.php';
    }

    public function obtenerTipoDocumento()
    {
        header('Content-Type: application/json');
        try {
            $resultado = $this->tipoDocumento->obtenerTipoDocumento();
            if (!$resultado) {
                throw new Exception("No se encontraron tipos de documentos.");
            }

            $tiposDocumento = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'data' => $tiposDocumento
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function guardarTipoDocumento()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['nombre'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'El nombre del tipo de documento es obligatorio.'
            ]);
            return;
        }

        $this->tipoDocumento->nombre = $data['nombre'];
        $this->tipoDocumento->descripcion = $data['descripcion'] ?? '';
        $this->tipoDocumento->esta_activo = $data['esta_activo'] ?? true;

        try {
            $resultado = $this->tipoDocumento->crearTipoDocumento();
            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Documento creado exitosamente.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error al crear el tipo de documento.'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // Método para actualizar el estado de un tipo de documento (opcional)
    public function actualizarDocumento()
{
    header('Content-Type: application/json');

    try {
        if (
            empty($_POST['name']) ||
            empty($_POST['description']) ||
            !isset($_POST['esta_activo']) // Verifica que exista el campo
        ) {
            throw new Exception('Los campos son requeridos');
        }

        // Conversión explícita: si 'esta_activo' existe, asignar 1, sino 0
        $this->tipoDocumento->id_tipo_documento = $_POST['id'];
        $this->tipoDocumento->nombre = $_POST['name'];
        $this->tipoDocumento->descripcion = $_POST['description'];
        $this->tipoDocumento->esta_activo = isset($_POST['esta_activo']) ? 1 : 0;


        if ($this->tipoDocumento->actualizarTipoDocumento()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Documento actualizado correctamente 😉',
            ]);
        } else {
            throw new Exception('No se pudo actualizar el documento 🤔');
        }
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

    public function eliminarDocumento(){
        header('Content-Type: application/json');
        try {
            //PARA RECEPCIONAR DATOS NUNCA CAMBIA 
            $data = json_decode(file_get_contents("php://input"));

            $this->tipoDocumento->id_tipo_documento = $data ->id_tipo_documento;

            if ($this->tipoDocumento->eliminarDocumento()) {
                echo json_encode([
                    'status' => 'success',
                    'message'=> 'Producto eliminado correctamente 😉',
                ]);
               } else{
                throw new Exception('No se pudo eliminar el producto 🤔');
               };
        
    
            } catch (Exception $e) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
    }
}