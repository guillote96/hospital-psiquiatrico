<?php
  class Paciente {

private $apellido;
private $domicilio;
private $fecha_nac;
private $genero_id;
private $id;
private $localidad_id;
private $lugar_nac;
private $nombre;
private $nro_carpeta;
private $nro_historia_clinica;
private $numero;
private $obra_social_id;
private $region_sanitaria_id;
private $tel;
private $tiene_documento;
private $tipo_doc_id;
  
  public function __construct($apellido, $domicilio, $fecha_nac, $genero_id, $id, $localidad_id,$lugar_nac, $nombre, $nro_carpeta, $nro_historia_clinica, $numero, $obra_social_id, $region_sanitaria_id, $tel, $tiene_documento, $tipo_doc_id){
      

              $this->apellido = $apellido;
              $this->domicilio = $domicilio;
              $this->fecha_nac= $fecha_nac;
              $this->genero_id = $genero_id;
              $this->id = $id;
              $this->localidad_id = $localidad_id;
              $this->lugar_nac = $lugar_nac;
              $this->nombre = $nombre;
              $this->nro_carpeta = $nro_carpeta;
              $this->nro_historia_clinica = $nro_historia_clinica;
              $this->numero = $numero;
              $this->obra_social_id = $obra_social_id;
              $this->region_sanitaria_id = $region_sanitaria_id;
              $this->tel = $tel;
              $this->tiene_documento =$tiene_documento;
              $this->tipo_doc_id = $tipo_doc_id;
  }

      public function getApellido() {
        return $this->apellido;
      }

      public function getDomicilio() {
        return $this->domicilio;
      }

      public function getFechaNac() {
        return $this->fecha_nac;
      }
      public function getGeneroId() {
        return $this->genero_id;
      }
      public function getId() {
        return $this->id;
      }
      public function getLocalidadId() {
        return $this->localidad_id;
      }
      public function getLugarNac() {
        return $this->lugar_nac;
      }
     public function getNroCarpeta() {
        return $this->nro_carpeta;
      }
     public function getNroHistoriaClinica() {
        return $this->nro_historia_clinica;
      }

     public function getNumero() {
        return $this->numero;
      }

     public function getObraSocialId() {
        return $this->obra_social_id;
      }

     public function getRegionSanitariaId() {
        return $this->region_sanitaria_id;
      }
      public function getTel() {
        return $this->tel;
      }
      public function getNombre() {
        return $this->nombre;
      }
      public function getTieneDocumento() {
        return $this->tiene_documento;
      }
     public function getTipoDocId() {
        return $this->tipo_doc_id;
      }

  }