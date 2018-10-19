<?php


class EditarPaciente extends TwigView {
    
   /* public function show($resources,$datos) {
        
         echo self::getTwig()->render('editarPaciente.html.twig', array('resources' => $resources,'datos' => $datos));
        
        
    }*/

    public function show($resources){
         echo self::getTwig()->render('editarPaciente.html.twig', array('resources' => $resources));

    }
 }   