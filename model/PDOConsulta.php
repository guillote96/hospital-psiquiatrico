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

        $page=($pagina - 1);
        $answer = $this->query("select * from consulta where paciente_id = :id LIMIT :pagina ,:cantidad" , array(":id"=> $id,":pagina" => $page ,":cantidad"=> $cantidad));
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new Consulta ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id']);
        }
        return $final_answer;                      
    }

    public function cantidad($idPaciente) {
        $answer = $this->query("select count(*) from consulta where paciente_id = :id", array(":id"=> $idPaciente));
        return $answer;
    }

    public function cantidadDeConsultasPorGenero($idGenero){
        $answer = $this->query("SELECT COUNT(*) FROM consulta INNER JOIN paciente ON (consulta.paciente_id = paciente.id) INNER JOIN genero ON (paciente.genero_id = genero.id) WHERE genero.id = :id", array(':id' => $idGenero));
        return $answer[0][0];
    }

    public function consultasPorGenero(){
        $answer = $this->query("SELECT c.id,c.paciente_id,c.fecha,c.motivo_id,c.derivacion_id,c.articulacion_con_instituciones,c.internacion,c.diagnostico,c.observaciones,c.tratamiento_farmacologico_id,c.acompanamiento_id,p.nombre,p.apellido,g.nombre as criterio,l.nombre as localidad FROM consulta as c INNER JOIN paciente as p ON (c.paciente_id = p.id) INNER JOIN genero as g ON (p.genero_id = g.id) INNER JOIN localidad as l ON(p.localidad_id = l.id) ORDER BY g.id", array());
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new ConsultaDetallada ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id'],$element['nombre'],$element['apellido'],$element['criterio']);
        }
        return $final_answer;   
    }

    public function consultasPorLocalidad(){
        $answer = $this->query("SELECT c.id,c.paciente_id,c.fecha,c.motivo_id,c.derivacion_id,c.articulacion_con_instituciones,c.internacion,c.diagnostico,c.observaciones,c.tratamiento_farmacologico_id,c.acompanamiento_id,p.nombre,p.apellido,g.nombre as genero,l.nombre as criterio FROM consulta as c INNER JOIN paciente as p ON (c.paciente_id = p.id) INNER JOIN genero as g ON (p.genero_id = g.id) INNER JOIN localidad as l ON(p.localidad_id = l.id) ORDER BY l.id", array());
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new ConsultaDetallada ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id'],$element['nombre'],$element['apellido'],$element['criterio']);
        }
        return $final_answer;    
    }

    public function consultasPorMotivo(){
        $answer = $this->query("SELECT c.id,c.paciente_id,c.fecha,c.motivo_id,c.derivacion_id,c.articulacion_con_instituciones,c.internacion,c.diagnostico,c.observaciones,c.tratamiento_farmacologico_id,c.acompanamiento_id,p.nombre,p.apellido,mc.nombre as criterio,l.nombre as localidad FROM consulta as c INNER JOIN paciente as p ON (c.paciente_id = p.id) INNER JOIN motivo_consulta as mc ON (c.motivo_id = mc.id) INNER JOIN localidad as l ON(p.localidad_id = l.id) ORDER BY l.id", array());
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new ConsultaDetallada ($element['id'],$element['paciente_id'],$element['fecha'],$element['motivo_id'],$element['derivacion_id'],$element['articulacion_con_instituciones'],$element['internacion'],$element['diagnostico'],$element['observaciones'],$element['tratamiento_farmacologico_id'],$element['acompanamiento_id'],$element['nombre'],$element['apellido'],$element['criterio']);
        }
        return $final_answer;
        var_dump($final_answer);
    }

    public function ConsultasAgrupadasPorLocalidad(){
        $answer = $this->query("SELECT l.id, l.nombre as localidad, l.partido_id, COUNT(l.id) as cantidad FROM consulta as c INNER JOIN paciente as p ON (c.paciente_id = p.id) INNER JOIN genero as g ON (p.genero_id = g.id) INNER JOIN localidad as l ON(p.localidad_id = l.id) GROUP BY l.id", array());
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new Localidad ($element['localidad'],$element['cantidad'],$element['partido_id']);
        }
        return $final_answer;
    }

    public function ConsultasAgrupadasPorMotivo(){
        $answer = $this->query("SELECT mc.id, mc.nombre as motivo, COUNT(mc.id) as cantidad FROM consulta as c INNER JOIN motivo_consulta as mc ON (c.motivo_id = mc.id) GROUP BY mc.id", array());
        $final_answer=[];
        foreach ($answer as &$element) {
            $final_answer[] = new MotivoConsulta ($element['motivo'],$element['cantidad']);
        }
        return $final_answer;
    }


}