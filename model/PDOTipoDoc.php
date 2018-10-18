<?php


class PDOTipoDoc extends PDORepository {

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
        $answer = $this->queryList("select * from tipo_documento");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new TipoDoc($element['nombre'],$element['id']);
        }
        return $final_answer;
    }

}
