<?php 

namespace Gafp;

class Data{

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
    function getPlans($connect){

        $this->connect = $connect;

        $userID = 1;

        //Query para verificar existencia de usuário e senha
        $query = $this->connect->pdo->select()->from('pa_action_plan')->where('owner', '=', $userID); 

        //Executa query
        $result = $query->execute()->fetch();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

}