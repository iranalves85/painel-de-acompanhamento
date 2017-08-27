<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App;


$app->get('/', function (Request $request, Response $response) {

    $user = new \GAFP\User;

    $response->getBody()->write('teste');

    return $response;
});


$app->run();

