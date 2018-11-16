<?php

class PermisoController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function traerPermisos(){
        $resources = PDOPermiso::getInstance()->traer_permisos();
        return $resources;
    }
    public function listar_permisos(){
        $resources = array('resources'=>PDOPermiso::getInstance()->traer_permisos(),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $view = new ListarPermisos();
        $view->show($resources, $permisos);
    }

    public function agregar_permiso(){
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
        $roles = PDORol::getInstance()->traer_roles();   
        $view = new AltaPermiso();
        $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'roles' => $roles));
       }
    }

    public function alta_permiso(){
        
        $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
        $roles = PDORol::getInstance()->traer_roles();
        if(!empty($_POST['nombre']) && isset($_POST['nombre']) && !empty($_POST['rol']) && isset($_POST['rol'])){
            if(PDOPermiso::getInstance()->existe_permiso($_POST['nombre'])){
                $view = new AltaPermiso();
                $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 2, 'roles' => $roles));
                return false;
            }
            else{
                $nombre = $_POST['nombre'];
                $rol = $_POST['rol'];
                $resources = PDOPermiso::getInstance()->alta_permiso($nombre, $rol);
                $this->listar_permisos();
            }
        }
        else{
            $view = new AltaPermiso();
            $view->show(array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos, 'error' => 1, 'roles' => $roles));
                return false;
        }
    }

    public function eliminarPermiso(){
        if(empty($_GET["id"]) || !isset($_GET["id"])){
            return false;
        }
        $id = $_GET["id"];
        $resources = PDOPermiso::getInstance()->eliminar_permiso($id);
        $this->getInstance()->listar_permisos(); 
    }
    
}