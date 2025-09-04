<?php

class Conexao {

    private static $instancia = null;
    private $pdo;

    private function __construct()
    {
        $host = 'localhost';
        $dbName = 'musicwave';
        $username = 'root';
        $porta = '3306';
        $pass = '';
        $dsn = "mysql:host=$host; port=$porta; dbname=$dbName;";
        
        try {
            
            $this->pdo = new PDO($dsn, $username, password: $pass);
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }

        
    }

    public static function getInstancia(): PDO
    {
        if (self::$instancia === null) {
            self::$instancia = new self();
            if (self::$instancia->pdo === null) {
                print "Erro na conexão com o banco de dados.";
                exit;
            }
        }

        return self::$instancia->pdo;
    }
}

$pdo = Conexao::getInstancia();