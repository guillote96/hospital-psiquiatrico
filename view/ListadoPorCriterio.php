<?php


class ListadoPorCriterio extends TwigView {
    
    public function show($resources) {

        echo self::getTwig()->render('listadoPorCriterio.html.twig', array('resources' => $resources));
        
        
    }
    
}