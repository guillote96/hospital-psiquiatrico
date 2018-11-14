<?php


class AltaRol extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('altaRol.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos']));     
    

    }
 }   