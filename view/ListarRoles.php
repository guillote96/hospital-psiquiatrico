<?php


class ListarRoles extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('roles.html.twig', array('resources' => $resources));
        
        
    }
 }   