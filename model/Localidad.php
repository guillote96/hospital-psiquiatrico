<?php

class Localidad {
    
   private $name;
   private $id;
    private $partido_id;
    
    public function __construct($name, $id, $partido_id) {
        $this->name = $name;
        $this->id= $id;
        $this->partido_id= $partido_id;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }
    public function getPartidoId() {
        return $this->partido_id;
    }
}
