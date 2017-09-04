<?php 

namespace Gafp;

class User{

    var $connect;
    var $user;    
    var $session;

    /* 
        $connectObj = classe de conexão ao BD    
    */
    function __contruct(){
        
    }

    /* 
    - Registrar sessão do usuário
    - Retornar dados importantes
    */
    function login($email, $pass, $connect){

        $this->connect = $connect;

        //Query para verificar existencia de usuário e senha
        $query = $this->connect->pdo->select()->from('pa_users')->where('email', '=', $email)
        ->where('password', '=', $pass); 

        //Executa query
        $result = $query->execute()->fetch();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            $this->user = $result;
            return true;
        endif;
    }
    
    function is_user_logged(){
        
        if($this->user):
            return true;
        else:
            return false;
        endif;
    }

    function type_user(){

    }

    /*
        Registrar a sessão de usuário 
    */
    function register_session(){

    }

}