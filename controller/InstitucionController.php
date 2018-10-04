<?php

class InstitucionController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listarInstituciones(){
        $resources = PDOInstitucion::getInstance()->listAll();
        $view = new ListarInstituciones();
        $view->show($resources);
    }

    public function home(){
        $view = new Home();
        $view->show();
    }
    
}