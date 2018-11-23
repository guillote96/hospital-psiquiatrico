<?php
require_once ('../vendor/vendor/autoload.php');
require_once ('db.php');

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
	$body->write('<html><body><h1>Slim API</h1></body></html>');
	$response->withHeader('Content-Type', 'text/html');
	return $response;
});


$app->get('/people', function ($request, $response, $args)   {
	return $response->withJson(getPeople(), 200);
});

$app->get('/people/{id}', function ($request, $response, $args) {
	return $response->withJson(getPerson($args['id']), 200);
});

$app->post('/people', function ($request, $response){

	$data = $request->getParsedBody();

	$name = $data['name'];
  	$surname = $data['surname'];
	$document = $data['document'];
	$pass = $data['pass'];
	$status = $data['status'];

	try {
        $count = addPerson($name,$surname,$document,$pass,$status);
		$response->withStatus(200);
		$body = $response->getBody();
		$response->withHeader('Content-Type', 'text/plain');
		if($count){
			$body->write("Person $name $surname ($document) added successfully!!!");
		}else{
			$body->write("Can't add person $name $surname ($document)");
		}
    } catch(\Exception $e) {
    	  var_dump($e->getMessage());

		$response->withStatus(500);
		$body = $response->getBody();
		$body->write("Error adding person!!!");
		$response->withHeader('Content-Type', 'text/plain');
    }
	return $response;
});

$app->delete('/people/{id}', function ($request, $response, $args) {
 	try {
        $count = delPerson($args['id']);
        $response->withStatus(200);
		$body = $response->getBody();
		$response->withHeader('Content-Type', 'text/plain');
		if($count){
			$body->write("Person id ".$args['id']." deleted successfully!!!");
		}else{
			$body->write("No person id ".$args['id']." deleted");
		}
    } catch(\Exception $e) {
		$response->withStatus(500);
		$body = $response->getBody();
		$body->write("Error deleting person!!!");
		$response->withHeader('Content-Type', 'text/plain');
    }

});


$app->put('/people', function ($request, $response){

	$data = $request->getParsedBody();

	$id = $data['id'];
	$name = $data['name'];
  	$surname = $data['surname'];
	$document = $data['document'];
	$pass = $data['pass'];
	$status = $data['status'];

	try {
        $count = updatePerson($id,$name,$surname,$document,$pass,$status);
		$response->withStatus(200);
		$body = $response->getBody();
		$response->withHeader('Content-Type', 'text/plain');
		if($count){
			$body->write("Person $name $surname ($document) updated successfully!!!");
		}else{
			$body->write("Can't update person $name $surname ($document)");
		}
    } catch(\Exception $e) {
    	  var_dump($e->getMessage());

		$response->withStatus(500);
		$body = $response->getBody();
		$body->write("Error updating person!!!");
		$response->withHeader('Content-Type', 'text/plain');
    }
	return $response;
});

$app->run();

?>
