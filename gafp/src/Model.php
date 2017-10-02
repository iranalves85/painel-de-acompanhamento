<?php

namespace Gafp;

class Model extends Project{


    /*###### GET ###### */

    /* Retorna lista de modelos */
    function getModel( \Gafp\User $user, $id){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        $this->user_has_access($user);

        //Contruindo Query
        $result = $this->pdo->get('model',
        ['id', 'name', 'description','topics[Object]'], 
        [
            'id' => $id
        ]);

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna lista de modelos */
    function getListModels( \Gafp\User $user, $order = ['order' => 'date_created', 'by' => 'DESC']){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        $this->user_has_access($user);

        //Contruindo Query
        $result = $this->pdo->select('model',
        ['id', 'name', 'description','topics[Object]'], 
        [
            'ORDER'  =>  ['model.' . $order['order'] => $order['by']]
        ]);

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna lista de modelos */
    function getPlanModels( \Gafp\User $user, $id){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        $this->user_has_access($user);

        //Contruindo Query
        $result = $this->pdo->get('plan',[ 
            '[>]project'    => ['plan.project'  => 'id'],            
            '[>]model'      => ['project.model'  => 'id'],
        ],
        ['model.topics[Object]', 'plan.id(plan)', 'project.id(project)'],
        [
            'plan.id' => $id
        ]);

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

        //Verifica se foi enviado algum dado "Topic"
        if( isset($data['topics']) && count($data['topics']) > 0 ){
            //Filtra e adiciona arrays em array
            foreach ($data['topics'] as $key => $value) {
                $add_data['topics'][$key] = [
                    'name' => filter_var( $value['name'], FILTER_SANITIZE_STRING ),
                    'description' => filter_var( $value['description'], FILTER_SANITIZE_STRING )
                ];
            }

            $add_data['topics'] = serialize($add_data['topics']); //Serializa para inserção no BD           
        }

        //Insere um novo valor
        $result = $this->pdo->insert('model',[ $add_data ]);

        //Verifica e Retorna dados       
        return $this->data_return_insert($this->pdo->id());                

    }

    /* Retorna lista de modelos */
    function updateModel( \Gafp\User $user, $id, $data){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        $this->user_has_access($user);

        //Nome do modelo
        $name           = filter_var($data['name'], FILTER_SANITIZE_STRING);   
        //Descrição do modelo
        $description    = filter_var($data['description'], FILTER_SANITIZE_STRING);      
        //Array de Tópicos
        $topics = [];
        //Percorre array e adiciona somente keys permitidas
        foreach ($data['topics'] as $key => $value) {
            $topics[$key]['name'] = filter_var($value['name'], FILTER_SANITIZE_STRING);
            $topics[$key]['description'] = filter_var($value['description'], FILTER_SANITIZE_STRING);
        }

        //Contruindo Query
        $result = $this->pdo->update('model',
        [   'name' => $name, 
            'description' => $description, 
            'topics' => serialize($topics)], 
        [
            'id' => $id
        ]);

        //Retorna resultado
        if(isset($result) && !is_null($result)){
            return array(
            'type' => 'success', 
            'msg' => 'Modelo atualizado com sucesso!');
        }
        else{
            return array(
            'type' => 'danger', 
            'msg' => 'Houve algum problema na atualização do modelo, tente novamente.');
        }
    }

    /* Deletar um modelo */
    function deleteModel( \Gafp\User $user,  $ID){
        
        $this->user_has_access($user); //Verifica permissão

        //Contruindo Query
        $result = $this->pdo->delete('model',['id' => $ID ]);
        
        //Retorna resultado
        if(is_object($result) && $result){
            return array('type' => 'success', 'msg' => 'Modelo deletada.');
        }
        else{
            return array('type' => 'danger', 'msg' => 'Não foi possível deletar o modelo. Tente novamente.');
        }
    }

}