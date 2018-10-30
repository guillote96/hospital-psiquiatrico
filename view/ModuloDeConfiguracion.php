<?php


class ModuloDeConfiguracion extends TwigView {
    
    public function show($resourceArray, $permisos) {
        
        echo self::getTwig()->render('configuracion.html.twig', array('resources' => $resourceArray, 'permisos' => $permisos));
        
        
    }
    
}