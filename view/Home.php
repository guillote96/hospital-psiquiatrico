<?php


class Home extends TwigView {

    
    public function show() {
        
        echo self::getTwig()->render('home.html.twig');


    }

    public function inicio($resources) {
        echo self::getTwig()->render('home.html.twig',array('resources' => $resources, 'permisos' => $resources['permisos']));

        
    }
	
	public function inicioSinSesion($titulo,$descripcion,$email){
		echo self::getTwig()->render('home.html.twig', array('titulo' => $titulo,'descripcion' => $descripcion, 'email' => $email));
	}

    public function sitioDeshabilitado($titulo){

    	echo self::getTwig()->render('mantenimiento.html.twig',array('titulo' => $titulo));
    }
    
}
