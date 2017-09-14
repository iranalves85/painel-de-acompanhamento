<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

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
$container['upload_directory'] = __DIR__ . '/uploads';

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./gafp/src/templates/');
};

// Registrando um componente de conexão ao banco de dados
$container['connect'] = function ($container) {
    return new \Gafp\Connect(_PREFIX_); //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['project'] = function ($container) {
    return new \Gafp\Project(_PREFIX_); //usuários
};

// Registrando um componente de conexão ao banco de dados
$container['plan'] = function ($container) {
    return new \Gafp\Plan(_PREFIX_); //usuários
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
    
    $response->getBody()->write($result); //Retorna dados

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

/* #Dentro do Painel */

//Retorna lista de projectos
$app->get('/projects/{type}', function (Request $request, Response $response){
    
    $type = $request->getAttribute('type');

    switch ($type) {
        case 'list':
            $response = $response->withJson($this->project->getListProjects( $this->user ));
            break; 
        case 'fields':
            $response = $response->withJson($this->project->getProjectFields( $this->user ));  
            break;   
        case 'companys':
            $response = $response->withJson($this->project->getProjectCompanys( $this->user )); 
            break;
        default:
            $response = $response->getBody()->write('Access Not Authorized.');
            break;
    }
    return $response;

})->setName('projects');

//URL para envio de credenciais para login
$app->post('/projects', function (Request $request, Response $response, $args) {

    $directory = $this->get('upload_directory'); //Diretório para upload
    
    $upFiles = $request->getUploadedFiles(); //Carrega arquivo

    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->project->addProject( $data, $this->user ); //Executa query
    
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});

//Retorna lista de planos
$app->get('/plans', function (Request $request, Response $response){
    
    $response = $response->withJson($this->plan->getListPlans( $this->user )); //Recebe dados pelo user
    return $response;

})->setName('list-plans');




/* #APP INIT ----------------------------------------------------*/

$app->run();

