<?php

class PDOMotivoConsulta extends PDORepository {

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
        $answer = $this->queryList("select * from motivo_consulta");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new MotivoConsulta($element['nombre'],$element['id']);
        }
        return $final_answer;
    }

}