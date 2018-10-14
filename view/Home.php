<?php


class Home extends TwigView {

    
    public function show() {
        
        echo self::getTwig()->render('home.html.twig');


    }

    public function inicio($resources) {
        
        echo self::getTwig()->render('home.html.twig',array('resources' =>$resources));
        
        
    }
    
}
