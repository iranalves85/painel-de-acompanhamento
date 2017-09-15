<?php

namespace Gafp;

class Model extends Connect{

    /* Retorna lista de projetos */
    function getListModels( \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Contruindo Query
        $query = $this->pdo->select()
        ->from($table['model'])->orderBy('id' , 'DESC');

        //Executa query
        $result = $query->execute()->fetchAll();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna lista de projetos */
    function getModel( \Gafp\User $user, $ID){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Contruindo Query
        $query = $this->pdo->select()
        ->from($table['project'])->where('id', '=', $ID);

        //Executa query
        $result = $query->execute()->fetch();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna campos relativos a projetos */
    function getModelFields(\Gafp\User $user){

        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada
        
        //Contruindo Query
        $query = $this->pdo->select(array(
            $table['project'] . '.company as companyID',
            $this->joinFormat($table['company'], 'company'),
            $table['project'] . '.model as modelID',
            $this->joinFormat($table['model'], 'model'),
            $table['project'] . '.approver as approverID', 
            $this->joinFormat($table['approver'], 'approver'),
            $table['project'] . '.responsible as userID',
            $this->joinFormat($table['user'], 'name'),
            $table['project'] . '.approver as approverID',
            $this->joinFormat($table['approver'], 'approver')))
        ->leftJoin($table['company'], $this->joinFormat($table['company'], 'id'), '=', $this->joinFormat($table['project'], 'company'))
        ->leftJoin($table['model'], $this->joinFormat($table['model'], 'id'), '=', $this->joinFormat($table['project'], 'model'))
        ->leftJoin($table['approver'], $this->joinFormat($table['approver'], 'id'), '=', $this->joinFormat($table['project'], 'approver'))
        ->leftJoin($table['user'], $this->joinFormat($table['user'], 'id'), '=', $this->joinFormat($table['project'], 'responsible'))
        ->from($table['project']);

        //Executa e retorna dados
        $result = $query->execute()->fetchAll();

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;

    }

    /* Adiciona um novo projeto */
    function addModel($data, \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Filtrando conteúdo das variaveis
        $add_data[0] = filter_var($data['name'], FILTER_SANITIZE_STRING); //aplicando filtro de string
        $add_data[1] = filter_var($data['description'], FILTER_SANITIZE_STRING); //aplicando filtro de string
        $add_data[2] = filter_var($data['topics'], FILTER_SANITIZE_STRING); //aplicando filtro de string

        $add_data[2] = serialize($add_data[2]); //Serializa para inserção no BD
        
        //Contruindo Query
        $query = $this->pdo->insert(array('model','description','topics'))
        ->into($table['model'])
        ->values($add_data);

        //Executa e retorna dado
        $result = $query->execute();
        
        //Retorno
        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            $newItem = $this->getModel($user, $result);
            return $newItem;            
        endif;

    }

}