<?php


class EditarPermiso extends TwigView {
    
    public function show($resources) {
        
         echo self::getTwig()->render('editarPermiso.html.twig', array('resources' => $resources, 'permisos' => $resources['permisos'], 'roles'=>$resources['roles'], 'asignados'=>$resources['asignados']));
        
        
    }
 }   