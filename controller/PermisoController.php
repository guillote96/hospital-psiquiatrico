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
        $resources = PDOPermiso::getInstance()->traer_permisos();
        $view = new ListarPermisos();
        $view->show($resources);
    }
    
}