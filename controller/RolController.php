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
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername());
        $view = new ListarRoles();
        $view->show($resources);
    }
    
}