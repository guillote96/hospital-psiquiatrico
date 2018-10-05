<?php

class PDOObraSocial extends PDORepository {

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
        $answer = $this->queryList("select * from obra_social");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new ObraSocial($element['nombre']);
        }
        return $final_answer;
    }

}