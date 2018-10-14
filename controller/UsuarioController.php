<?php

class UsuarioController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listResources(){
        $resources = PDOUsuario::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);
    }
    
    public function home(){
        $view = new Home();
        $view->show();
    }
    public function registrarse(){
        $view = new Registrarse();
        $view->show();
    }

    public function agregarUsuario(){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        if(isset($_POST['password']))
            $password = $_POST['password'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $activo = $_POST['activo'];     
        $resources = PDOUsuario::getInstance()->agregar_usuario($usuario, $email, $password, $nombre, $apellido, $activo);
        $view = new Home();
        $view->show();
    }
    public function actualizarUsuario($id){
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $activo = $_POST['activo']; 
        $resources = PDOUsuario::getInstance()->actualizar_usuario($usuario, $email, $nombre, $apellido, $activo,$id);
        $view = new Home();
        $view->show();           
    }
    public function eliminarUsuario(){
        $id = $_GET["id"];
        $resources = PDOUsuario::getInstance()->eliminar_usuario($id);
        $view = new Home();
        $view->show();
    }
    public function editarUsuario($id){
        $resources = PDOUsuario::getInstance()->traer_usuario($id);
        $view = new EditarUsuario();
        $view->show($resources[0]);
    }

     public function iniciarSesion(){
        $view = new IniciarSesion();
        $view->show();   
    }

    public function verificarDatos(){
        if(empty($_POST['usuario']) && empty($_POST['contraseña'])){
            return false;
        }
        $usuario = $_POST['usuario'];
        $password = $_POST['contraseña'];

        if( PDOUsuario::getInstance()->existe_usuario($usuario)){
             
            if(PDOUsuario::getInstance()->verificar_password($usuario,$password)){
                    self::getInstance()->alta_sesion($usuario);
                    //redireccionar a Home
                    $view = new HomeVerdadero();
                    $view->show($_SESSION);
                    return true;
            }else{
                echo "Contraseña incorrecta";
                return false;
            }
               
        }
        echo "Usuario o Contraseña Incorrecta";
        return false;
    }
    public function alta_sesion($usuario){
        session_start();
        $_SESSION['sesion']= true;
        $_SESSION['usuario']= $usuario;

    }

    public function cerrarSesion(){
        session_destroy();
        $view = new HomeVerdadero();
        $_SESSION['sesion']=false;
        $view->show($_SESSION);
    }
   public function buscarPorUsername(){
         if(empty($_POST['buscar'])){
            return false;
          }
         $datos= PDOUsuario:: getInstance()->buscarPorUsername($_POST['buscar']);
         $view= new BuscarUsuario();
         $view->show($datos);
    }
    public function tipoDeBusqueda(){
        if(empty($_POST['buscar'])){
            return false;
          }
        $datos; $view;
        if(strtolower ($_POST['buscar']) == "activo"){
            $datos= PDOUsuario:: getInstance()->buscarPorActivo(1);
        }else if(strtolower ($_POST['buscar']) == "bloqueado"){
            $datos= PDOUsuario:: getInstance()->buscarPorActivo(2);
        } else{
            $datos= PDOUsuario:: getInstance()->buscarPorUsername($_POST['buscar']);
        }
         $view= new BuscarUsuario();
         $view->show($datos);

    }

}

    

