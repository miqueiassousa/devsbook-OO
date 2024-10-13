<?php

/* Data Access Objects (DAO, Objetos de Acesso a Dados), fornecem uma API 
genérica para acessar dados em diferentes tipos de bancos de dados. Como 
resultado, pode-se alterar o sistema de banco de dados sem haver a necessidade
de alterar o código que utiliza DAO para fazer o acesso. */

/*  O DAO é um padrão para aplicações implementadas com linguagens de programação
orientada a objetos e arquitetura MVC. E que utilizam persistência de dados, onde
existe a separação das regras de negócio das regras de acesso a banco de dados. */

/* Classes DAO são responsáveis por trocar informações com o SGBD e fornecer 
operações CRUD e de pesquisas, elas devem ser capazes de buscar dados no banco 
e transformar esses em objetos ou lista de objetos, fazendo uso de listas genéricas 
(BOX 3), também deverão receber os objetos, converter em instruções SQL e mandar  */

class User {
    public $id;
    public $email;
    public $password;
    public $name;
    public $birthdate;
    public $city;
    public $work;
    public $avatar;
    public $cover;
    public $token;
    public $following;
    public $followers;
    public $photos;
}

/* A Interface permite definir um “contrato” na qual as classes que vão implementá-las 
terão que ter os métodos definidos pela interface */

interface UserDAO {
    public function findByToken($token);
    public function findByEmail($email);
    public function findById($id);
    public function update(User $u);
    public function insert(User $u);
}