<?php

class Conexao {

    private static $instancia = null;
    private $pdo;

    private function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=projeto;charset=utf8mb4";
        
        try {
            $this->pdo = new PDO($dsn, "root", "1234");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
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