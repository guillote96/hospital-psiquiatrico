<?php


class SimpleResourceList extends TwigView {
    
    public function show($resourceArray,$cantidad) {
        
        echo self::getTwig()->render('listResources.html.twig', array('resources' => $resourceArray,'cantidad' => $cantidad));
        
        
    }
    
}