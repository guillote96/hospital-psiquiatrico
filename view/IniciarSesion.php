<?php


class IniciarSesion extends TwigView {


    public function show($resources) {
        
         echo self::getTwig()->render('login.html.twig',$resources);
        
        
    }
 }   