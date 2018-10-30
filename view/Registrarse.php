<?php


class Registrarse extends TwigView {
    
    public function show($resources) {
      
        echo self::getTwig()->render('registrarse.html.twig',array('resources' => $resources, 'permisos' => $resources['permisos']));
        
        
    }
    
}
