<?php

class Database{
    private PDO $pdo;
    public function __construct(string $dsn, string $user, string $password, array $options){
        try{
            $this->pdo = new PDO ($dsn, $user, $password, $options);
        }
        catch(PDOException $e){
            die("Db error: ". $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}