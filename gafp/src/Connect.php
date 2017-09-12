<?php

namespace Gafp;

interface ConnectInterface{
    public function userLogin($data);  
}

class Connect implements ConnectInterface{

    protected   $dsn;
    protected   $user;
    protected   $pass;
    public      $pdo;
    protected   $tb;

    function __construct($prefix = ''){
        
        $dsn    = 'mysql:host=localhost;dbname=gptw-action-followup-panel;charset=utf8';
        $user   = 'root';
        $pass   = '';

        $this->tb = array(
            '5w2h'      => $prefix . '_5w2h',
            'action'    => $prefix . '_action_plan',
            'approver'  => $prefix . '_approver',
            'area'      => $prefix . '_area',
            'company'   => $prefix . '_company',
            'deadline'  => $prefix . '_deadline',
            'model'     => $prefix . '_model',
            'project'   => $prefix . '_project',
            'rule'      => $prefix . '_rule',
            'ruleDefined' => $prefix . '_rule_define',
            'status'    => $prefix . '_status',
            'typeUser'  => $prefix . '_type_user',
            'user'      => $prefix . '_users',
        );

        date_default_timezone_set ( 'America/Sao_Paulo' );
        
        return $this->pdo = new \Slim\PDO\Database($dsn, $user, $pass);
    }

    /* Retorna dados de usuário */
    function userLogin($data){

        $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); //aplicando filtro de string
        $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string
        
        $table = $this->tb; //simplificando chamada

        $query = $this->pdo->select()
        ->leftJoin($table['area'], $this->joinFormat($table['area'], 'id'), '=', $this->joinFormat($table['user'], 'area'))
        ->leftJoin($table['company'], $this->joinFormat($table['company'], 'id'), '=', $this->joinFormat($table['user'], 'company'))
        ->leftJoin($table['approver'], $this->joinFormat($table['approver'], 'id'), '=', $this->joinFormat($table['user'], 'approver'))
        ->leftJoin($table['typeUser'], $this->joinFormat($table['typeUser'], 'id'), '=', $this->joinFormat($table['user'], 'type_user'))
        ->from($table['user'])->where('email', '=', $login_data['email'])
        ->where('password', '=', $login_data['pass']);
        
        $result = $query->execute()->fetch(); //Executa e armazena resultado

        return $result;
    }

    /*
        ### Funções auxiliadoras
    */
    //Função que controi de maneira rapida formatação de JOIN da classe PDOSlim 
    protected function joinFormat( $origin, $originCol){
        return (string) $origin . '.' . $originCol;
    }

}