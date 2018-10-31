<?php


class Error extends TwigView {
    
    public function show($resources) {
        
        echo self::getTwig()->render('error.html.twig',$resources);
        
        
    }
    
}