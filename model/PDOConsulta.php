<?php

class PDOConsulta extends PDORepository {

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
        $answer = $this->query("select * from consulta", array());
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Consulta ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id']);
        }
        return $final_answer;
    }


    

    public function insertarConsulta($array){
      $result=$this->query("INSERT INTO consulta (paciente_id, fecha,  motivo_id, derivacion_id, articulacion_con_instituciones, internacion, diagnostico, observaciones, tratamiento_farmacologico_id, acompanamiento_id) VALUES (:pacienteid, :fecha, :motivoid, :derivacionid ,:articulacion ,:internacion, :diagnostico, :observaciones, :tratamiento, :acompanamiento)",$array);
      return $result;

    }

}