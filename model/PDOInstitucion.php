<?php

class PDOInstitucion extends PDORepository {

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
        $answer = $this->queryList("select * from institucion");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Institucion($element['nombre'],$element['director'],$element['telefono'],$element['region_sanitaria_id'],$element['tipo_institucion_id']);
        }
        return $final_answer;
    }

}