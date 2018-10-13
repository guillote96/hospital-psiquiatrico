<?php
 class ListarPaciente extends TwigView{
    
        public function show($resourceArray) {
        
            echo self::getTwig()->render('listarPacientes.html.twig', array('resources' => $resourceArray));
        
        
         }




 }