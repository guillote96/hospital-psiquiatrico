<?php


class HomeVerdadero extends TwigView {
    
    public function show($resources) {
        
        echo self::getTwig()->render('home.html.twig',array('resources' =>$resources));
        
        
    }
    
}