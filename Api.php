<?php
require_once ('./vendor/vendor/autoload.php');
require_once('./controller/InstitucionController.php');
require_once('./model/PDORepository.php');
require_once('./model/PDOInstitucion.php');
require_once('./model/Institucion.php');



use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://api-referencias.proyecto2018.linti.unlp.edu.ar', 'timeout'  => 2.0]);




switch ($_GET['action']) {
    case '/instituciones':
        echo InstitucionController::getInstance()->institucionesJSON();
        return false;
        
    default:
        $msg['text']  = 'Lo siento ' . $response['message']['from']['first_name'] . ', pero [' . $cmd . '] no es un comando válido.' . PHP_EOL;
        $msg['text'] .= 'Prueba /help para ver la lista de comandos disponibles';
        break;
}



//echo $response->getBody();