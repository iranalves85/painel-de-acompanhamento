<?php

namespace Gafp;

class Project extends Connect{

    /* Retorna lista de projetos */
    function getListProjects( \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Contruindo Query
        $query = $this->pdo->select(array(
            $this->joinFormat($table['project'], 'id'),
            $this->joinFormat($table['project'], 'spreadsheet'),
            $this->joinFormat($table['company'], 'company'),
            $this->joinFormat($table['model'], 'model'),
            $this->joinFormat($table['approver'], 'approver'),
            $this->joinFormat($table['project'], 'responsible')))
        ->leftJoin($table['company'], $this->joinFormat($table['company'], 'id'), '=', $this->joinFormat($table['project'], 'company'))
        ->leftJoin($table['model'], $this->joinFormat($table['model'], 'id'), '=', $this->joinFormat($table['project'], 'model'))
        ->leftJoin($table['approver'], $this->joinFormat($table['approver'], 'id'), '=', $this->joinFormat($table['project'], 'approver'))
        ->leftJoin($table['user'], $this->joinFormat($table['user'], 'id'), '=', $this->joinFormat($table['project'], 'responsible'))
        ->from($table['project'])->where('status', '=', 1)->orderBy($this->joinFormat($table['project'], 'date_created'), 'DESC');

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
    function getProject( \Gafp\User $user, $ID){
        
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
    function getProjectFields(\Gafp\User $user){

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
    function addProject($data, \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        $add_data[0] = filter_var($data['approver'], FILTER_SANITIZE_NUMBER_INT); //aplicando filtro de string
        $add_data[1] = filter_var($data['company'], FILTER_SANITIZE_NUMBER_INT); //aplicando filtro de string
        $add_data[2] = filter_var($data['model'], FILTER_SANITIZE_NUMBER_INT); //aplicando filtro de string
        $add_data[3] = filter_var($data['responsible'], FILTER_SANITIZE_NUMBER_INT); //aplicando filtro de string
        $add_data[4] = (int) 1;        
        $add_data[5] = date('Y-m-d H:i:s'); //aplicando filtro de string
        
        //Contruindo Query
        $query = $this->pdo->insert(array('approver','company','model','responsible', 'status', 'date_created'))
        ->into($table['project'])
        ->values($add_data);

        //Executa e retorna dado
        $result = $query->execute();
        
        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            $newItem = $this->getProject($user, $result);
            return $newItem;            
        endif;

    }

    /* Retorna lista de projetos */
    function getProjectCompanys( \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Contruindo Query
        $query = $this->pdo->select(array('id','company'))
        ->from($table['company']);

        //Executa query
        $result = $query->execute()->fetchAll();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Adicionar vários usuários via arquivo */
    function addProjectUser( \Gafp\User $user, $file ){

        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $fileData = get_file_contents($file);


    }

}