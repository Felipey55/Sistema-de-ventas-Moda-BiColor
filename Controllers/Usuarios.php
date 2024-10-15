<?php
class Usuarios extends Controller {

    public function __construct(){
        session_start();
        parent::__construct();
    }
    public function index() {
        $data['cajas'] = $this->model->getCajas();
        $this->views->getView($this, "index", $data);
    }

    function listar() {
        $data = $this->model->getUsuarios();
        
        for ($i = 0; $i < count($data); $i++) { 
            // Verificar estado y asignar etiquetas HTML
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
            }
    
            // Agregar acciones HTML
            $data[$i]['acciones'] = '<div>
                <button class="btn btn-primary btn-sm" type="button">Editar</button>
                <button class="btn btn-danger btn-sm" type="button">Eliminar</button>
            </div>';
        }
    
        // Establecer el tipo de contenido como JSON y enviar la respuesta
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    
    


    public function validar() {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $msg = "Los campos estan vacios";
        } else {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $data = $this->model->getUsuario($usuario, $clave);
            if($data){
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $msg = "ok";
            }else{
                $msg = "Usuario o contraseña incorrecta";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}

?> 
