<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'gafp/autoload.php';

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app = new \Slim\App($config);

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('');
};

//Inicializar a autenticação de usuário
$mw = function($request, $response, $next){
    
    $userConnect = new \Gafp\Connect;
    $userAuth = new \Gafp\User;

    $qry = $userConnect->pdo->select()->from('pa_users');
    
    $result = $qry->execute()->fetch();
    
    $response->getBody()->write($result);
    
    return $response;
};

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response, $args ) {
    
    return $this->view->render($response, 'index.html', [ 
        'name'=> $args['name']
    ]);

})->setname('login');

//URL para envio de credenciais
$app->post('/login', function (Request $request, Response $response, $args) {
    
    $response->getBody()->write($args);

    return json_encode($response);

});


$app->run();

