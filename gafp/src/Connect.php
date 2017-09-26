<?php

namespace Gafp;

class Connect{

    protected   $server;
    protected   $bd;
    protected   $user;
    protected   $pass;
    public      $pdo;
    protected   $tb;

    function __construct($prefix = ''){
        
        $server     = 'localhost';
        $bd         = 'gptw-action-followup-panel';
        $user       = 'root';
        $pass       = '';

        //setlocale();
        date_default_timezone_set ( 'America/Sao_Paulo' );
        
        return $this->pdo = new \Medoo\Medoo([
            'database_type' => 'mysql',
            'database_name' => $bd,
            'server'        => $server,
            'username'      => $user,
            'password'      => $pass,
            'charset'       => 'utf8',
            'prefix'        => $prefix,
            'debug_mode'    => true
        ]);
    }

    /* Retorna dados de usuário */
    function userLogin($data){

        $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); //aplicando filtro de string
        $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string

        //Verifica se usuário existe
        if( ! $this->pdo->has('users', ['email' => $login_data['email']] )):
            return false;
        endif;

        //Retorna senha hasheada do banco
        $pass = $this->pdo->get('users', ['password'], ['email' => $login_data['email']]);
        
        //Verifica se usuário existe no banco, comparando senha
        if( password_verify($login_data['pass'], $pass['password']) ):

            //Dados para requisição
            $select = ['email' => $login_data['email']];
            //Prepara para executar a requisição
            $prepare = $this->pdo->pdo->prepare('users', $select);
            //Executa query e retorna resultado
            $result = $this->pdo->get('users', [
                'id', 'email', 'username', 'area[Object]', 'company', 'approver', 'type_user[Object]'
            ], $select); 

            return $result;

        else:
            //Retorna string erro
            return false;

        endif;
    }

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function newUser($data){

        $user_data = [];
        $columnToSerialize = ['area', 'leader', 'type_user'];
        $result = '';

        //Prepara as informações para inserção no banco
        foreach ($data as $key => $value) {
            //aplicando filtro de string
            if( in_array($key, $columnToSerialize) ):                
                $explode = explode(',', filter_var($value, FILTER_SANITIZE_STRING));
                foreach ($explode as $k => $v) {
                    $explode[$k] = trim($v);
                } 
                $user_data[$key] = serialize($explode);
            else:
                $user_data[$key] = ($key == 'password')? password_hash(filter_var($value, FILTER_SANITIZE_STRING), CRYPT_BLOWFISH) : filter_var($value, FILTER_SANITIZE_STRING); 
            endif;            
        }
        
        //Prevenir contra SQL injections
        $prepare = $this->pdo->pdo->prepare('users', ['email' => $user_data['email']]);

        //Verifica se usuário existe no banco, baseado no email
        if( $this->pdo->has( $prepare->queryString, ['email' => $user_data['email']] ) ):

            //Executa update e retorna resultado
            $update = $this->pdo->update('users', $user_data, [ 'email' => $user_data['email']] ); 
            $result = $update->rowCount();

        else:
            //Executa insert e retorna resultado
            $insert = $this->pdo->insert('users', $user_data); 
            $result = $this->pdo->id();

        endif;

        return $result;
    }

    /* Adicionar um novo usuário ou atualizar existente no sistema */
    function getListUsers( $filter = array() ){

        $result = $this->pdo->select('users', [
            'id', 'username', 'email', 'area[Object]'
        ], $filter);

        return $result;
    }

    //Função que verifica var retorno de resultado de query no banco
    public function data_return($result){
        
        if(count($result) <= 0 || !is_array($result)):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

    //Função que verifica var retorno de resultado de query no banco
    //$result = recebe id de inserção
    public function data_return_insert($result){        
        //Retorna dados de usuário
        if(is_array($result)):
            $id = (int) $result['id'];
        else:
            $id = (int) $result;
        endif;

        //Retorna $id ou false
        return ($id <= 0)? false : $id;            
    }

    /*Se usuário não tiver acesso finaliza função */
    function user_has_access(\Gafp\User $user){
        //Se usuário não estiver logado e permissão diferente de 'superuser'
        if( ! $user->isLogged() && $user->type_user != 'superuser' ):
            return "Access Not Authorized.";
            die();
        endif;
    }

    function data_converter_to_insert($date){
        setlocale (LC_ALL, 'pt_BR');
        date_default_timezone_set('America/Sao_Paulo');
        return date('Y-m-d H:i:s', strtotime($date));
    }

}