<?php

class Localidad {
    
    private $name;
    private $partido_id;
    
    public function __construct($name, $partido_id) {
        $this->name = $name;
        $this->partido_id= $partido_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPartidoId() {
        return $this->partido_id;
    }
}
