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
    public function traer_permisos_usuario($id){
        $final_answer = [];
        $answer = $this->queryList("select * from permiso INNER JOIN rol_tiene_permiso ON permiso.id = rol_tiene_permiso.permiso_id INNER JOIN usuario_tiene_rol ON rol_tiene_permiso.rol_id = usuario_tiene_rol.rol_id  WHERE usuario_id=$id");     
        foreach ($answer as &$element) {
            $final_answer[] = new Permiso($element['nombre'],$element['id']);
            
        }
        
        return $final_answer;
    }

    public function existe_permiso($nombre, $id){
        if($id!=null){
            $answer = $this->queryList("select * from permiso where nombre='$nombre' AND id<>'$id'");       
        }
        else{
            $answer = $this->queryList("select * from permiso where nombre='$nombre'");
        }
        if (count($answer) > 0){
                return true;
            }   

        return false;
    }

    public function alta_permiso($nombre, $rol){
        $answer = $this->addObj("INSERT INTO permiso (nombre) VALUES ('$nombre')"); 
        $idP = $this->traer_id($nombre);  
        if($rol!=null){
            foreach ($rol as &$element) {
              $answer = $this->addObj("INSERT INTO rol_tiene_permiso (rol_id, permiso_id) VALUES($element, $idP[0])");
             }
        }     
    }

    public function eliminar_permiso($id){
        $answer = $this->addObj("DELETE FROM rol_tiene_permiso WHERE permiso_id='$id'");
        $answer = $this->addObj("DELETE FROM permiso WHERE id='$id'");
    }

    public function traer_permiso($id){
        $answer = $this->queryList("select * from permiso WHERE id='$id'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Permiso($element['nombre'],$element['id']);
        }
        return $final_answer;

    }

    public function traer_id($nombre){
        $answer = $this->queryList("select id from permiso WHERE nombre='$nombre'");
        return $answer[0];

    }

    public function actualizar_permiso($nombre,$rol, $id){
         $answer = $this->addObj("UPDATE permiso SET nombre= '$nombre' WHERE id='$id'");
         $roles = PDORol::getInstance()->traer_roles();
         $answer = $this->addObj("DELETE FROM rol_tiene_permiso WHERE permiso_id='$id'");
         if($rol!=null){
            foreach ($rol as &$element) {
                 $answer = $this->addObj("INSERT INTO rol_tiene_permiso (rol_id, permiso_id) VALUES($element, $id)");
             }
         }
    }

    public function traer_roles_permiso($id){
        $answer = $this->queryList("SELECT DISTINCT rol_id FROM rol_tiene_permiso WHERE permiso_id = '$id'");
        $array  = array();
        $i = 0;
        foreach($answer as &$element){
            $array[$i] = $element[0];
            $i++;

        }
        return $array;
    }


}