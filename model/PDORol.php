<?php

class PDORol extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function traer_roles() {
        $answer = $this->queryList("select * from rol");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Rol($element['nombre'],$element['id']);
        }
        return $final_answer;
    }

     public function traer_roles_usuario($id) {
        $answer = $this->queryList("select * from rol INNER JOIN usuario_tiene_rol ON rol.id = usuario_tiene_rol.rol_id WHERE usuario_id=$id");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Rol($element['nombre'],$element['id']);
        }
        return $final_answer;
    }
  
     public function traer_roles_noUsuario($id) {
        $answer = $this->queryList("select * from rol WHERE id NOT IN (SELECT rol_id from usuario_tiene_rol WHERE  usuario_id=$id)");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Rol($element['nombre'],$element['id']);
        }
        return $final_answer;
    }

}