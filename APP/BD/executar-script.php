<?php
/**
 * Script para executar o arquivo SQL e criar o banco de dados e tabelas
 */

try {
    // Conexão inicial sem especificar banco de dados
    $pdo = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Lê o arquivo SQL
    $sql = file_get_contents(__DIR__ . '/script.sql');
    
    if ($sql === false) {
        throw new Exception("Erro ao ler o arquivo script.sql");
    }
    
    // Divide o script em comandos individuais
    $commands = explode(';', $sql);
    
    echo "Executando script SQL...\n";
    
    foreach ($commands as $command) {
        $command = trim($command);
        if (!empty($command)) {
            try {
                $pdo->exec($command);
                echo "✓ Comando executado com sucesso\n";
            } catch (PDOException $e) {
                // Ignora erros de tabela já existente
                if (strpos($e->getMessage(), 'already exists') === false) {
                    echo "⚠ Aviso: " . $e->getMessage() . "\n";
                }
            }
        }
    }
    
    echo "\n✅ Script SQL executado com sucesso!\n";
    echo "Banco de dados 'projeto' criado/atualizado.\n";
    
} catch (Exception $e) {
    echo "❌ Erro ao executar script: " . $e->getMessage() . "\n";
    exit(1);
}
