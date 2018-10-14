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
        $view = new AgregarPaciente();
        $view->show();
    }

    public function agregar_paciente(){

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
                    "numero_historia_clinica" => $_POST['numero_historia_clinica'],
                    "numero_carpeta" => $_POST['numero_carpeta'],
                    "obra_social" => $_POST['obra_social']);

        $resources = PDOPaciente:: getInstance()->agregar_paciente($datos);
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
	






}