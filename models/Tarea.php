<?php
class Tarea {
    private $conn;

    public $id_tareas;
    public $equipo;
    public $responsable;
    public $tarea;
    public $descripcion;
    public $fecha_limite;
    public $fecha_creacion;
    public $fecha_actualizacion;
    public $fase;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las tareas
    public function obtenerTareas() {
        try {
            $query = "SELECT * FROM tareas ORDER BY fecha_creacion DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error al obtener las tareas: " . $e->getMessage());
        }
    }

    // Crear nueva tarea
    public function crearTarea() {
        try {
            $query = "INSERT INTO tareas 
                      (equipo, responsable, tarea, descripcion, fecha_limite, fase) 
                      VALUES 
                      (:equipo, :responsable, :tarea, :descripcion, :fecha_limite, :fase)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':equipo', $this->equipo);
            $stmt->bindParam(':responsable', $this->responsable);
            $stmt->bindParam(':tarea', $this->tarea);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':fecha_limite', $this->fecha_limite);
            $stmt->bindParam(':fase', $this->fase);

            if ($stmt->execute()) {
                $this->id_tareas = $this->conn->lastInsertId();
                return true;
            } else {
                throw new Exception("Error al crear la tarea.");
            }
        } catch (PDOException $e) {
            throw new Exception("Error en la base de datos: " . $e->getMessage());
        }
    }

    // Actualizar tarea
    public function actualizarTarea() {
        try {
            $query = "UPDATE tareas 
                      SET equipo = :equipo, 
                          responsable = :responsable, 
                          tarea = :tarea, 
                          descripcion = :descripcion, 
                          fecha_limite = :fecha_limite,
                          fase = :fase
                      WHERE id_tareas = :id_tareas";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':equipo', $this->equipo);
            $stmt->bindParam(':responsable', $this->responsable);
            $stmt->bindParam(':tarea', $this->tarea);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':fecha_limite', $this->fecha_limite);
            $stmt->bindParam(':fase', $this->fase);
            $stmt->bindParam(':id_tareas', $this->id_tareas);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar la tarea: " . $e->getMessage());
        }
    }

    // Eliminar tarea
    public function eliminarTarea() {
        try {
            $query = "DELETE FROM tareas WHERE id_tareas = :id_tareas";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_tareas', $this->id_tareas);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar la tarea: " . $e->getMessage());
        }
    }

    // Obtener tarea por ID
    public function obtenerTareaPorId() {
        try {
            $query = "SELECT * FROM tareas WHERE id_tareas = :id_tareas";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_tareas', $this->id_tareas);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la tarea: " . $e->getMessage());
        }
    }
}