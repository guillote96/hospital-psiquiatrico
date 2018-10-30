<?php

class PDOPaciente extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function listAll() {
        $answer = $this->queryList("select * from paciente");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Paciente($element['apellido'],
                                           $element['domicilio'], 
                                           $element['fecha_nac'],
                                           $element['genero_id'], 
                                           $element['id'],
                                           $element['localidad_id'],
                                           $element['lugar_nac'], 
                                           $element['nombre'],
                                           $element['nro_carpeta'],
                                           $element['nro_historia_clinica'], 
                                           $element['numero'],
                                           $element['obra_social_id'],
                                           $element['region_sanitaria_id'],
                                           $element['tel'],
                                           $element['tiene_documento'],
                                           $element['tipo_doc_id']);
        }
        return $final_answer;

                         
    }

    public function traer_paciente($id){
        $answer = $this->queryList("select * from paciente WHERE id='$id'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Paciente($element['apellido'],$element['domicilio'],$element['fecha_nac'],$element['genero_id'],$element['id'],$element['localidad_id'],$element['lugar_nac'],$element['nombre'],$element['nro_carpeta'],$element['nro_historia_clinica'],$element['numero'],$element['obra_social_id'],$element['region_sanitaria_id'],$element['tel'],$element['tiene_documento'],$element['tipo_doc_id']);
        }
        return $final_answer;


  }

    public function agregar_paciente($apellido,$nombre, $fecha_nac, $lugar_nac, $partido,$localidad,$genero,$tiene_doc,$tipo_doc,$numero_documento,$telefono,$region_sanitaria,$domicilio,$numero_historia_clinica,$numero_carpeta,$obra_social){

            $answer = $this->addObj("INSERT INTO paciente (apellido, 
            nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id, tiene_documento, tipo_doc_id, numero, tel, nro_historia_clinica, nro_carpeta, obra_social_id) VALUES('$apellido','$nombre','$fecha_nac','$lugar_nac','$localidad','$region_sanitaria','$domicilio','$genero','$tiene_doc','$tipo_doc','$numero_documento','$telefono','$numero_historia_clinica','$numero_carpeta','$obra_social')");

    }

    public function eliminar_paciente($id){
        $answer = $this->addObj("DELETE FROM paciente WHERE id='$id'");
    }

    public function actualizar_paciente($datos){
             $idLocalidad= $datos['localidad'];
             $idRegionSanitaria= $datos['region_sanitaria'];
             $idGenero= $datos['genero'];
             $idTipoDocumentoId=$datos['tipo_doc'];
             $idObraSocial=$datos['obra_social'];
             $apellido = $datos['apellido'];
             $nombre = $datos['nombre'];
             $fecha_nac = $datos['fecha_nac'];
             $lugar_nac = $datos['lugar_nac'];
             $partido = $datos['partido'];
             $localidad = $datos['localidad'];
             $domicilio = $datos['domicilio'];
             $genero = $datos['genero'];
             $tiene_doc = $datos['tiene_doc'];
             $tipo_doc = $datos['tipo_doc'];
             $numero_documento = $datos['numero_documento'];
             $telefono = $datos['telefono'];
             $region_sanitaria = $datos['region_sanitaria'];
             $numero_historia_clinica = $datos['numero_historia_clinica'];
             $numero_carpeta = $datos['numero_carpeta'];
             $obra_social = $datos['obra_social'];
            
             $answer = $this->addObj("UPDATE paciente SET apellido = '$apellido', nombre = '$nombre', fecha_nac = '$fecha_nac', lugar_nac = '$lugar_nac', localidad_id = '$idLocalidad', region_sanitaria_id = '$region_sanitaria', domicilio = '$domicilio', genero_id = '$genero', tiene_documento = '$tiene_doc', tipo_doc_id = '$tipo_doc', numero = '$numero_documento', tel = '$telefono', nro_historia_clinica = '$numero_historia_clinica', nro_carpeta = '$numero_carpeta', obra_social_id = '$obra_social' WHERE id='$_GET[id]'");             
    }

    public function traer_datosVarios($id){
      // Trae Nombre de los siguientes campos: localidad, region sanitaria, genero, tipo de documento y obrasocial
      $consulta= $this->queryList("SELECT l.nombre as localidad, pa.nombre as partido, rs.id as regionsanitaria, td.nombre as tipodocumento, g.nombre as genero, os.nombre as obrasocial FROM paciente p inner join localidad l on ( p.localidad_id = l. id) inner join partido pa on (pa.id = l.partido_id) inner join region_sanitaria rs on (rs.id=pa.region_sanitaria_id) inner join tipo_documento td on (td.id = p.tipo_doc_id) inner join genero g on ( g.id = p.genero_id) inner join obra_social os on (os.id=p.obra_social_id) WHERE p.id = $id");
         
        $datos = array(  "localidad" => $consulta [0]["localidad"],
                              "partido" =>   $consulta [0]["partido"],
                              "region" => $consulta [0]["regionsanitaria"],
                              "tipodocumento" => $consulta [0]["tipodocumento"],
                              "genero" => $consulta [0]["genero"],
                              "obrasocial" => $consulta [0]["obrasocial"]);

          return $datos;
    }

    public function buscarPacientePorDatosPersonales($apellido,$nombre,$numero_documento,$tipo_doc){
      $answer = $this->queryList("select apellido, domicilio, fecha_nac, genero_id, p.id as pacienteid, localidad_id, lugar_nac, p.nombre as nombrepaciente, td.nombre as documento, nro_carpeta, nro_historia_clinica, numero, obra_social_id, region_sanitaria_id, tel, tiene_documento, tipo_doc_id from paciente p inner join tipo_documento td on (p.tipo_doc_id = td.id) WHERE apellido='$apellido' AND p.nombre='$nombre'AND numero = $numero_documento AND td.nombre = '$tipo_doc'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Paciente($element['apellido'],$element['domicilio'],$element['fecha_nac'],$element['genero_id'],$element['pacienteid'],$element['localidad_id'],$element['lugar_nac'],$element['nombrepaciente'],$element['nro_carpeta'],$element['nro_historia_clinica'],$element['numero'],$element['obra_social_id'],$element['region_sanitaria_id'],$element['tel'],$element['tiene_documento'],$element['tipo_doc_id']);
        }
        return $final_answer;
    }

    public function buscarPacienteHistoriaClinica($historiaclinica){
      $answer = $this->queryList("select * from paciente WHERE nro_historia_clinica = '$historiaclinica'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Paciente($element['apellido'],$element['domicilio'],$element['fecha_nac'],$element['genero_id'],$element['id'],$element['localidad_id'],$element['lugar_nac'],$element['nombre'],$element['nro_carpeta'],$element['nro_historia_clinica'],$element['numero'],$element['obra_social_id'],$element['region_sanitaria_id'],$element['tel'],$element['tiene_documento'],$element['tipo_doc_id']);
        }
        return $final_answer;
    }

     public function listarCantidad($pagina,$cantidad) {
        $answer = $this->queryList("select * from paciente limit ". (($pagina - 1) * $cantidad).",". $cantidad);
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Paciente($element['apellido'],$element['domicilio'],$element['fecha_nac'],$element['genero_id'],$element['id'],$element['localidad_id'],$element['lugar_nac'],$element['nombre'],$element['nro_carpeta'],$element['nro_historia_clinica'],$element['numero'],$element['obra_social_id'],$element['region_sanitaria_id'],$element['tel'],$element['tiene_documento'],$element['tipo_doc_id']);
        }
        return $final_answer;

                         
    }

    public function cantidad() {
        $answer = $this->queryList("select count(*) from paciente");
        return $answer;
    }


}