<?php

class PDOPermiso extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function traer_permisos() {
        $answer = $this->queryList("select * from permiso");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Permiso($element['nombre'],$element['id']);
        }
        return $final_answer;
    }

     public function traer_permisos_rol($id) {
        $answer = $this->queryList("select * from permiso INNER JOIN rol_tiene_permiso ON permiso.id = rol_tiene_permiso.permiso_id WHERE rol_id=$id");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Permiso($element['nombre'],$element['id']);
        }
        return $final_answer;
    }
    public function traer_permisos_usuario($id, $misRoles){
        $final_answer = [];
        foreach ($misRoles as &$rol) {
            $idR = $rol->getId();
            $answer = $this->queryList("select * from permiso INNER JOIN rol_tiene_permiso ON permiso.id = rol_tiene_permiso.permiso_id INNER JOIN usuario_tiene_rol ON rol_tiene_permiso.rol_id = usuario_tiene_rol.rol_id  WHERE usuario_id=$id");
        }      
        foreach ($answer as &$element) {
            $final_answer[] = new Permiso($element['nombre'],$element['id']);
            
        }
        return $final_answer;
    }


}