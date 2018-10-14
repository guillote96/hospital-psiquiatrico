<?php

class Configuracion {
    
    private $variable;
    private $valor;
    
    public function __construct($variable, $valor) {
        $this->variable = $variable;
        $this->valor = $valor;
    }

    public function getVariable() {
        return $this->variable;
    }

    public function getValor() {
        return $this->valor;
    }
}