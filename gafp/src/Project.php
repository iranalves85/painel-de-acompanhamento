<?php

namespace Gafp;

class Project extends Connect{

    /*###### GET ###### */

    /* Retorna lista de projetos */
    function getListProjects( \Gafp\User $user, $order = ['order' => 'date_created', 'by' => 'DESC']){
        
        $this->user_has_access($user);

        $result = $this->pdo->select('project', [
            '[>]company'    => ['company' => 'id'],
            '[>]model'      => ['model' => 'id'],
            '[>]users'      => ['user' => 'id'],
            '[>]approver'   => ['approver'=> 'id']           
        ],[
            'project.id', 'company.name(company)', 'model.name(model)', 'users.username(responsible)', 'approver.name(approver)'
        ],[
            'project.status' =>  1,
            'ORDER'  =>  ['project.' . $order['order'] => $order['by']]
        ]);

        return $this->data_return($result);

    }

    /* Retorna lista de projetos */
    function getProject( $ID, \Gafp\User $user){
        
        $this->user_has_access($user);
       
        $result = $this->pdo->get('project', [
            '[>]company'    => ['company' => 'id'],
            '[>]model'      => ['model' => 'id'],
            '[>]users'      => ['user' => 'id'],
            '[>]approver'   => ['approver'=> 'id']           
        ],[
            'company.name(company)', 'model.name(model)', 'users.username(responsible)', 'approver.name(approver)'
        ],[
            'project.status' =>  1,
            'project.id'  =>  $ID
        ]);

        return $this->data_return($result);
    }

    /* Retorna valores para campos relativos a projetos */
    function getProjectFields(\Gafp\User $user, $field = ""){

        $this->user_has_access($user);

        switch ($field) {
            case 'company':
                $result = $this->pdo->select('company',[
                    'id', 'name'
                ]);
                break;
            case 'area':
                $result = $this->pdo->select('area',[
                    'id', 'name'
                ]);
                break;
            case 'user':
                $result = $this->pdo->select('users',[
                    'id', 'username'
                ]);
                break;
            case 'model':
                $result = $this->pdo->select('model',[
                    'id', 'name'
                ]);
                break;
            case 'approver':
                $result = $this->pdo->select('approver',[
                    'id', 'name'
                ]);
                break;            
            default:
                $result = [];
                break;
        }

        return $this->data_return($result);

    }

    /*####### ADD ######## */


    /* Adiciona um novo projeto */
    function addProject($data, \Gafp\User $user){
        
        $this->user_has_access($user);

        //Percorre array de data e executa função para atribuir
        foreach ($data as $key => $value) {
            $add_data[$key] = $this->addProjectFields($user, $key, $value);
        }

        //Insere os dados obtidos anteriormente
        $result = $this->pdo->insert('project', $add_data);

        $idResult = $result->id();
        
        //Se resultado for false encerra função
        if(!$this->data_return_insert($idResult))
            return false;
        
        //Retorna dados de usuário
        $newItem = $this->getProject($user, $idResult);
        return $newItem; 

    }

    //Adicionando campos na base basedo nas colunas
    function addProjectFields( \Gafp\User $user, $type_field, $data){
        
        $this->user_has_access($user); //Verifica permissão

        $defaultColumns = array('company', 'model', 'users', 'approver'); //tipos permitidos
        
        //Se for diferente do defido, retorna acesso não autorizado
        if( !in_array($type_field, $defaultColumns) )
                return 'Access Not Authorized.';
        
        //Definindo a função a ser executada
        $func = 'addProject_' . $type_field . '_FieldData';

        //retorna resultado
        return $this->$func($user, $data);

    }

    //Função para inserir empresas, verifica se existe e insere ou retorna
    private function addProject_company_FieldData($user = '', $data){
        
        $input = filter_var($data['company'], FILTER_SANITIZE_STRING);
        
        //Verifica se dado já existe e define função a exec
        if( $this->pdo->has('company',['name' => $input]) )
        {
            //Insere um novo valor
            $result = $this->pdo->get('company',
            ['id'],['name' => $input]);
            return $this->data_return_insert($result); //retorna (array) 'id' 
        }
        else{
            //Insere um novo valor
            $result = $this->pdo->insert('company',[
                'name' => $input
            ]);
            return $this->data_return_insert($this->pdo->id()); //retorna (int) id
        }        
    }

    //Função para selecionar modelos existentes
    private function addProject_model_FieldData($user = '', $data){

        $input = filter_var($data['model']['id'], FILTER_SANITIZE_STRING);
        
        //Verifica se dado já existe e define função a exec
        if( $this->pdo->has('model',['id' => $input]) )
        {
            //Pega valor
            $result = $this->pdo->get('model',
            ['id'],['id' => $input]);
            return $this->data_return_insert($result); //retorna (array) 'id 
        } 
                 
    }

    //Função que adiciona usuários ao projeto
    private function addProject_users_FieldData($user, $data){

        $company = ['company' => $data['company']];
        $file = $data['uploadFile']['file']->file;
        $result = [];

        $filetype = \PHPExcel_IOFactory::identify($file);//Identifica arquivo
        $objReader = \PHPExcel_IOFactory::createReader($filetype); //inicializa classe de leitura
        $xl = $objReader->load($file); //carrega as informações do arquivo
        $objWorksheet = $xl->getActiveSheet(); //carrega apenas as informação das tabelas
        $lastColumn = $objWorksheet->getHighestColumn(); //aponta para primeira coluna do documento
        
        //Definindo as colunas válidas
        $validColumns = ['username', 'email', 'password', 'area', 'leader', 'type_user'];
        //Pega a primeira linha para usar 
        $columnNames = $objWorksheet->rangeToArray('A1:'. $lastColumn.'1'); 
        //Verifica se as colunas do documento é permitida
        foreach ($columnNames[0] as $key => $value) {
            if(! in_array($value, $validColumns)){
                $result['error'][] = "Coluna de dados '" . $value . "'não permitida para cadastro";
            }
        }
        
        //Se houver erros, encerrar execução
        if( !empty($result['error']) )
            return $result;

        //Intera sobre o número de linhas no arquivo de upload
        foreach($objWorksheet->getRowIterator() as $rowIndex => $row) {
            //Ignora primeira linha
            if($rowIndex == 1){
                continue;
            }
            //Convert the cell data from this row to an array of values
            $arrayRow = $objWorksheet->rangeToArray('A'.$rowIndex.':'.$lastColumn.$rowIndex);
            //Combinamos os dois arrays para definir keys e values em um só
            $currentData = array_combine($columnNames[0], $arrayRow[0]);
            //Executa função de adicionar usuário
            $response = $user->insertMultipleUsers($currentData, $company);
            //Verifica se houve algum erro e interrompe upload
            if(empty($response) || is_null($response)){
                $result['error'][]= "Houve algum problema na linha " . $rowIndex . ", não foi possível inserir ou atualizar os dados";
                break;
            }
            else{
                $result['success'] = true;
            }            
        }

        //Se houve sucesso na inserção, trazer os user adicionados
        if($result['success']){
            $getUsers = $user->getUsers($company);
        }
        
        return $getUsers;
    }

    private function addProject_approver_FieldData($user = '', $data){
        $input = filter_var($data, FILTER_SANITIZE_STRING);
        $result = $this->pdo->insert('approver',['name' => $input]);
        return $result->id(); //retorna id
    }

    /* Retorna lista de projetos */
    function deleteProject( $ID, \Gafp\User $user){
        
        $this->user_has_access($user);

        //Contruindo Query
        $result = $this->pdo->delete('project',['id' => $ID]);   

        return $this->data_return($result);
    }

}