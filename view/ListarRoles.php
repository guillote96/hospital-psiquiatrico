<?php


class ListarRoles extends TwigView {
    
    public function show($resources, $permisos) {
        
         echo self::getTwig()->render('roles.html.twig', array('resources' => $resources, 'permisos' => $permisos));
        
        
    }
 }   