<?php


class AgregarPaciente extends TwigView {
    
    public function show($partidos, $localidades,$obraSociales,$regionSanitaria,$generos,$tiposDoc) {
        
        echo self::getTwig()->render('agregarPaciente.html.twig', array('partidos' => $partidos,'localidades' => $localidades, 'obraSociales' => $obraSociales,'regionSanitaria' => $regionSanitaria ,'generos' => $generos, 'tiposDoc' => $tiposDoc));
        
        
    }
    
}
