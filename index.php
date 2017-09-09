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


/* #CONTAINERS ----------------------------------------------*/

// Get container e dependências
$container = $app->getContainer();

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./gafp/src/templates/');
};

// Registrando um componente de conexão ao banco de dados
$container['connect'] = function ($container) {
    return new \Gafp\Connect; //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['user'] = function ($container) {
    $connect = new \Gafp\Connect;
    return new \Gafp\User($connect); //usuários
};

/* #MIDDLEWARES ----------------------------------------------*/


//Verifica se user esta logado, se não volta para a tela de login
$userLogged = function (Request $request, Response $response, $next){

    if( $this->user->isLogged() ):
        //Redireciona ao painel
        return $this->user->logged($response);
    else:
        //Destroi sessão e volta tela de login
        return $this->user->logout($response);
    endif;

    $next($request, $response);

    return $response;
};

/* #ROUTES ----------------------------------------------*/

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response ) {    
    return $this->view->render($response, 'login.php', []); //Carrega template
})->setname('login');

//URL para envio de credenciais para login
$app->post('/login', function (Request $request, Response $response, $args) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->user->login($data); //Executa query
    
    $response->getBody()->write($result); //Enviando dados para função User->login

    return $response;
});

//Desloga e finaliza sessão
$app->get('/logout', function (Request $request, Response $response) {    
    return $this->user->logout($response); //Executa função deslogar
});

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'painel.php', []); //Carrega template "painel"
})->setname('painel');

//Retorna lista de planos
$app->get('/plans', function (Request $request, Response $response){
    
    $id = $this->user->user['id'];
    $response = $response->withJson($this->connect->getPlans('1')); //Enviando dados para função User->login
    
    return $response;
});


/* #APP INIT ----------------------------------------------------*/

$app->run();

