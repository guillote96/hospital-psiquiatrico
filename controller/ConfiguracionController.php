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
    
    
    public function listarVariables($error){
         if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            if($_SESSION["id"] == NULL){
                $view = new IniciarSesion();
                $view->show();
            }
            else{
                if($error == 1){
                    $resources = array('resources' =>PDOConfiguracion::getInstance()->listAll(),
                    'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'error' => 1);
                }
                else{
                    $resources = array('resources' =>PDOConfiguracion::getInstance()->listAll(),
                    'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'error' => 0);
                }
                $view = new ModuloDeConfiguracion();
                $view->show($resources);
            }
        }
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
        if(!empty($_POST['titulo']) && !empty($_POST['descripcion']) && !empty($_POST['email']) && !empty($_POST['cantidadDeElementos']) && !empty($_POST['estado'])){
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
        else{
            ConfiguracionController:: getInstance()->listarVariables(1);
        }

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