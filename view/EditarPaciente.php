<?php


class EditarPaciente extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('editarPaciente.html.twig', array('resources' => $resources));
        
        
    }
 }   