<?php

class Connection{
    private $host = 'localhost';
    private $db   = 'dommus';
    private $user = 'root';
    private $pass = 'root';
    private $port = 3306;
    private $charset = 'utf8mb4';
    private $pdo;

    private static ?Connection $instance = null;

    private function __construct(){
        $dns = "mysql:host=$this->host;port=$this->port;dbname=$this->db;charset=$this->charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dns, $this->user, $this->pass, $options);
        }
        catch (PDOException $e) {
            throw new Exception('Erro ao conectar com o banco de dados: ' . $e->getMessage());
        }
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->pdo;
    }

}