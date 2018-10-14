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

    public function agregar_paciente($datos){
      //falta hacer los cruces de tablas para cierta info y usar ajax para partidos, localidades ,etc
            $sqlLocalidadId= $this->queryList("SELECT id FROM localidad WHERE nombre = '$datos[localidad]'");
            $sqlRegionSanitariaId= $this->queryList("SELECT id FROM region_sanitaria WHERE nombre = '$datos[region_sanitaria]'");
             $sqlGeneroId= $this->queryList("SELECT id FROM genero WHERE nombre = '$datos[genero]'");
             $sqlTipoDocumentoId= $this->queryList("SELECT id FROM tipo_documento WHERE nombre = '$datos[tipo_doc]'");
             $sqlObraSocialId= $this->queryList("SELECT id FROM obra_social WHERE nombre = '$datos[obra_social]'");


             $idLocalidad= $sqlLocalidadId[0]["id"];
             $idRegionSanitaria= $sqlRegionSanitariaId[0]["id"];
             $idGenero= $sqlGeneroId[0]["id"];
             $idTipoDocumentoId=$sqlTipoDocumentoId[0]["id"];
             $idObraSocial=$sqlObraSocialId[0]["id"];

            $answer = $this->queryList("INSERT INTO paciente (apellido, 
            nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id ,tiene_documento, tipo_doc_id, numero, nro_historia_clinica,nro_carpeta, obra_social_id) VALUES ('$datos[apellido]','$datos[nombre]','$datos[fecha_nac]','$datos[lugar_nac]',$idLocalidad,$idRegionSanitaria,'$datos[domicilio]',$idGenero,'$datos[tiene_doc]',$idTipoDocumentoId,'$datos[numero_documento]','$datos[numero_historia_clinica]','$datos[numero_carpeta]',$idObraSocial)");

    }

    public function eliminar_paciente($id){
        $answer = $this->addObj("DELETE FROM paciente WHERE id='$id'");
    }

    public function actualizar_paciente($datos){
            $sqlLocalidadId= $this->queryList("SELECT id FROM localidad WHERE nombre = '$datos[localidad]'");
            $sqlRegionSanitariaId= $this->queryList("SELECT id FROM region_sanitaria WHERE nombre = '$datos[region_sanitaria]'");
            $sqlGeneroId= $this->queryList("SELECT id FROM genero WHERE nombre = '$datos[genero]'");
            $sqlTipoDocumentoId= $this->queryList("SELECT id FROM tipo_documento WHERE nombre = '$datos[tipo_doc]'");
            $sqlObraSocialId= $this->queryList("SELECT id FROM obra_social WHERE nombre = '$datos[obra_social]'");


             $idLocalidad= $sqlLocalidadId[0]["id"];
             $idRegionSanitaria= $sqlRegionSanitariaId[0]["id"];
             $idGenero= $sqlGeneroId[0]["id"];
             $idTipoDocumentoId=$sqlTipoDocumentoId[0]["id"];
             $idObraSocial=$sqlObraSocialId[0]["id"];

             $answer = $this->addObj("UPDATE paciente SET apellido = '$datos[apellido]', nombre = '$datos[nombre]', fecha_nac = '$datos[fecha_nac]', lugar_nac ='$datos[lugar_nac]', localidad_id = $idLocalidad, region_sanitaria_id = $idRegionSanitaria, domicilio ='$datos[domicilio]', genero_id=$idGenero ,tiene_documento ='$datos[tiene_doc]', tipo_doc_id = $idTipoDocumentoId, numero ='$datos[numero_documento]', nro_historia_clinica = '$datos[numero_historia_clinica]',nro_carpeta ='$datos[numero_carpeta]', obra_social_id =$idObraSocial WHERE id='$_GET[id]'");
    }

    public function traer_datosVarios($id){
      // Trae Nombre de los siguientes campos: localidad, region sanitaria, genero, tipo de documento y obrasocial
      $consulta= $this->queryList("SELECT l.nombre as localidad, pa.nombre as partido, rs.nombre as regionsanitaria, td.nombre as tipodocumento, g.nombre as genero, os.nombre as obrasocial FROM paciente p inner join localidad l on ( p.localidad_id = l. id) inner join partido pa on (pa.id = l.partido_id) inner join region_sanitaria rs on (rs.id=pa.region_sanitaria_id) inner join tipo_documento td on (td.id = p.tipo_doc_id) inner join genero g on ( g.id = p.genero_id) inner join obra_social os on (os.id=p.obra_social_id) WHERE p.id = $id");
         
        $datos = array(  "localidad" => $consulta [0]["localidad"],
                              "partido" =>   $consulta [0]["partido"],
                              "region" => $consulta [0]["regionsanitaria"],
                              "tipodocumento" => $consulta [0]["tipodocumento"],
                              "genero" => $consulta [0]["genero"],
                              "obrasocial" => $consulta [0]["obrasocial"]);

          return $datos;
    }




}