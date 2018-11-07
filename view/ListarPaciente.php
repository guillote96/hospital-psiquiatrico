<?php


class ListarPaciente extends TwigView{

	public function show($resourceArray, $permisos) {
        
		echo self::getTwig()->render('listarPacientes.html.twig', array('resources' => $resourceArray, 'permisos' => $permisos));
		
	}
}