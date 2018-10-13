<?php


class HomeVerdadero extends TwigView {
    
    public function show($resources) {
        
        echo self::getTwig()->render('home.html',array('resources' =>$resources));
        
        
    }
    
}