<?php
// models/TipoDocumento.php
class TipoDocumento
{
    private $conn;

    public $id_tipo_documento;
    public $nombre;
    public $descripcion;
    public $fecha_creacion;
    public $esta_activo; // Nuevo campo

    // Constructor que recibe la conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }

    // Modificar el método de obtener tipo documento
    public function obtenerTipoDocumento() {
        try {
            $query = "SELECT * FROM tipo_documento ORDER BY fecha_creacion DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener los tipos de documento: " . $e->getMessage());
        }
    }

    // Modificar el método para crear un nuevo tipo de documento
    public function crearTipoDocumento() {
        try {
            // Verificar que el nombre no esté vacío
            if (empty($this->nombre)) {
                throw new Exception("El nombre del tipo de documento es obligatorio.");
            }

            // Query para insertar un nuevo tipo de documento con el nuevo campo
            $query = "INSERT INTO tipo_documento (nombre, descripcion, fecha_creacion, esta_activo) 
                      VALUES (:nombre, :descripcion, NOW(), :esta_activo)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            
            // Bind del nuevo campo, convertir a entero (0 o 1)
            $esta_activo_int = $this->esta_activo ? 1 : 0;
            $stmt->bindParam(':esta_activo', $esta_activo_int, PDO::PARAM_INT);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $this->id_tipo_documento = $this->conn->lastInsertId();
                return true;
            } else {
                throw new Exception("Error al crear el tipo de documento.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    // Modificar el método de actualización para incluir el nuevo campo
    public function actualizarTipoDocumento() {
        $query = "UPDATE tipo_documento 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      esta_activo = :esta_activo
                  WHERE id_tipo_documento = :id_tipo_documento";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':esta_activo', $this->esta_activo);
        $stmt->bindParam(':id_tipo_documento', $this->id_tipo_documento);
    
        if($stmt->execute()) {
            return true; // Si la consulta se ejecuta correctamente
        }
        return false; // Si algo falla
    }
    

    public function eliminarDocumento() {
        $query = "DELETE FROM tipo_documento WHERE id_tipo_documento = :id_tipo_documento";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_tipo_documento', $this->id_tipo_documento);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Los demás métodos permanecen igual
}