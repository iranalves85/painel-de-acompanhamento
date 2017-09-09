<?php 

namespace Gafp;

class User{

    public $connect;
    var $user;    
    var $session;

    //Contrução da classe
    public function __construct( \Gafp\Connect $connect ){
        $this->initSession();
        $this->connect = $connect;
    }

    /* 
    - Registrar sessão do usuário
    - Retornar dados importantes
    */
    function login($data){

        //Executa Query
        $result = $this->connect->userLogin($data);

        //Retorna resultado
        if(! $result):
            $this->logout();            
        else:
            //Retorna dados de usuário
            $this->registerSession($result);
            $this->user = $result;
            return true;
        endif;
    }
    
    //Retorna o tipo de usuário logado
    function typeUser(){

    }

    /*
        ##### Sessões de usuário
    */
    //Iniciando sessão
    function initSession(){
        ob_start();
        session_start();
    }

    //Registrando sessão
    function registerSession($userData){
        $_SESSION['user'] = $userData;
        $this->session = '';
    }

    /*
        ##### Funções de verificação de login
    */

    //Retorna se usuarios esta logado, sim ou não
    function isLogged(){        
        if(! is_null($this->user) and session_is_registered() ):
            return true;
        else:
            return false;
        endif;
    }

    //Se usuario logado, direciona para painel
    function logged(\Psr\Http\Message\ResponseInterface $response){
        return $response->withStatus(200)->withHeader('Location', '/painel'); 
    }

    //Se usuario deslogado, direciona para tela de login
    function logout(\Psr\Http\Message\ResponseInterface $response){
        ob_end_clean();
        session_destroy();
        return $response->withStatus(200)->withHeader('Location', '/'); 
    }

}