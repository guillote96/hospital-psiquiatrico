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
        $resources = PDOPaciente:: getInstance()->listAll();
        $view = new ListarPaciente();
        $view->show($resources);

    }
    public function agregarPaciente(){
        $partidos = PDOPartido:: getInstance()->listAll();
        $localidades = PDOLocalidad:: getInstance()->listAll();
        $obraSociales = PDOObraSocial:: getInstance()->listAll();
        $regionSanitaria = PDORegionSanitaria:: getInstance()->listAll();
        $generos = PDOGenero:: getInstance()->listAll();
        $tiposDoc = PDOTipoDoc:: getInstance()->listAll();
        $view = new AgregarPaciente();
        $view->show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc);
    }

    public function agregar_paciente(){
        $resources = PDOPaciente:: getInstance()->agregar_paciente($_POST['apellido'],$_POST['nombre'], $_POST['fecha_nac'],$_POST['lugar_nac'],$_POST['partido'],$_POST['localidad'],$_POST['genero'],$_POST['tiene_doc'],$_POST['tipo_doc'],$_POST['numero_documento'],$_POST['telefono'],$_POST['region_sanitaria'],$_POST['domicilio'],$_POST['numero_historia_clinica'],$_POST['numero_carpeta'],$_POST['obra_social']);
        $view = new ListarPaciente();
        $view->show(PDOPaciente:: getInstance()->listAll());

    }


    public function actualizar_paciente(){

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
                    "region_sanitaria" => $_POST['region_sanitaria'],
                    "tel" => $_POST['telefono'],
                    "numero_historia_clinica" => $_POST['numero_historia_clinica'],
                    "numero_carpeta" => $_POST['numero_carpeta'],
                    "obra_social" => $_POST['obra_social']);

        $resources = PDOPaciente:: getInstance()->actualizar_paciente($datos);
        $view = new ListarPaciente();
        $view->show(PDOPaciente:: getInstance()->listAll());

    }

     public function editarPaciente($id){
        $resources = PDOPaciente::getInstance()->traer_paciente($id);
        $datos = PDOPaciente::getInstance()->traer_datosVarios($id);
        $view = new EditarPaciente();
        $view->show($resources[0],$datos);
    }

         public function eliminarPaciente($id){
        $resources = PDOPaciente::getInstance()->eliminar_paciente($id);
        PacienteController:: getInstance()->listarTodosLosPacientes();
    }

    public function buscarPaciente (){
        $view = new BuscarPaciente();
        $view->show();


    }
     public function buscar_paciente(){

        if(!empty($_POST['apellido']) && !empty($_POST['nombre']) && !empty($_POST['numero_documento']) && !empty($_POST['tipo_doc'])){
                $datos=PDOPaciente::getInstance()->buscarPacientePorDatosPersonales($_POST['apellido'],$_POST['nombre'],$_POST['numero_documento'],$_POST['tipo_doc']);
                 $view = new ListarPaciente();
                 $view->show($datos);
                 return true;
        }else if( !empty($_POST['numero_historia_clinica'])){
             $datos=PDOPaciente::getInstance()->buscarPacienteHistoriaClinica($_POST['numero_historia_clinica']);
             $view = new ListarPaciente();
             $view->show($datos);
             return true;
        }else{
            echo "Falta completar campos de Datos de paciente o Numero de Historia clinica";
            return false;
        }


     }
	






}