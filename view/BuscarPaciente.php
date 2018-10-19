<?php


class BuscarPaciente extends TwigView {
    
    public function show($resources) {
        
        echo self::getTwig()->render('buscarPaciente.html.twig',array('resources' => $resources));
        
        
    }
    
}
