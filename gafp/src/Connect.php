<?php

namespace Gafp;

interface ConnectInterface{
    public function userLogin($data);
    public function getPlans($userID);
}

class Connect implements ConnectInterface{

    protected   $dsn;
    protected   $user;
    protected   $pass;
    public      $pdo;

    function __construct(){
        
        $dsn    = 'mysql:host=localhost;dbname=gptw-action-followup-panel;charset=utf8';
        $user   = 'root';
        $pass   = '';
        
        return $this->pdo = new \Slim\PDO\Database($dsn, $user, $pass);
    }

    //Retorna dados de usuário
    function userLogin($data){

        $login_data['email'] = filter_var($data['email'], FILTER_SANITIZE_EMAIL); //aplicando filtro de string
        $login_data['pass'] = filter_var($data['password'], FILTER_SANITIZE_STRING); //aplicando filtro de string
        
        $query = $this->pdo->select(array('id','name','area','company','leader','approver','type_user'))
        ->from('pa_users')->where('email', '=', $login_data['email'])
        ->where('password', '=', $login_data['pass']);

        $result = $query->execute()->fetch();

        return $result;
    }

    function getPlans($userID){
        
        //Query para verificar existencia de usuário e senha
        $query = $this->pdo->select()->from('pa_action_plan')->where('owner', '=', $userID); 

        //Executa query
        $result = $query->execute()->fetch();   

        if(! $result):
            return false;
        else:
            //Retorna dados de usuário
            return $result;            
        endif;
    }

}