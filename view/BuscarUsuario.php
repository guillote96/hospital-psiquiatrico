<?php


class BuscarUsuario extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('listResources.html.twig', array('resources' => $resources));
        
        
    }
 }   