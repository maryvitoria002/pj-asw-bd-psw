<?php
/*
====================================================================
🔧 SCRIPT PARA CRIAR USUÁRIO ADMIN
====================================================================
Execute este arquivo uma vez para criar um usuário administrador.
Depois pode deletar este arquivo por segurança.
====================================================================
*/

require_once '../APP/BD/Conexao.php';

try {
    $pdo = Conexao::getInstancia();
    
    // Dados do admin
    $usuario = 'admin';
    $senha = password_hash('123456', PASSWORD_DEFAULT); // Mude a senha!
    $email = 'admin@musicwave.com';
    $nome = 'Administrador';
    
    // Tentar inserir na tabela admin (ajuste conforme sua estrutura)
    $sql = "INSERT INTO admin (usuario, senha, email, nome) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$usuario, $senha, $email, $nome])) {
        echo "✅ Usuário admin criado com sucesso!<br>";
        echo "👤 Usuário: admin<br>";
        echo "🔑 Senha: 123456<br>";
        echo "<br>⚠️ IMPORTANTE: Mude a senha após o primeiro login!";
    } else {
        echo "❌ Erro ao criar usuário admin.";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage();
    echo "<br><br>📋 Isso pode significar que:";
    echo "<br>1. A tabela 'admin' não existe";
    echo "<br>2. Os campos são diferentes";
    echo "<br>3. Já existe um usuário com esse nome";
    
    // Vamos tentar descobrir a estrutura da tabela
    try {
        $stmt = $pdo->query("DESCRIBE admin");
        echo "<br><br>📊 Estrutura da tabela 'admin':";
        while ($row = $stmt->fetch()) {
            echo "<br>- " . $row['Field'] . " (" . $row['Type'] . ")";
        }
    } catch (Exception $e2) {
        echo "<br><br>❌ Tabela 'admin' não encontrada.";
        echo "<br>Verifique o nome correto da tabela de administradores.";
    }
}
?>