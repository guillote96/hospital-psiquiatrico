<?php

class LocalidadController {
    
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
        $resources = PDOLocalidad::getInstance()->listAll();
        $view = new SimpleResourceList();
        $view->show($resources);
    }
    
    public function home(){
        $view = new Home();
        $view->show();
    }
    
}
