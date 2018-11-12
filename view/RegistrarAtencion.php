<?php


class RegistrarAtencion extends TwigView {
    
    public function  show($datos) {
        
         echo self::getTwig()->render('registrarAtencion.html.twig',$datos);
        
        
    }


    
 }   