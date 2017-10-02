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

//Retorna uma plan especifica
$app->get('/projects/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->project->getProject( $this->user, $id ));

})->setName('Project');

//Retorna uma plan especifica
$app->put('/projects/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->project->updateProject( $this->user, $id, $data ));

})->setName('Update Project');

//Reordenando lista de projetos ordenados
$app->get('/projects/[/{order}[/{by}]]', function (Request $request, Response $response){
    
    $order = [
        'order' => ($request->getAttribute('order')) ? $request->getAttribute('order') : 'date_created',
        'by'    => ($request->getAttribute('by'))? $request->getAttribute('by') : 'DESC',
    ];
    return $response->withJson($this->project->getListProjects( $this->user, $order ));

})->setName('projects');

//Retorna campos especificos de projectos
$app->get('/projects/fields/{wichData}', function (Request $request, Response $response){
    
    $wichData = $request->getAttribute('wichData');
    return $response->withJson($this->project->getProjectFields( $this->user, $wichData ));

})->setName('projects');

//Deleta projeto
$app->delete('/projects/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->model->deleteProject( $this->user, $id ));

})->setName('Delete Project');

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



/* ###### MODELS ###############*/

//Retorna um modelo baseado num id
$app->get('/model/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    return $response->withJson($this->model->getModel( $this->user, $id ));
});

//Retorna um modelo baseado num id
$app->put('/model/{id}', function (Request $request, Response $response) {
    $id  = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->model->updateModel( $this->user, $id, $data ));
});

//Retorna lista de modelos baseados em ordenação
$app->get('/model/[/{order}[/{by}]]', function (Request $request, Response $response, $args){
    $order = [
        'order' => ($request->getAttribute('order')) ? $request->getAttribute('order') : 'date_created',
        'by'    => ($request->getAttribute('by'))? $request->getAttribute('by') : 'DESC',
    ];
    return $response->withJson($this->model->getListModels( $this->user, $order ));

})->setName('models');

$app->get('/model/fields/{wichData}', function (Request $request, Response $response, $args){
    
    $wichData = $request->getAttribute('wichData');
    return $response->withJson($this->model->getProjectFields( $this->user, $wichData ));  

})->setName('models');

//Retorna lista de modelos para determinado plano
$app->get('/model/plan/{id}', function (Request $request, Response $response, $args){
    
    $id  = $request->getAttribute('id');
    $response = $response->withJson($this->model->getPlanModels( $this->user, $id ));
    return $response;

})->setName('models');

//Adiciona um modelo
$app->post('/model', function (Request $request, Response $response) {
    
    $data = $request->getParsedBody(); //Retorna os dados serializado em array

    $result = $this->model->addModel( $this->user, $data ); //Executa query
    
    $response->getBody()->write($result); //Retorna os dados

    return $response;
});

//Deleta modelo
$app->delete('/model/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->model->deleteModel( $this->user, $id ));

})->setName('Delete Model');


    

/*########## PLAN ###############*/

//Retorna uma plan especifica
$app->get('/plan/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getPlan( $this->user, $id ));

})->setName('Activity Plans');

//Atualiza ou adiciona um plano novo
$app->post('/plan/[/{id}]', function (Request $request, Response $response, $args){     
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    if(isset($id) && $id>0){ //update plan
        return $response->withJson($this->plan->updatePlan( $this->user, $id, $data ));
    }
    else{ //add plan
        return $response->withJson($this->plan->addPlan( $this->user, $data ));
    }
})->setName('Update or Add Plans');

//Deleta plano
$app->delete('/plan/delete/', function (Request $request, Response $response, $args){    
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->deletePlan( $this->user, $data ));
})->setName('Delete Plans');

//Retorna lista de planos
$app->post('/plan/fields/{wichData}', function (Request $request, Response $response){    
    $data['field'] = $request->getAttribute('wichData'); //retorna field
    $data['where'] = $request->getParsedBody(); //Junta arrays
    return $response->withJson($this->plan->getPlanFields( $this->user, $data ));
})->setName('Plans Fields');

//Retorna lista de planos
$app->get('/plan/list/{id}', function (Request $request, Response $response, $args){    
    //Variaveis
    $id = $request->getAttribute('id');
    return  $response->withJson($this->plan->getListPlans( $this->user, $id ));
})->setName('Lista de Plans');

//Retorna lista de planos dos líderes
$app->get('/plan/leader/list/{id}', function (Request $request, Response $response, $args){    
    //Variaveis
    $leader = $request->getAttribute('id');
    return $response->withJson($this->plan->getListLeaderPlans( $this->user, $leader ));
})->setName('Plans Miscelanias');

//Atualização de Status
$app->put('/plan/status/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->updatePlanStatus( $this->user, $id, $data ));
})->setName('Update Plans Status');


/*########## ATIVIDADE ###############*/

//Retorna uma atividade especifica
$app->get('/plan/activity/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Retorna lista de atividades de um plano
$app->get('/plan/activity/list/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getListActivityPlan( $this->user, $id ));

})->setName('Activity Plans');

//Adiciona uma atividade especifica
$app->post('/plan/activity/', function (Request $request, Response $response, $args){     
    //Variaveis
    $data = $request->getParsedBody();
    return $response->withJson($this->plan->addActivityPlan( $this->user, $data ));   
})->setName('Add Activity Plans');

//Atualiza atividade especifica
$app->put('/plan/activity/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->updateActivityPlan( $this->user, $id ));
})->setName('Update Activity Plans');

//Deleta plano
$app->delete('/plan/activity/delete/{id}', function (Request $request, Response $response, $args){    
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->deleteActivityPlan( $this->user, $id ));

})->setName('Delete Plans');

/// Evidence

//Retorna uma evidencias de atividade especifica
$app->get('/plan/activity/evidence/{id}', function (Request $request, Response $response, $args){     
    //Variaveis
    $id = $request->getAttribute('id');
    return $response->withJson($this->plan->getActivityEvidence( $this->user, $id ));

})->setName('Activity Plans');


/* #APP INIT ----------------------------------------------------*/

$app->run();

