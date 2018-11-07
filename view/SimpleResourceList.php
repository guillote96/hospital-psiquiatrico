<?php


class SimpleResourceList extends TwigView {


    public function show($resourceArray, $permisos){

    	echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray,'permisos' => $permisos ));
    }
    
}