<?php
/**
 * Script para verificar se as tabelas existem no banco de dados
 */

require_once __DIR__ . '/BD/Conexao.php';

try {
    $pdo = Conexao::getInstancia();
    
    echo "🔍 Verificando estrutura do banco de dados 'projeto'...\n\n";
    
    // Lista de tabelas esperadas
    $tabelasEsperadas = [
        'ClienteUsuario',
        'Produto',
        'Pedido',
        'Pagamento',
        'ItemPedido',
        'Carrinho',
        'CarrinhoItem'
    ];
    
    // Verifica se o banco existe
    $stmt = $pdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'projeto'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Banco de dados 'projeto' não existe!\n";
        echo "Execute o arquivo executar-script.php primeiro.\n";
        exit(1);
    }
    
    echo "✅ Banco de dados 'projeto' encontrado.\n\n";
    
    // Verifica cada tabela
    $tabelasEncontradas = [];
    foreach ($tabelasEsperadas as $tabela) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$tabela'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabela '$tabela' existe.\n";
            $tabelasEncontradas[] = $tabela;
            
            // Mostra informações da tabela
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM $tabela");
            $resultado = $stmt->fetch();
            echo "   📊 Registros: {$resultado['total']}\n";
            
        } else {
            echo "❌ Tabela '$tabela' NÃO existe.\n";
        }
    }
    
    echo "\n📋 Resumo:\n";
    echo "Tabelas encontradas: " . count($tabelasEncontradas) . "/" . count($tabelasEsperadas) . "\n";
    
    if (count($tabelasEncontradas) == count($tabelasEsperadas)) {
        echo "✅ Todas as tabelas estão presentes!\n";
    } else {
        echo "⚠ Algumas tabelas estão faltando. Execute o script SQL.\n";
    }
    
    // Testa uma consulta simples na tabela ClienteUsuario
    echo "\n🧪 Testando consulta na tabela ClienteUsuario...\n";
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM ClienteUsuario");
    $resultado = $stmt->fetch();
    echo "✅ Consulta executada com sucesso! Total de usuários: {$resultado['total']}\n";
    
} catch (PDOException $e) {
    echo "❌ Erro de conexão/consulta: " . $e->getMessage() . "\n";
    
    // Sugere soluções
    if (strpos($e->getMessage(), "doesn't exist") !== false) {
        echo "\n💡 Soluções:\n";
        echo "1. Execute o arquivo BD/executar-script.php\n";
        echo "2. Verifique se o MySQL está rodando\n";
        echo "3. Confirme as credenciais de acesso (usuário: root, senha: 1234)\n";
    }
} catch (Exception $e) {
    echo "❌ Erro geral: " . $e->getMessage() . "\n";
}
