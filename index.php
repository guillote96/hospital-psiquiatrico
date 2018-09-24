<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/LocalidadController.php');
require_once('model/PDORepository.php');
require_once('model/PDOLocalidad.php');
require_once('model/Localidad.php');
require_once('view/TwigView.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');


//echo "hola";
if(isset($_GET["action"]) && $_GET["action"] == 'listResources'){
    LocalidadController::getInstance()->listResources();
}else{
    LocalidadController::getInstance()->home();
}