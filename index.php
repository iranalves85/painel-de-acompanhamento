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
    return new  \Gafp\Connect(); //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['user'] = function ($container) {
    return new \Gafp\User(); //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['data'] = function ($container) {
    return new \Gafp\Data(); //usuários
};

/* #MIDDLEWARES ----------------------------------------------*/


//Verifica se user esta logado, se não volta para a tela de login
$userLogged = function (Request $request, Response $response, $next){
    
    if(! $this->user->is_user_logged()){
        
    }
    $next($request, $response);
    return $response;
};

//Chamado em cada requisição http da app
$loggin = function (Request $request, Response $response, $next){
    
};


/* #ROUTES ----------------------------------------------*/

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response ) {    
    return $this->view->render($response, 'login.php', []); //Carrega template
})->setname('login')->add($userLogged);

//URL para envio de credenciais para login
$app->post('/login', function (Request $request, Response $response, $args) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array
    $login_data = [];
    $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_STRING); //aplicando filtro de string
    $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string
    
    $response->getBody()->write($this->user->login($login_data['email'], $login_data['pass'], $this->connect)); //Enviando dados para função User->login

    return $response;

});

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'painel.php', []); //Carrega template

})->setname('painel')->add($userLogged);

//Retorna lista de planos
$app->get('/plans', function (Request $request, Response $response){
    
    $response = $response->withJson($this->data->getPlans($this->connect)); //Enviando dados para função User->login
    
    return $response;
});


/* #APP INIT ----------------------------------------------------*/

$app->run();

