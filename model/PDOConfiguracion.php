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

    public function modificarConfiguracion($titulo,$descripcion,$email,$cantidad,$estado){
         $answer = $this->addObj("UPDATE configuracion SET valor='$titulo' WHERE variable= 'titulo'");
         $answer = $this->addObj("UPDATE configuracion SET valor='$descripcion' WHERE variable='descripcion'");
         $answer = $this->addObj("UPDATE configuracion SET valor='$email' WHERE variable='email'");
         $answer = $this->addObj("UPDATE configuracion SET valor='$cantidad' WHERE variable='cantidadDeElementos'");
         $answer = $this->addObj("UPDATE configuracion SET valor='$estado' WHERE variable='estado'");
    }

    public function cantidadDeElementos(){
        $answer = $this->queryList("select valor from configuracion where variable = 'cantidadDeElementos'");
        return $answer;
    }

    public function cantDePaginas($cantRegistros){
         //ATENCION: DEVUELVE CANT DE PAGINAS Y DE ELEMENTOS EN UN ARREGLO!!!! Llamarlo donde se necesite paginado
        
        $cantidadDeElementosPorPagina = PDOConfiguracion::getInstance()->cantidadDeElementos();
        $cantidadDeRegistros = $cantRegistros;
        $cantElementos=$cantidadDeElementosPorPagina[0][0];
        $cantRegistros =$cantidadDeRegistros[0][0];
        $cantidadDePaginas = ceil($cantRegistros / $cantElementos);
        return array('cantidadPaginas' =>$cantidadDePaginas, 'cantidadElementos' => $cantElementos);
    }
}