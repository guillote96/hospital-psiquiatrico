<?php


class EditarRol extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('editarRol.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos']));
        
        
    }
 }   