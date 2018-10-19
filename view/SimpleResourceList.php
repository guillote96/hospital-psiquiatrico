<?php


class SimpleResourceList extends TwigView {
    
    /*public function show($resourceArray,$cantidad,$usuariosesion) {
        
        //echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray,'cantidad' => $cantidad,
          //  'usuario' => $usuariosesion));
         echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray));
        
    }*/

    public function show($resourceArray){

    	echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray));
    }
    
}