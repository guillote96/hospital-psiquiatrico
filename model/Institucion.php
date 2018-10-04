<?php

class Institucion {
    
    private $nombre;
    private $director;
    private $telefono;
    private $region_sanitaria_id;
    private $tipo_institucion_id;
    
    public function __construct($nombre, $director, $telefono, $region_sanitaria_id, $tipo_institucion_id) {
        $this->nombre = $nombre;
        $this->director= $director;
        $this->telefono = $telefono;
        $this->region_sanitaria_id = $region_sanitaria_id;
        $this->tipo_institucion_id = $tipo_institucion_id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDirector() {
        return $this->director;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getRegionSanitariaId() {
        return $this->region_sanitaria_id;
    }

    public function getTipoInstitucionId() {
        return $this->tipo_institucion_id;
    }
}