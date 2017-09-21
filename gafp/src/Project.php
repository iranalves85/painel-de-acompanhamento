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

        $result = $this->pdo->select('project', [
            '[>]company'    => ['company'   => 'id'],
            '[>]model'      => ['model'     => 'id'],
            '[>]user'       => ['users'     => 'id'],
            '[>]approver'   => ['approver'  => 'id']            
        ],[
            'project.id', 'company.company', 'model.model', 'users.username', 'approver.approver'
        ],[
            'status' =>  1,
            'ORDER'  =>  ['date_created' => 'DESC']
        ]);

        return $this->data_return($result);

    }

    /* Retorna lista de projetos */
    function getProject( $ID, \Gafp\User $user){
        
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

        return $this->data_return($result);
    }

    /* Retorna valores para campos relativos a projetos */
    function getProjectFields(\Gafp\User $user, $field = ""){

        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        switch ($field) {
            case 'company':
                $result = $this->pdo->select('company',[
                    'id', 'company'
                ]);
                break;
            case 'area':
                $result = $this->pdo->select('area',[
                    'id', 'area'
                ]);
                break;
            case 'user':
                $result = $this->pdo->select('users',[
                    'id', 'username'
                ]);
                break;
            case 'model':
                $result = $this->pdo->select('model',[
                    'id', 'model'
                ]);
                break;
            case 'approver':
                $result = $this->pdo->select('approver',[
                    'id', 'approver'
                ]);
                break;            
            default:
                $result = [];
                break;
        }

        return $this->data_return($result);

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

    /* Adicionar vários usuários via arquivo */
    function addProjectUser( \Gafp\User $user, $file ){

        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $fileData = get_file_contents($file);
    }

    /* Retorna lista de projetos */
    function deleteProject( $ID, \Gafp\User $user){
        
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;

        $table = $this->tb; //simplificando chamada

        //Contruindo Query
        $query = $this->pdo->delete()
        ->from($table['project'])->where('id', '=', $ID);

        //Executa query
        $result = $query->execute()->fetch();   

        return $this->data_return($result);
    }

}