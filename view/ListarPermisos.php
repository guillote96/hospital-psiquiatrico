<?php


class ListarPermisos extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('permisos.html.twig', array('resources' => $resources));
        
        
    }
 }   