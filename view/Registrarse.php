<?php


class Registrarse extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('registrarse.html.twig');
        
        
    }
    
}
