<?php
$arquivos = [
    'APP/model/Usuario.php',
    'APP/controller/UsuarioController.php',
    'APP/sessao.php'
];

foreach ($arquivos as $arquivo) {
    if (!file_exists($arquivo)) {
        echo "Arquivo não encontrado: $arquivo\n";
        continue;
    }
    
    $conteudo = file_get_contents($arquivo);
    
    // Remover comentários PHPDoc completos
    $conteudo = preg_replace('/\s*\/\*\*[^*]*\*+(?:[^*\/][^*]*\*+)*\/\s*/', "\n    // ", $conteudo);
    
    // Limpar linhas vazias múltiplas
    $conteudo = preg_replace('/\n\s*\n\s*\n/', "\n\n", $conteudo);
    
    // Remover espaços no final das linhas
    $conteudo = preg_replace('/[ \t]+$/m', '', $conteudo);
    
    file_put_contents($arquivo, $conteudo);
    echo "✅ Limpo: $arquivo\n";
}

echo "🎉 Limpeza concluída!\n";
?>
