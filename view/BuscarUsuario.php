<?php


class BuscarUsuario extends TwigView {
    
   /* public function show($resources) {
        
         echo self::getTwig()->render('listResources.html.twig', array('resources' => $resources));
        
        
    }*/


       public function show($resourceArray, $permisos){

    	echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray,'permisos' => $permisos ));
    }
 }   