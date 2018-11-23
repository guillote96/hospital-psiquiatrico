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

     public function instituciones(){
        $resources = PDOInstitucion::getInstance()->listAll();
        
       return $resources;
    
     }

    public function institucion($id){
        $resources = PDOInstitucion::getInstance()->traer_institucion($id);
        
       return $resources;
    
     }
    
}