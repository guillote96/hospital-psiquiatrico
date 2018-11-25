<?php

class ConsultaDetallada {

    private $id;
    private $paciente_id;
    private $fecha;
    private $motivo_id;
    private $derivacion_id;
    private $articulacion_con_instituciones;
    private $internacion;
    private $diagnostico;
    private $observaciones;
    private $tratamiento_farmacologico_id;
    private $acompanamiento_id;
    private $nombre;
    private $apellido;
    private $genero;
    private $localidad;
    private $latitud;
    private $longitud;

    public function __construct($id,$paciente_id,$fecha,$motivo_id,$derivacion_id,$articulacion_con_instituciones,$internacion,$diagnostico,$observaciones,$tratamiento_farmacologico_id,$acompanamiento_id,$nombre,$apellido,$criterio,$latitud,$longitud) {
        $this->id=$id;
            $this->paciente_id=$paciente_id;
            $this->fecha=$fecha;
            $this->motivo_id=$motivo_id;
            $this->derivacion_id=$derivacion_id;
            $this->articulacion_con_instituciones=$articulacion_con_instituciones;
            $this->internacion=$internacion;
            $this->diagnostico=$diagnostico;
            $this->observaciones=$observaciones;
            $this->tratamiento_farmacologico_id=$tratamiento_farmacologico_id;
            $this->acompanamiento_id=$acompanamiento_id;
            $this->nombre=$nombre;
            $this->apellido=$apellido;
            $this->criterio=$criterio;
            $this->latitud=$latitud;
            $this->longitud=$longitud;
    }

    public function getId() {
        return $this->id;
    }


     public function getPacienteId() {
        return $this->paciente_id;

    } 

    public function getFecha() {
        return $this->fecha;

    }
     public function getMotivoId() {
        return $this->motivo_id;
    } 
    public function getDerivacionId() {
        return $this->derivacion_id;
    } 

    public function getArticulacion() {
        return $this->articulacion_con_instituciones;
    } 

    public function getInternacion() {
        return $this->internacion;
    } 

    public function getDiagnostico() {
        return $this->diagnostico;
    } 

    public function getObservacion() {
        return $this->observaciones;
    } 

    public function getTratamientoFarmacologicoId() {
        return $this->tratamiento_farmacologico_id;
    }

    public function getAcompanamientoId() {
        return $this->acompanamiento_id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getCriterio() {
        return $this->criterio;
    }

    public function getLatitud() {
        return $this->latitud;
    }

    public function getLongitud() {
        return $this->longitud;
    }
}