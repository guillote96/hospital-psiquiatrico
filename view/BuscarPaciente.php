<?php


class BuscarPaciente extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('buscarPaciente.html.twig');
        
        
    }
    
}
