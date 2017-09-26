<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile as UploadedFile;

require 'vendor/autoload.php'; //carregando classes
require 'gafp/autoload.php'; //carregando classes

define('_PREFIX_', 'pa_'); //Definindo prefixo de tabelas
define('_PATH_', 'http://localhost/desenvolvimento/painel-acompanhamento/'); //Definindo domínio da aplicação

$config = [
    'settings' => [
        'displayErrorDetails' => true
    ]
];

$app = new \Slim\App($config);

setlocale (LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');


/* #CONTAINERS ----------------------------------------------*/

// Get container e dependências
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';

// Registrando um componente (dependencia) de renderização de templates php
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('./gafp/src/templates/');
};

// Registrando um componente de conexão ao banco de dados
$container['phpexcel'] = function ($container) {
    return new \PHPExcel();
};

// Registrando um componente de conexão ao banco de dados
$container['connect'] = function ($container) {
    return new \Gafp\Connect(_PREFIX_); //usuários
};

$container['project'] = function($container){
    return new \Gafp\Project(_PREFIX_);
};

$container['model'] = function($container){
    return new \Gafp\Model(_PREFIX_);
};

//
$container['plan'] = function($container){
    return new \Gafp\Plan(_PREFIX_);
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

    //Se true, continua acesso
    if( is_bool($result) && $result == true ) 
        return $response->withJson($result); //Retorna dados
    
    //Retornar erro se existir
    if(is_array($result) && array_key_exists('error', $result))
        return $response->getBody()->write($result['error']); //Retorna dados

    //Retorna quando houver error anterior
    return array('error' => 'Houve um problema com a autenticação. Tente novamente.');

});

//Desloga e finaliza sessão
$app->get('/logout', function (Request $request, Response $response) {    
    return $this->user->logout($response); //Executa função deslogar
})->setName('logout');

//Página inicial do ambiente
$app->get('/painel', function (Request $request, Response $response, $args) {
    if($this->user->isLogged()) //usuário logado
        return $this->view->render($response, 'painel.php', []); //Carrega template "painel"
})->setName('painel')->add($userLogged);

/*-------------------------------------------------------------------------------------------*/

/*##### PROJETCS ############# */

//Retorna lista de projectos
$app->get('/projects/{type}[/{wichData}]', function (Request $request, Response $response){
    
    $type = $request->getAttribute('type');

    switch ($type) {
        case 'list':
            $response = $response->withJson($this->project->getListProjects( $this->user ));
            break; 
        case 'fields':
            $wichData = $request->getAttribute('wichData');
            $response = $response->withJson($this->project->getProjectFields( $this->user, $wichData ));break;           
        default:
            $response = $response->getBody()->write('Access Not Authorized.');
            break;
    }
    return $response;

})->setName('projects');

//Reordenando lista de projetos
$app->post('/projects/list', function (Request $request, Response $response){
    
    $order = $request->getParsedBody();
    $response = $response->withJson($this->project->getListProjects( $this->user, $order ));
    return $response;

})->setName('projects');

//Última etapa para cadastramento projeto
$app->post('/projects', function (Request $request, Response $response) {
    
});  

//Adicionar campos de novos projetos
$app->post('/projects/fields[/{wichData}]', function (Request $request, Response $response, $args) {

    $directory = $this->get('upload_directory'); //Definindo diretório para upload
    $upFiles = $request->getUploadedFiles(); //Pega arquivo submetido
    $data = $request->getParsedBody(); //Pega dados submetidos via POST

    //Se não tiver arquivo de upload, adiciona os dados padrão
    if(count($upFiles) > 0): 
        $data['uploadFile'] = $upFiles;
    endif;
    
    //Executa função determinada pela váriavel e retorna json de resultado
    return $response->withJson(
        $this->project->addProjectFields( 
            $this->user,
            $request->getAttribute('wichData'), 
            $data));
    
});

//Editar um projeto existente
$app->get('/projects/edit/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $result = $this->project->getProject( $id, $this->user ); //Executa query        
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});

//Deletar um projeto
$app->get('/projects/delete/{id}', function (Request $request, Response $response, $args) {
    $id = $request->getAttribute('id');
    $result = $this->project->deleteProject( $id, $this->user ); //Executa query        
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});

/* ###### MODELS ###############*/

//Retorna lista de projectos
$app->get('/model/{type}', function (Request $request, Response $response, $args){
    
    $type = $request->getAttribute('type');

    switch ($type) {
        case 'list':
            $response = $response->withJson($this->model->getListModels( $this->user ));
            break; 
        case 'fields':
            $wichData = $request->getAttribute('wichData');
            $response = $response->withJson($this->model->getProjectFields( $this->user, $wichData ));  
            break;
        default:
            $response = $response->getBody()->write('Access Not Authorized.');
            break;
    }
    return $response;

})->setName('models');

//URL para envio de credenciais para login
$app->post('/model', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->model->addModel( $this->user, $data ); //Executa query
    
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});
    

/*########## PLAN ###############*/

//Retorna lista de planos
$app->post('/plan/fields[/{wichData}]', function (Request $request, Response $response){
    
    $type = $request->getAttribute('type'); //pega variavel
    $data['field'] = $request->getAttribute('wichData'); //retorna field
    $data['where'] = $request->getParsedBody(); //Junta arrays
    return $response->withJson($this->plan->getPlanFields( $this->user, $data ));

})->setName('Plans Fields');

//Retorna lista de planos
$app->post('/plan/list[/{leader}]', function (Request $request, Response $response, $args){
    
    //Variaveis
    $leader = $request->getAttribute('leader');
    $data = $request->getParsedBody();

    //Se var definida
    if( empty($leader) && $leader == 'leader' ):
        //retorna lista de planos de func
        $response = $response->withJson($this->plan->getListLeaderPlans( $this->user, $data ));
    else:
        //retorna lista individual
        $response = $response->withJson($this->plan->getListPlans( $this->user, $data ));
    endif;

    return $response;

})->setName('Plans Miscelanias');

//Adiciona lista de planos
$app->post('/plan', function (Request $request, Response $response, $args){    
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->addPlan( $this->user, $data ));

})->setName('Plans');

//Retorna uma atividade especifica
$app->get('/plan/activity/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Retorna uma atividade especifica
$app->get('/plan/activity/list/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getListActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Retorna uma atividade especifica
$app->get('/plan/activity/evidence/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityEvidence( $this->user, $id ));

})->setName('Activity Plans');

//Deleta plano
$app->post('/plan/delete', function (Request $request, Response $response, $args){    
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->deletePlan( $this->user, $data ));

})->setName('Delete Plans');


/* #APP INIT ----------------------------------------------------*/

$app->run();

