<?php


class IniciarSesion extends TwigView {
    
    public function show($titulo) {
        
         echo self::getTwig()->render('login.html.twig',array('titulo' => $titulo));
        
        
    }
 }   