<?php


class Reportes extends TwigView {
    
    public function show($resources) {
        
        echo self::getTwig()->render('reportes.html.twig',array('resources' => $resources));
        
        
    }
    
}