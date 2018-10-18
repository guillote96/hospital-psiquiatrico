<?php


class PDOLocalidad extends PDORepository {

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
        $answer = $this->queryList("select * from localidad");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Localidad($element['nombre'],$element['id'],$element['partido_id']);
        }
        return $final_answer;
    }

}
