<?php

/* ESTA CLASSE É PARA AUTENTICAÇÃO DO USUARIO */


require_once 'dao/UserDaoMysql.php';

/* Verificar o token do usuario */

/* O Token sera armazenado em uma sessão */

class Auth {
    private $pdo;
    private $base;
    private $dao;

    /* A extensão PHP Data Objects ( PDO ) define uma interface leve e 
    consistente para acessar bancos de dados no PHP. */

    public function __construct(PDO $pdo, $base) {
        /* PDO é a conexão com o banco */
        $this->pdo = $pdo;

        /* Caminho do projeto no localhost */
        $this->base = $base;
        
        /* Criar e instaciar a DAO */
        $this->dao = new UserDaoMysql($this->pdo);
    }

    /* Retorna o usuario logado ou então caso não ache 
    ele vai redirecioanr para a pagina de login
     */
    public function checkToken() {

        /* Esta sessão foi iniciada no config.php para conexão com banco */

        /* "!" Se existe e Se não estiver vazio */
        if(!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

             /* Verificar no banco de dados se ele existe */
            
             /* findByToken é um método da classe UserDaoMysql pra verificar
             se o token existe */

            $user = $this->dao->findByToken($token);
            
            /* Verificar se achou */
            /* Informações do usuarios logado */
            if($user) {
                return $user;
            }
        }

        header("Location: ".$this->base."/login.php");
        exit;
    }


    /* Fazer verificação do Login */
    public function validateLogin($email, $password) {
        $user = $this->dao->findByEmail($email);
        if($user) {

            if(password_verify($password, $user->password)) {
                $token = md5(time().rand(0, 9999));

                /* Jogar o Token na sessão */
                $_SESSION['token'] = $token;
                /* Jogaro token no usuario */
                $user->token = $token;
                $this->dao->update($user);

                return true;
            }

        }

        return false;
    }

    public function emailExists($email) {
        return $this->dao->findByEmail($email) ? true : false;
    }

    public function registerUser($name, $email, $password, $birthdate) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0, 9999));

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $hash;
        $newUser->birthdate = $birthdate;
        $newUser->token = $token;

        $this->dao->insert($newUser);

        $_SESSION['token'] = $token;
    }

}