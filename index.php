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

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./templates/');
};

// Registrando um componente de conexão ao banco de dados
$container['connect'] = function ($container) {    
    return new \Gafp\Connect; //conexão com banco
};

// Registrando um componente de conexão ao banco de dados
$container['authUser'] = function ($container) {
    return new \Gafp\User; //usuários
};

//Inicializar a autenticação de usuário
$checkUser = function($request, $response, $next){    
    $qry = $this->connect->pdo->select()->from('pa_users');    
    $result = $qry->execute()->fetch();    
    $response->getBody()->write($result);
    return ($this->withJson($result));
};

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response, $args ) {    
    return $this->view->render($response, 'index.php', []); //Carrega template
})->setname('index');

//URL para envio de credenciais para login
$app->post('login/', function (Request $request) {
    $request->getParsedBody();
    $login_data = [];
    $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_STRING);
    $login_data['senha'] = filter_var($data['senha'], FILTER_SANITIZE_STRING);

    $query = $this->connect->pdo->select()->from('pa_users');    
    $result = $query->execute()->fetch();    
    
    return $response;
});

/*//URL para envio de credenciais para login
$app->map(['GET', 'POST'], '/login', function (Request $request, Response $response) {
    
    $response->getBody()->write('teste');
    return $response;

});*/

$app->run();

