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

    public function modificarConfiguracion($titulo,$descripcion,$email,$cantidad){
         $answer = $this->addObj("UPDATE configuracion SET valor='$titulo' WHERE id=1");
         $answer = $this->addObj("UPDATE configuracion SET valor='$descripcion' WHERE id=2");
         $answer = $this->addObj("UPDATE configuracion SET valor='$email' WHERE id=3");
         $answer = $this->addObj("UPDATE configuracion SET valor='$cantidad' WHERE id=4");
    }

    public function cantidadDeElementos(){
        $answer = $this->queryList("select valor from configuracion where id = 4");
        $final_answer = [];
        //$final_answer[] = new Configuracion($answer);
        return $answer;
    }
}