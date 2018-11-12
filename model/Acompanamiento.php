<?php

class Acompanamiento {
    
    private $nombre;
    private $id;
    
    public function __construct($nombre,$id) {
        $this->nombre = $nombre;
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getId() {
        return $this->id;
    }


}