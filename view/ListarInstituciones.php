<?php


class ListarInstituciones extends TwigView {
    
    public function show($resourceArray) {
        
        echo self::getTwig()->render('listarInstituciones.html.twig', array('resources' => $resourceArray));
        
        
    }
    
}