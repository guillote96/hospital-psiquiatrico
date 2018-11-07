<?php


class EditarPaciente extends TwigView {

    public function show($resources, $permisos){
         
         echo self::getTwig()->render('editarPaciente.html.twig', array('resources' => $resources, 'permisos' =>$permisos));

    }
 }   