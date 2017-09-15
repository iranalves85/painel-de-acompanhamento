<?php

namespace Gafp;

class Plan extends Connect{

    /* Retorna lista de planos */
    function getListPlans(\Gafp\User $user){
        
        if( ! $user->isLogged() ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada
        
        //Query para verificar existencia de usuário e senha
        $query = $this->pdo->select()->from($table['action'])
        //->where('owner', '=', $user->user['id'])
        ->orderBy('date_created', 'DESC'); 

        //Executa query
        $result = $query->execute()->fetchAll();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

}