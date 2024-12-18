<?php
class ProductoController{

    private $db;
    private $producto;

    public function __construct() 
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $datebase = new Database();
        $this->db = $datebase->connect();
        $this->producto = new Producto($this->db);
    }    

    public function index(){

        include 'views/layouts/header.php';
        include 'views/producto/index.php';
        include 'views/layouts/footer.php';

    }
    public function obtenerProducto(){

        header('Content-Type: application/json'); 
        try {
            $resultado = $this->producto->obtenerProducto();
            $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => 'success',
                'data' => $productos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

//CLASE  16 / 12 / 2024

    public function guardarProducto(){

        header('Content-Type: application/json'); 

        try {
            //PARA RECEPCIONAR DATOS - NUNCA CAMBIA 
           // $data = json_decode(file_get_contents("php://input"));
            
           //var_dump($_POST);
            if (
                empty($_POST['name'])||
                empty($_POST['description'])||
                empty($_POST['price'])||
                empty($_POST['stock'])
                ){
                throw new Exception('Los campos son requeridosss');
            }
            
            $this->producto->nombre= $_POST['name'];
            $this->producto->descripcion= $_POST['description'];
            $this->producto->precio= $_POST['price'];
            $this->producto->stock= $_POST['stock'];

            //PARA IMAGEN CODE: 
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                
                // var_dump($_FILES['imagen']['type']);
                if (!in_array($_FILES['imagen']['type'], $allowedTypes)) {
                    throw new Exception('Tipo de archivo no permitido. Solo se permiten JPG, PNG y GIF.');
                }

                if ($_FILES['imagen']['size'] > $maxSize) {
                    throw new Exception('El archivo es demasiado grande. Máximo 5MB.');
                }

                $fileName = time() . '_' . basename($_FILES['imagen']['name']);
                $filePath = UPLOAD_PATH . $fileName;

                if (!is_dir(UPLOAD_PATH)) {
                    mkdir(UPLOAD_PATH, 0777, true);
                }

                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $filePath)) {
                    throw new Exception('Error al subir la imagen');
                }

                $this->producto->imagen = $fileName;
            }
            
           if ($this->producto->crearProducto()) {
            echo json_encode([
                'status' => 'success',
                'message'=> 'Producto creado correctamente 😉',
            ]);
           } else{
            throw new Exception('No se pudo crear un producto 🤔');
           };
    

        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function actualizarProducto(){
        header('Content-Type: application/json'); 

        try {
            //PARA RECEPCIONAR DATOS - NUNCA CAMBIA 
           // $data = json_decode(file_get_contents("php://input"));
            
           //var_dump($_POST);
            if (
                empty($_POST['name'])||
                empty($_POST['description'])||
                empty($_POST['price'])||
                empty($_POST['stock'])
                ){
                throw new Exception('Los campos son requeridosss');
            }
            $this->producto->id_producto= $_POST['id'];
            $this->producto->nombre= $_POST['name'];
            $this->producto->descripcion= $_POST['description'];
            $this->producto->precio= $_POST['price'];
            $this->producto->stock= $_POST['stock'];



            //PARA IMAGEN CODE: 
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                
                // var_dump($_FILES['imagen']['type']);
                if (!in_array($_FILES['imagen']['type'], $allowedTypes)) {
                    throw new Exception('Tipo de archivo no permitido. Solo se permiten JPG, PNG y GIF.');
                }

                if ($_FILES['imagen']['size'] > $maxSize) {
                    throw new Exception('El archivo es demasiado grande. Máximo 5MB.');
                }

                $fileName = time() . '_' . basename($_FILES['imagen']['name']);
                $filePath = UPLOAD_PATH . $fileName;

                if (!is_dir(UPLOAD_PATH)) {
                    mkdir(UPLOAD_PATH, 0777, true);
                }

                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $filePath)) {
                    throw new Exception('Error al subir la imagen');
                }

                $this->producto->imagen = $fileName;
            }
            
           if ($this->producto->actualizarProducto()) {
            echo json_encode([
                'status' => 'success',
                'message'=> 'Producto actualizado correctamente 😉',
            ]);
           } else{
            throw new Exception('No se pudo actualizar  producto 🤔');
           };
    

        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


    public function eliminarProducto(){
        header('Content-Type: application/json');
        try {
            //PARA RECEPCIONAR DATOS NUNCA CAMBIA 
            $data = json_decode(file_get_contents("php://input"));

            $this->producto->id_producto = $data ->id_producto;

            if ($this->producto->eliminarProducto()) {
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

    public function buscarProducto(){}

}