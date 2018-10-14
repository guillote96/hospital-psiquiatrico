<?php


class PDOConfiguracion extends PDORepository {

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
        $answer = $this->queryList("select * from configuracion");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Configuracion($element['variable'],$element['valor']);
        }
        return $final_answer;
    }

}