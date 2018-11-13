<?php


class EditarAtencion extends TwigView {
    
    public function  show($datos) {
        
         echo self::getTwig()->render('editarAtencion.html.twig',$datos);
        
        
    }


    
 }   