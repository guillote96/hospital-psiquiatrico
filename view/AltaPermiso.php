<?php


class AltaPermiso extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('agregarPermiso.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos'], 'roles' => $resources['roles']));     
    

    }
 }   