<?php


class MisPermisos extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('misPermisos.html.twig', array('resources' => $resources));
        
    }
 }   