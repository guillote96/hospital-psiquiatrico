<?php


class AgregarPaciente extends TwigView {
    
    public function show() {
        
        echo self::getTwig()->render('agregarPaciente.html.twig');
        
        
    }
    
}
