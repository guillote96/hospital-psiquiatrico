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

$app->get('/',  function ($request, $response, $args) {
	$response->withStatus(200);
	$body = $response->getBody();
	$body->write('<html><body><h1>API Instituciones</h1></body></html>');
	$response->withHeader('Content-Type', 'text/html');
	return $response;
});


$app->get('/instituciones', function ($request, $response, $args)   {
	return $response->withJson(InstitucionController::getInstance()->instituciones(), 200);
});


$app->get('/instituciones/{id}', function ($request, $response, $args) {
    return $response->withJson(InstitucionController::getInstance()->institucion($args['id']), 200);
});

$app->get('/instituciones/​region-sanitaria/{rs}',function ($request, $response, $args) {
 return $response->withJson(InstitucionController::getInstance()->institucionesPorRegion($args['​rs']),200);
});

$app->run();

?>
