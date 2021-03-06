<?php

class ObraSocialController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listarObrasSociales(){
        $resources = PDOObraSocial::getInstance()->listAll();
        $view = new ListarObrasSociales();
        $view->show($resources);
    }

    public function home(){
        $view = new Home();
        $view->show();
    }
    
}