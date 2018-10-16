<?php


class AgregarRol extends TwigView {
    
    public function show($usuario, $resources, $misRoles) {
        
         echo self::getTwig()->render('agregarRol.html.twig', array('resources' => $resources,'usuario' => $usuario,'misRoles' => $misRoles));
        
        
    }
 }   