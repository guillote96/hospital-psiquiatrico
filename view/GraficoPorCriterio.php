<?php


class GraficoPorCriterio extends TwigView {


    public function show($resources){

    	echo self::getTwig()->render('graficoPorCriterio.html.twig', array('resources' => $resources));
    }
    
}