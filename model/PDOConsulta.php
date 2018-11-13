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


       public function traer_consulta($idConsulta) {
        $answer = $this->query("select * from consulta where id=:id", array(':id' => $idConsulta));
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Consulta ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id']);
        }
        return $final_answer;
    }

    public function actualizarConsulta($array){
      $result=$this->query("UPDATE consulta SET paciente_id = :pacienteid, fecha = :fecha,  motivo_id = :motivoid, derivacion_id = :derivacionid, articulacion_con_instituciones = :articulacion, internacion = :internacion, diagnostico = :diagnostico, observaciones = :observaciones, tratamiento_farmacologico_id = :tratamiento, acompanamiento_id = :acompanamiento WHERE id = :id",$array);
      return $result;

    }

    public function eliminarConsulta($array){
         $result=$this->query("DELETE FROM consulta WHERE id = :id",$array);
         return $result;


    }

       public function traer_consultas_de_paciente($array) {
        $answer = $this->query("select * from consulta where paciente_id = :pacienteid", $array);
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Consulta ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id']);
        }
        return $final_answer;
    }

    public function listarCantidad($pagina,$cantidad,$id){

        $page=(($pagina - 1) * $cantidad);
        $answer = $this->query("SELECT * from consulta where paciente_id = :id LIMIT :pagina , :cantidad" , array(':pagina' => $page ,':cantidad'=> $cantidad ,':id'=> $id));
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new Consulta ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id']);
        }
        return $final_answer;                      
    }

    public function cantidad() {
        $answer = $this->queryList("select count(*) from consulta");
        return $answer;
    }





}