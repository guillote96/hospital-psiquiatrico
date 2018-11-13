<?php


class ListarAtenciones extends TwigView {


    public function show($datos){

    	echo self::getTwig()->render('listarAtenciones.html.twig',$datos);
    }
    
}