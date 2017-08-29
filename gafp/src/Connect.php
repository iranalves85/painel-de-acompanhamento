<?php

namespace Gafp;

class Connect{

    protected   $dsn;
    protected   $user;
    protected   $pass;
    public      $pdo;

    function __construct(){
        
        $dsn    = 'mysql:host=localhost;dbname=gptw-action-followup-panel;charset=utf8';
        $user   = 'root';
        $pass   = '';
        
        $this->pdo = new \Slim\PDO\Database($dsn, $user, $pass);
    }

}