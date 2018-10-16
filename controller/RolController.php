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
    
}