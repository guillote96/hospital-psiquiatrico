<?php

class PacienteController{

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    

    public function listarTodosLosPacientes(){
        $resources = array('resources' => PDOPaciente:: getInstance()->listAll(),
                            'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername());
        $view = new ListarPaciente();
        $view->show($resources);

    }
    public function agregarPaciente(){
        if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
          $partidos = PDOPartido:: getInstance()->listAll();
          $localidades = PDOLocalidad:: getInstance()->listAll();
          $obraSociales = PDOObraSocial:: getInstance()->listAll();
          $regionSanitaria = PDORegionSanitaria:: getInstance()->listAll();
          $generos = PDOGenero:: getInstance()->listAll();
          $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
          $view = new AgregarPaciente();
          $usuario = PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername();
          $view->show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc,$usuario);
        }
    }

    public function agregar_paciente(){
        $resources = PDOPaciente:: getInstance()->agregar_paciente($_POST['apellido'],$_POST['nombre'], $_POST['fecha_nac'],$_POST['lugar_nac'],$_POST['partido'],$_POST['localidad'],$_POST['genero'],$_POST['tiene_doc'],$_POST['tipo_doc'],$_POST['numero_documento'],$_POST['telefono'],$_POST['region_sanitaria'],$_POST['domicilio'],$_POST['numero_historia_clinica'],$_POST['numero_carpeta'],$_POST['obra_social']);
        $view = new ListarPaciente();
        $resources= array('resources' =>PDOPaciente:: getInstance()->listAll() ,
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername() );
        $view->show($resources);

    }


    public function actualizar_paciente(){
                            //"tel" => $_POST['telefono'],

        $datos=array("apellido" => $_POST['apellido'],
                    "nombre"  => $_POST['nombre'],
                    "fecha_nac" => $_POST['fecha_nac'],
                    "lugar_nac" => $_POST['lugar_nac'],
                    "partido" => $_POST['partido'],
                    "localidad" => $_POST['localidad'],
                    "domicilio" => $_POST['domicilio'],
                    "genero" =>  $_POST['genero'],
                    "tiene_doc" => $_POST['tiene_doc'],
                    "tipo_doc" => $_POST['tipo_doc'],
                    "numero_documento" => $_POST['numero_documento'],
                    "telefono" => $_POST['telefono'],
                    "region_sanitaria" => $_POST['region_sanitaria'],
                    "numero_historia_clinica" => $_POST['numero_historia_clinica'],
                    "numero_carpeta" => $_POST['numero_carpeta'],
                    "obra_social" => $_POST['obra_social']);
        //var_dump($datos);
        PDOPaciente::getInstance()->actualizar_paciente($datos);
        $resources= array('resources' => PDOPaciente:: getInstance()->listAll(), 
                          'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername());
        $view = new ListarPaciente();
        $view->show($resources);

    }

     public function editarPaciente($id){
        $resources = array('resources' => (PDOPaciente::getInstance()->traer_paciente($id))[0],
                           'datos' =>  PDOPaciente::getInstance()->traer_datosVarios($id),
                           'usuario' => PDOUsuario::getInstance()->traer_usuario($_SESSION['id'])[0]->getUsername(),
                           'partidos' => PDOPartido::getInstance()->listAll(),
                           'localidades' => PDOLocalidad::getInstance()->listAll(),
                           'region_sanitaria' => PDORegionSanitaria::getInstance()->listAll(),
                           'tipodoc' => PDOTipoDoc::getInstance()->listAll(),
                           'genero' => PDOGenero::getInstance()->listAll(),
                           'obrasocial' => PDOObraSocial::getInstance()->listAll());

        $view = new EditarPaciente();
        $view->show($resources);
    }

         public function eliminarPaciente($id){
        $resources = PDOPaciente::getInstance()->eliminar_paciente($id);
        PacienteController:: getInstance()->listarTodosLosPacientes();
    }

    public function buscarPaciente (){
        if (sizeof($_SESSION) == 0){
            $view = new IniciarSesion();
            $view->show();
        }
        else{
            $view = new BuscarPaciente();
            $datos=array('usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername());
            $view->show($datos);
        }

    }
     public function buscar_paciente(){

        if(!empty($_POST['apellido']) && !empty($_POST['nombre']) && !empty($_POST['numero_documento']) && !empty($_POST['tipo_doc'])){
                
           $datos=array('resources' => PDOPaciente::getInstance()->buscarPacientePorDatosPersonales($_POST['apellido'],$_POST['nombre'],$_POST['numero_documento'],$_POST['tipo_doc']),
             'usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername());
           $view = new ListarPaciente();
           $view->show($datos);
           return true;
        }else 

           if( !empty($_POST['numero_historia_clinica'])){
               $datos=array('resources' => PDOPaciente::getInstance()->buscarPacienteHistoriaClinica($_POST['numero_historia_clinica']),
                          'usuario' => (PDOUsuario::getInstance()->traer_usuario($_SESSION['id']))[0]->getUsername());
                $view = new ListarPaciente();
                $view->show($datos);
                return true;
        }else
             {

            echo "Falta completar campos de Datos de paciente o Numero de Historia clinica";
            return false;
             }


     }
	






}