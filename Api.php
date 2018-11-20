<?php
require_once ('./vendor/vendor/autoload.php');

use GuzzleHttp\Client;

$client = new Client(['base_uri' => 'https://api-referencias.proyecto2018.linti.unlp.edu.ar/', 'timeout'  => 2.0]);

$response = $client->request('GET', 'obra-social');

echo $response->getBody();