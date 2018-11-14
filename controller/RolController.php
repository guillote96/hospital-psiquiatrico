<?php

class RolController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function traerRoles(){
        $resources = PDORol::getInstance()->traer_roles();
        return $resources;
    }
    public function listar_roles(){
        $resources = array('resources'=> PDORol::getInstance()->traer_roles(),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]); 
        $view = new ListarRoles();
        $view->show($resources, $permisos);
    }

    public function agregar_rol(){
        if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
             }
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);     
        $view = new AltaRol();
        $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos));
       }
    }

    public function alta_rol(){
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        if(!empty($_POST['nombre']) && isset($_POST['nombre'])){
            if(PDORol::getInstance()->existe_rol($_POST['nombre'])){
                $view = new AltaRol();
                $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 2));
                return false;
            }
            else{
                $nombre = $_POST['nombre'];
                $resources = PDORol::getInstance()->alta_rol($nombre);
                $this->listar_roles();
            }
        }
        else{
            $view = new AltaRol();
            $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 1));
                return false;
        }
    }

    public function eliminarRol(){
        if(empty($_GET["id"]) || !isset($_GET["id"])){
            return false;
        }
        $id = $_GET["id"];
        $resources = PDORol::getInstance()->eliminar_rol($id);
        $this->getInstance()->listar_roles(); 
    }

    public function editar_rol($id){
        $resources = PDORol::getInstance()->traer_rol($id);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]); 
        $view = new EditarRol();
        $view->show(array('resources' => $resources[0],'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos));
    }

    public function actualizarRol($id){
        $resources = PDORol::getInstance()->traer_rol($id);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
         if(empty($_POST['nombre']) || !isset($_POST['nombre'])){

            $view = new EditarRol();
            $view->show(array('resources' => $resources[0],'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 1));
                return false;
        }
        else{
            if(PDORol::getInstance()->existe_rol($_POST['nombre'])){
                    $view = new EditarRol();
                    $view->show(array('resources' => $resources[0],'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 2));
                    return false;
                }
            $nombre = $_POST['nombre'];
            $resources = PDORol::getInstance()->actualizar_rol($nombre,$id);
            $this->getInstance()->listar_roles(); 
        }      
    }

    
}