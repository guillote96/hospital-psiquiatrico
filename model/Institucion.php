<?php

class Institucion {
    public $id;
    public $nombre;
    public $director;
    public $telefono;
    public $region_sanitaria_id;
    public $tipo_institucion_id;
    
    public function __construct($id,$nombre, $director, $telefono, $region_sanitaria_id, $tipo_institucion_id) {
        $this->id=$id;
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