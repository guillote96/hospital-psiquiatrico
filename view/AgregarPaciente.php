<?php


class AgregarPaciente extends TwigView {
    
    public function show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc,$username,$titulo) {
        
        echo self::getTwig()->render('agregarPaciente.html.twig', array('partidos' => $partidos,'localidades' => $localidades, 'obraSociales' => $obraSociales,'regionSanitaria' => $regionSanitaria ,'generos' => $generos, 'tiposDoc' => $tiposDoc, 'resources' => array('usuario' => $username, 'titulo' => $titulo)));
        
        
    }
    
}
