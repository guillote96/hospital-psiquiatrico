<?php


class Acceso extends TwigView {
    
    public function  noautorizado($resources) {
        
         echo self::getTwig()->render('acceso.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos']));
        
        
    }
 }   