<?php


class BuscarPaciente extends TwigView {
    
    public function show($resources) {
        
       	if($resources['mensajeError']==null){
      	 	 echo self::getTwig()->render('buscarPaciente.html.twig',array('resources' => $resources,'permisos' => $resources['permisos'],'tiposDoc' => $resources['tiposDoc']));
      	 }
      	else{
      	 	 echo self::getTwig()->render('buscarPaciente.html.twig',array('resources' => $resources,'permisos' => $resources['permisos'],'tiposDoc' => $resources['tiposDoc'], 'mensajeError' => $resources['mensajeError']));
      	 }
        
        
    }
    
}
