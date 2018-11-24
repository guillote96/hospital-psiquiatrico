<?php
require_once ('../vendor/vendor/autoload.php');
require_once ('../controller/InstitucionController.php');
require_once ('../model/PDORepository.php');
require_once ('../model/PDOInstitucion.php');
require_once ('../model/Institucion.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($config);


$app->group('/instituciones', function() use ($app) {

   $app->get('', function ($request, $response, $args)   {
	return $response->withJson(InstitucionController::getInstance()->instituciones(), 200);
   });


   $app->get('/{id}', function ($request, $response, $args) {
   return $response->withJson(InstitucionController::getInstance()->institucion($args['id']), 200);
   });

   $app->get('/region-sanitaria/{rs}', function ($request, $response, $args) {
     return $response->withJson(InstitucionController::getInstance()->institucionesPorRegion($args["rs"]),200);


    });

});

$app->run();

?>
