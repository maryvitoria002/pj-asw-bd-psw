<?php
/**
 * Script para criar o banco de dados e executar todas as configurações necessárias
 */

echo "🚀 Inicializando banco de dados MusicWave...\n\n";

// Executa o script SQL
echo "1️⃣ Executando script SQL...\n";
include __DIR__ . '/BD/executar-script.php';

echo "\n2️⃣ Verificando estrutura criada...\n";
include __DIR__ . '/verificar-tabelas.php';

echo "\n✅ Processo de criação do banco concluído!\n";
echo "O sistema está pronto para uso.\n";
