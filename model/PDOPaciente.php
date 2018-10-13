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

    public function agregar_paciente($datos){
      //falta hacer los cruces de tablas para cierta info y usar ajax para partidos, localidades ,etc

            $answer = $this->queryList("INSERT INTO paciente (apellido, 
            nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id ,tiene_documento, tipo_doc_id, numero, nro_historia_clinica,nro_carpeta, obra_social_id) VALUES ('$datos[apellido]','$datos[nombre]','$datos[fecha_nac]','$datos[lugar_nac]',1,1,'$datos[domicilio]',1,'$datos[tiene_doc]',1,'$datos[numero_documento]','$datos[numero_historia_clinica]','$datos[numero_carpeta]',1)");

    }



}