<?php 

namespace Gafp;

class User{

    public $connect;
    public $user;
    
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
        if(!$result):
            $msgError = ['error' => "Usuário ou senha incorretos."];
            return $msgError;            
        else:
            //Registra dados da sessão
            $session = $this->registerSession($result);            
            //Retorna dados
            return $session;
        endif;
    }

    /* Insere diversos usuários por vez em tabela */
    function getUsers( $filter = array() ){
        //Invoca função de retornar lista de usuários
        return $this->connect->getListUsers($filter);      
    } 

    /* Insere diversos usuários por vez em tabela */
    function insertMultipleUsers( array $userdata, $company = array() ){
        //Retorna se não houver dados
        if(count($userdata) <= 0 || empty($userdata['email']))
            return 'Linha sem identificador "email", não sendo possível inserir ou adicionar';
        
        //Invoca função de incluir um novo usuário
        return $this->connect->newUser(array_merge($userdata, $company));      
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
    protected function registerSession($userData){
        
        //Gerando hash
        $cookieToken = password_hash( $userData['email'], CRYPT_BLOWFISH);
        $_SESSION['user'] = $userData; //adiciona dados do usuário na sessão
        $this->user = $_SESSION['user'];
        
        //Setando cookies
        $cookie = setcookie('gafp', $cookieToken, time()+172800, _PATH_ );

        //Se sessão inicializada e cookie setado
        if( isset( $_SESSION['user'] ) && $cookie ):
            return true;
        else:
            return false;
        endif;
    }

    /*
        ##### Funções de verificação de login
    */
    //Retorna se usuarios esta logado, sim ou não
    function isLogged(){        
        if( isset($_SESSION['user']) ):
            return true;
        else:
            return false;
        endif;
    }

    function isCookieValid(){ 
        if( isset($_COOKIE['gafp']) && password_verify( $this->user['email'], $_COOKIE['gafp']) ):
            return true;
        else:
            return false;
        endif;
    }

    //Se usuario deslogado, direciona para tela de login
    function logout(\Psr\Http\Message\ResponseInterface $response){
        ob_end_clean();
        session_destroy();
        setcookie('gafp');
        setcookie('gafp-user');
        return $response->withStatus(200)->withHeader('Location', _PATH_); 
    }

}