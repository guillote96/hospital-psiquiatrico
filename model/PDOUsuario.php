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

    public function actualizar_usuario($usuario,$email,$nombre,$apellido,$activo,$id){
         $answer = $this->addObj("UPDATE usuario SET email='$email', username='$usuario', activo='$activo', first_name='$nombre', last_name='$apellido' WHERE id='$id'");
    }

    public function traer_usuario($id){
        $answer = $this->queryList("select * from usuario WHERE id='$id'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Usuario($element['id'],$element['email'],$element['username'],$element['password'],$element['activo'],$element['updated_at'],$element['created_at'],$element['first_name'],$element['last_name']);
        }
        return $final_answer;

  }

    public function agregar_usuario($usuario,$email,$password,$nombre,$apellido,$activo){
        $answer = $this->addObj("INSERT INTO usuario (email, username, password, activo, updated_at, created_at, first_name, last_name) VALUES ('$email', '$usuario', '$password', '$activo','updated_at','created_at','$nombre','$apellido')");
        
    }

    public function eliminar_usuario($id){
        $answer = $this->addObj("DELETE FROM usuario WHERE id='$id'");
    }


        public function verificar_password($username, $password){
        $answer = $this->queryList("select * from usuario WHERE username='$username'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Usuario($element['id'],$element['email'],$element['username'],$element['activo'],$element['password'],$element['updated_at'],$element['created_at'],$element['first_name'],$element['last_name']);
        }
        if($password == ($final_answer[0]->getPassword())){
                
                return true;
        }

        return false;

    }

    public function buscarPorUsername($username){
        $answer = $this->queryList("select * from usuario WHERE username='$username'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Usuario($element['id'],$element['email'],$element['username'],$element['activo'],$element['password'],$element['updated_at'],$element['created_at'],$element['first_name'],$element['last_name']);
        }
        return $final_answer;

    }

    public function buscarPorActivo($valor){
        $answer = $this->queryList("select * from usuario WHERE activo='$valor'");
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Usuario($element['id'],$element['email'],$element['username'],$element['activo'],$element['password'],$element['updated_at'],$element['created_at'],$element['first_name'],$element['last_name']);
        }
        return $final_answer;

    }


}