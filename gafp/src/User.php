<?php 

namespace Gafp;

class User{

    public $connect;
    public $user;
    
    //Contrução da classe
    public function __construct( \Gafp\Connect $connect ){
        $this->initSession();
        $this->connect = $connect;
    }

    /* 
    - Registrar sessão do usuário
    - Retornar dados importantes
    */
    function login($data){

        //Executa Query
        $result = $this->connect->userLogin($data);

        //Retorna resultado
        if(!$result):
            $msgError = ['error' => "Usuário ou senha incorretos."];
            return $msgError;            
        else:
            //Registra dados da sessão
            $session = $this->registerSession($result);            
            //Retorna dados
            return $session;
        endif;
    }

    /* Retorna um usuário especifico */
    function getUser( $filter = array() ){
        //Invoca função de retornar lista de usuários
        return $this->connect->getSingleUser($filter);      
    } 

    /* Retorna lista de usuários */
    function getUsers( $filter = array() ){
        //Invoca função de retornar lista de usuários
        return $this->connect->getListUsers($filter);      
    } 

    /* Insere um único usuário */
    function addUser( \Gafp\Connect $connect, $projectID, $data ){
        // Retorna id de empresa relacionado ao projeto
        $result = $connect->pdo->get('project',
            ['company'],
            ['id' => $projectID ]);

        //Se tipo de usuário não foi definido
        if( !isset($data['type_user']) ){
            $data['type_user'] = 'manager';
        }

        // Se retorno for verdadeiro
        if($result){
            return $this->insertMultipleUsers($data, $projectID, $result['company']);    
        }
        
    } 

    /* Insere um único usuário */
    function updateUser( \Gafp\Connect $connect, $userID, $data ){
        
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
                $user_data[$key] = ($key == 'password')? password_hash(filter_var($value, FILTER_SANITIZE_STRING), PASSWORD_DEFAULT) : filter_var($value, FILTER_SANITIZE_STRING);
            endif;            
        }

        //Prevenir contra SQL injections
        $prepare = $connect->pdo->pdo->prepare('users', ['id' => $userID]);

        //Verifica se usuário existe no banco, baseado no email
        if( $connect->pdo->has( $prepare->queryString, ['id' => $userID] )):
            //Executa update e retorna resultado
            $update = $connect->pdo->update('users', $user_data, ['id' => $userID]); 
            $result = $update->rowCount();
        endif;

        return $result;
        
    } 

    /* Insere diversos usuários por vez em tabela */
    function insertMultipleUsers( array $userdata, $project, $company = ''){
        //Retorna se não houver dados
        if(count($userdata) <= 0 || empty($userdata['email']))
            return 'Linha sem identificador "email", não é permitido inserir ou adicionar.';
        
        $userdata['project'] = $project; //Adiciona id de projeto ao array
        $userdata['company'] = $company; //Adiciona id de empresa

        //Invoca função de incluir um novo usuário
        return $this->connect->newUser($userdata);      
    }
    
    /*
        ##### Sessões de usuário
    */
    //Iniciando sessão
    function initSession(){
        ob_start();
        session_start();
    }

    //Registrando sessão
    protected function registerSession($userData){
        
        //Gerando hash
        $cookieToken = password_hash( $userData['email'], CRYPT_BLOWFISH);
        $_SESSION['user'] = $userData; //adiciona dados do usuário na sessão
        $this->user = $_SESSION['user'];
        
        //Setando cookies
        $cookie = setcookie('gafp', $cookieToken, time()+172800, _PATH_ );

        //Se sessão inicializada e cookie setado
        if( isset( $_SESSION['user'] ) && $cookie ):
            return true;
        else:
            return false;
        endif;
    }

    /*
        ##### Funções de verificação de login
    */
    //Retorna se usuarios esta logado, sim ou não
    function isLogged(){        
        if( isset($_SESSION['user']) ):
            return true;
        else:
            return false;
        endif;
    }

    function isCookieValid(){ 
        if( isset($_COOKIE['gafp']) && password_verify( $this->user['email'], $_COOKIE['gafp']) ):
            return true;
        else:
            return false;
        endif;
    }

    //Se usuario deslogado, direciona para tela de login
    function logout(\Psr\Http\Message\ResponseInterface $response){
        ob_end_clean();
        session_destroy();
        setcookie('gafp');
        setcookie('gafp-user');
        return $response->withStatus(200)->withHeader('Location', _PATH_); 
    }

}