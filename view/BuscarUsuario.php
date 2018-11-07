<?php


class BuscarUsuario extends TwigView {
    
    public function show($resources) {
        
       	if($resources['mensajeError']==null){
      	 	 echo self::getTwig()->render('buscarUsuario.html.twig',array('resources' => $resources,'permisos' => $resources['permisos']));
      	 }
      	else{
      	 	 echo self::getTwig()->render('buscarUsuario.html.twig',array('resources' => $resources,'permisos' => $resources['permisos'], 'mensajeError' => $resources['mensajeError']));
      	 }
        
        
    }
 }   