<?php

class ConfiguracionController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    
    public function listarVariables(){
        $resources = array('resources' =>PDOConfiguracion::getInstance()->listAll(),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername());
        $view = new ModuloDeConfiguracion();
        $view->show($resources);
    }

     public function moduloDeConfiguracion(){
        $view = new Configuracion();
        $view->show();
    }
    
    public function home(){
        $view = new Home();
        $view->show();
    }

    public function modificarConfiguracion(){
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $email = $_POST['email'];
        $cantidad = $_POST['cantidadDeElementos'];
        $estado = $_POST['estado'];
        $resources = PDOConfiguracion::getInstance()->modificarConfiguracion($titulo,$descripcion,$email,$cantidad,$estado);


         $resources = array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername());
        $view = new Home();
        $view->inicio($resources);

    }

        public function estadoSitio(){
          $resources = PDOConfiguracion::getInstance()->listAll();
          foreach ($resources as &$var) {
              if(($var->getVariable() == 'estado') && ($var->getValor() == 0)){
                   $view = new Home();
                   $view->sitioDeshabilitado();
                   return false;
                }
            }
            return true;
        }
    
}