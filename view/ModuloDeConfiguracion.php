<?php


class ModuloDeConfiguracion extends TwigView {
    
    public function show($resourceArray) {
        
        echo self::getTwig()->render('configuracion.html.twig', array('resources' => $resourceArray));
        
        
    }
    
}