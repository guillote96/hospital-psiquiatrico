<?php


class EditarUsuario extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('editarUsuario.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos']));
        
        
    }
 }   