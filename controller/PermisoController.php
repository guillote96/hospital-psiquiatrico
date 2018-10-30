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
    
}