<?php


class IniciarSesion extends TwigView {
    
    public function show() {
        
         echo self::getTwig()->render('login.html');
        
        
    }
 }   