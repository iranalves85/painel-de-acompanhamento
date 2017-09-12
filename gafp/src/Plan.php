<?php

namespace Gafp;

class Plan extends Connect{

    /* Retorna lista de planos */
    function getListPlans(\Gafp\User $user){
        
        if( ! $user->isLogged() ):
            return "Access Not Authorized.";
            die();
        endif;
        
        //Query para verificar existencia de usuário e senha
        $query = $this->pdo->select()->from('pa_action_plan')->where('owner', '=', $user->user['id']); 

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