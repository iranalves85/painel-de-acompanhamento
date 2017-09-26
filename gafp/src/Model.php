<?php

namespace Gafp;

class Model extends Project{


    /*###### GET ###### */

    /* Retorna lista de projetos */
    function getListModels( \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        $this->user_has_access($user);

        //Contruindo Query
        $result = $this->pdo->select('model',
        ['id', 'name', 'description'], 
        ['ORDER' => ['id' => 'DESC'] ]);

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
        $this->user_has_access($user);

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
        $this->user_has_access($user);

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

    /*###### ADD ###### */

    /* Adiciona um novo modelo */
    function addModel( \Gafp\User $user,  $data){
        
        $this->user_has_access($user); //Verifica permissão

        //Filtrando conteúdo das variaveis
        $add_data['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING); //aplicando filtro de string
        $add_data['description'] = filter_var($data['description'], FILTER_SANITIZE_STRING); //aplicando filtro de string

        //Filtra e adiciona arrays em array
        foreach ($data['topics'] as $key => $value) {
            $add_data['topics'][$key] = [
                'name' => filter_var( $value['name'], FILTER_SANITIZE_STRING ),
                'description' => filter_var( $value['description'], FILTER_SANITIZE_STRING )
            ];
        }

        $add_data['topics'] = serialize($add_data['topics']); //Serializa para inserção no BD

        //Insere um novo valor
        $result = $this->pdo->insert('model',[ $add_data ]);

        //Verifica e Retorna dados       
        return $this->data_return_insert($this->pdo->id());                

    }

}