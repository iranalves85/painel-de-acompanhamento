<?php

namespace Gafp;

class Plan extends Connect{

    /* Retorna lista de planos */
    function getPlan(\Gafp\User $user, $id){
        
        $this->user_has_access($user);

        $result = $this->pdo->get('plan',[
            'name', 'description', 'owner', 'cost', 'goal', 'deadline'
        ],[
            'plan.id' => $id
        ]);

        return $result;
    }

    /* Retorna lista de planos */
    function getListPlans(\Gafp\User $user, $data){
        
        $this->user_has_access($user);

        //Se key estiver atribui a variavel
        if( is_array($data) && array_key_exists('order', $data) ){
            $order = $data['order'];
        }
        else{
            $order = ['order' => 'date_created', 'by' => 'DESC'];
        }

        $result = $this->pdo->select('plan', [
            '[>]company'    => ['company'   => 'id'],
            '[>]users'      => ['owner'     => 'id'],            
            '[>]status'     => ['status'    => 'id']           
        ],[
            'plan.id', 'plan.name', 'plan.description', 'plan.goal', 'company.name(company)', 'plan.deadline, status.status'
        ],[
            'plan.owner' => $data['id'],
            'ORDER'  =>  ['plan.' . $order['order'] => $order['by']]
        ]);
        
        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna lista de planos */
    function getListLeaderPlans(\Gafp\User $user, $data){
        
        $this->user_has_access($user);
        
        //Se key estiver atribui a variavel
        if( is_array($data) && array_key_exists('order', $data) ){
            $order = $data['order'];
        }
        else{
            $order = ['order' => 'date_created', 'by' => 'DESC'];
        }

        $result = $this->pdo->select('plan', [
            '[>]company'    => ['company'   => 'id'],
            '[>]users'      => ['owner'     => 'id'],            
            '[>]status'     => ['status'    => 'id']           
        ],[
            'plan.id', 'plan.name', 'plan.description', 'company.name(company)', 
            'users.username(owner)', 'plan.deadline, status.status(status)'
        ],[
            'plan.status' =>  1,
            'plan.owner' => $data['id'],
            'ORDER'  =>  ['plan.' . $order['order'] => $order['by']]
        ]);
        
        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    /* Retorna valores para campos relativos a projetos */
    function getPlanFields(\Gafp\User $user, $field = array()){

        $this->user_has_access($user);

        switch ($field['field']) {
            case 'users':
                $result = $this->pdo->select('users',[
                    'id', 'username', 'email'
                ],$field['where']);
                break;                        
            default:
                $result = [];
                break;
        }

        return $this->data_return($result);

    }

    //Retorna atividade baseada em seu ID
    function getActivityPlan(\Gafp\User $user, $id ){
        $this->user_has_access($user);

        //Verifica se dado já existe e define função a exec
        if( $this->pdo->has('activity',['id' => $id]) )
        {
            $result = $this->pdo->select('activity',[
                '[<]evidence'   => ['id' => 'activity' ],
                '[<]project'    => ['project' => 'id' ],
                '[>]model'      => ['project.model' => 'id' ]
            ],[
                'activity' => ['activity.name', 'activity.description', 'activity.what', 'activity.because', 'activity.place', 'activity.moment', 'activity.who', 'activity.how', 'activity.cost', 'activity.date_created'], 
                'evidence' => ['evidence.id','evidence.topic', 'evidence.action'],
                'project' => ['project.id','project.model'],
                'model' => ['model.id','model.topics[Object]']
            ],[
                'activity.id' => $id
            ]);
    
            return $result; //retorna (array) 'id 
        } 

    }

    //Retorna lista de atividades relacionadas com id do Plano
    function getListActivityPlan(\Gafp\User $user, $id ){
        $this->user_has_access($user);

        $result = $this->pdo->select('activity',[
            'id', 'name', 'description', 'date_created'
        ],[
            'plan' => $id
        ]);
        
        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;

    }

    //Retorna atividade baseada em seu ID
    function getActivityEvidence(\Gafp\User $user, $id ){
        $this->user_has_access($user);

        //Verifica se dado já existe e define função a exec
        if( $this->pdo->has('evidence',['activity' => $id]) )
        {
            $result = $this->pdo->select('evidence',[
                'id', 'name', 'description', 'action', 'date_created',
            ],[
                'activity' => $id
            ]);
    
            return $result; //retorna (array) 'id 
        } 

    }

    /*####### ADD ######## */


    /* Adiciona um novo projeto */
    function addPlan( \Gafp\User $user, $data){
        
        $this->user_has_access($user);

        //Insere os dados obtidos anteriormente
        $result = $this->pdo->insert('plan', [ 
            'name'          => $data['name'],
            'description'   => $data['description'],
            'owner'         => $data['owner'],
            'cost'          => $data['cost'],
            'goal'          => $data['goal'],
            'deadline'      => $this->data_converter_to_insert($data['deadline'])
        ]);

        $idResult = $this->pdo->id();
        
        //Retorna resultado
        if(isset($idResult) && $idResult > 0){
            return array('type' => 'success', 'msg' => 'Plano criado com sucesso! ID: ' . $idResult);
        }
        else{
            return array('type' => 'danger', 'msg' => 'Não foi possível criar o plano, tente novamente.');
        }

    }

    // UPDATE  ############################################

    /* Atualiza um plano */
    function updatePlan( \Gafp\User $user, $id, $data){
        
        $this->user_has_access($user);

        //Insere os dados obtidos anteriormente
        $result = $this->pdo->update('plan', [ 
            'name'          => $data['name'],
            'description'   => $data['description'],
            'owner'         => $data['owner'],
            'cost'          => $data['cost'],
            'goal'          => $data['goal'],
            'deadline'      => $this->data_converter_to_insert($data['deadline'])
        ],['id' => $id]);

        //Retorna resultado
        if(isset($result) && !is_null($result)){
            return array(
            'type' => 'success', 
            'msg' => 'Plano atualizado com sucesso!');
        }
        else{
            return array(
            'type' => 'danger', 
            'msg' => 'Não foi possível atualizar o plano, tente novamente.');
        }

    }

    // DELETE #############################################

    /* Deletar um plano */
    function deletePlan( \Gafp\User $user,  $ID){
        
        $this->user_has_access($user); //Verifica permissão

        //Contruindo Query
        $result = $this->pdo->delete('plan',['id' => $ID['id']]);
        
        //Retorna resultado
        if(is_object($result) && $result){
            return array('type' => 'success', 'msg' => 'Plano deletado.');
        }
        else{
            return array('type' => 'danger', 'msg' => 'Não foi possível deletar o plano. Tente novamente.');
        }
    }

    /* Deletar uma atividade */
    function deleteActivityPlan( \Gafp\User $user,  $ID){
        
        $this->user_has_access($user); //Verifica permissão

        //Contruindo Query
        $result = $this->pdo->delete('activity',['id' => $ID ]);
        
        //Retorna resultado
        if(is_object($result) && $result){
            return array('type' => 'success', 'msg' => 'Atividade deletada.');
        }
        else{
            return array('type' => 'danger', 'msg' => 'Não foi possível deletar a atividade. Tente novamente.');
        }
    }

}