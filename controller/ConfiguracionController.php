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
                $resources = array('resources' =>PDOConfiguracion::getInstance()->listAll(),
                'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'error' => $error, 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0]);
                $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
                $view = new ModuloDeConfiguracion();
                $view->show($resources, $permisos);
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
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                ConfiguracionController:: getInstance()->listarVariables(2);
                return false;
            }
            $cantidad = $_POST['cantidadDeElementos'];
            if (!filter_var($cantidad, FILTER_VALIDATE_INT)) {
                ConfiguracionController:: getInstance()->listarVariables(3);
                return false;
            }
            $estado = $_POST['estado'];

            $resources = PDOConfiguracion::getInstance()->modificarConfiguracion($titulo,$descripcion,$email,$cantidad,$estado);
            $permisos = PDOPermiso::getInstance()->traer_permisos_usuario($_SESSION["id"]);
            $resources = array('usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(), 'titulo' => PDOConfiguracion::getInstance()->traer_titulo()[0][0], 'permisos' => $permisos);

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
              if(($var->getVariable() == 'estado') && ($var->getValor() == 2)){
                   $view = new Home();
                   $titulo = PDOConfiguracion::getInstance()->traer_titulo()[0][0];
                   //$view->sitioDeshabilitado($titulo);
                   return false;
                }
            }
            return true;
        }
    
}