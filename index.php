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
require_once('controller/UsuarioController.php');
require_once('model/PDOUsuario.php');
require_once('model/Usuario.php');




if(isset($_GET["action"]) && $_GET["action"] == 'listResources'){
    UsuarioController::getInstance()->listResources();
}else{
    UsuarioController::getInstance()->home();
}