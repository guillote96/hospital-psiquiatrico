<?php


class ListarPermisos extends TwigView {
    
    public function show($resources, $permisos) {
        
         echo self::getTwig()->render('permisos.html.twig', array('resources' => $resources, 'permisos' => $permisos));
        
        
    }
 }   