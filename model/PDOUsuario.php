<?php

class PDOUsuario extends PDORepository {

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
        $answer = $this->queryList("select * from usuario");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Usuario($element['id'],$element['email'],$element['username'],$element['password'],$element['activo'],$element['updated_at'],$element['created_at'],$element['first_name'],$element['last_name']);
        }
        return $final_answer;

                         
    }

    public function existe_usuario($username){
        $answer = $this->queryList("select * from usuario where username='$username'");
        if (count($answer) > 0){
            return true;
        }

        return false;
    }

}