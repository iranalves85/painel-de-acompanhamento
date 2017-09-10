<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php'; //carregando classes
require 'gafp/autoload.php'; //carregando classes

define('_PREFIX_', 'pa'); //Definindo prefixo de tabelas
define('_PATH_', 'http://localhost/desenvolvimento/painel-acompanhamento/'); //Definindo domínio da aplicação

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
    return new \Gafp\Connect(_PREFIX_); //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['user'] = function ($container) {
    $connect = new \Gafp\Connect(_PREFIX_);
    return new \Gafp\User($connect); //usuários
};

/* #MIDDLEWARES ----------------------------------------------*/

//Verifica se user esta logado, se não volta para a tela de login
$userLogged = function (Request $request, Response $response, $next){

    //Se usuário 'não' estiver logado
    if( ! $this->user->isLogged() ):
        //Destroi sessão e volta tela de login
        return $this->user->logout($response);
    endif;

    $next($request, $response);

    return $response;
};

//Verifica se user esta logado, se não volta para a tela de login
$userCookie = function (Request $request, Response $response, $next){
    
    //Se cookie estiver válido
    if( $this->user->isCookieValid() ):
        //Redireciona para painel
        return $response->withStatus(200)->withHeader('Location', 'painel'); 
    endif;

    $next($request, $response);

    return $response;
};

/* #ROUTES ----------------------------------------------*/

//Verifica se usuário esta autenticado e retorna página
$app->get('/', function (Request $request, Response $response ) {    
    return $this->view->render($response, 'login.php', []); //Carrega template
})->setName('login')->add($userCookie);

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
})->setName('logout');

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    return $this->view->render($response, 'painel.php', []); //Carrega template "painel"
})->setName('painel')->add($userLogged);

/* #Dentro do PAinel */

//Retorna lista de projectos
$app->get('/projects', function (Request $request, Response $response){
    
    $response = $response->withJson($this->connect->getProjects( $this->user )); //Enviando dados para função User->login    
    return $response;

})->setName('list-projects');

//Retorna lista de planos
$app->get('/plans', function (Request $request, Response $response){
    
    $response = $response->withJson($this->connect->getPlans( $this->user )); //Recebe dados pelo user
    return $response;

})->setName('list-plans');




/* #APP INIT ----------------------------------------------------*/

$app->run();

