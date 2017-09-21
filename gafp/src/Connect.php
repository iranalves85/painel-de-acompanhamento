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
            'prefix'        => $prefix
        ]);
    }

    /* Retorna dados de usuário */
    function userLogin($data){

        $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); //aplicando filtro de string
        $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string

        //Executa query e retorna resultado
        $result = $this->pdo->select('users', [
            '[>]type_user' => ['type_user' => 'id']
        ],[
            'users.id', 'users.email', 'users.username', 'type_user.type_user'
        ],[
            'email'     =>  $login_data['email'],
            'password'  =>  $login_data['pass']
        ]);       

        return $result;
    }

    /*
        ### Funções auxiliadoras
    */
    //Função que controi de maneira rapida formatação de JOIN da classe PDOSlim 
    protected function joinFormat( $origin, $originCol){
        return (string) $origin . '.' . $originCol;
    }

    //Função que verifica var retorno de resultado de query no banco
    function data_return($result){
        
        if(count($result) > 0 && !is_array($result)):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

}