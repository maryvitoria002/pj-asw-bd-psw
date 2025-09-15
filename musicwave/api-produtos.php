<?php
/*
====================================================================
🛒 API DE PRODUTOS PARA A LOJA
====================================================================

🎯 PROPÓSITO:
Busca produtos do banco de dados e retorna em formato JSON
para exibição na loja com 4 imagens por produto.

🔧 FUNCIONALIDADES:
✅ Busca todos os produtos ativos
✅ Gera 4 caminhos de imagem baseados na estrutura do catálogo
✅ Inclui descrição completa
✅ Retorna JSON formatado para o frontend

📡 RETORNO:
Array de objetos com: id, categoria, título, preço, descrição, imagem, thumbnails
====================================================================
*/

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../APP/BD/Conexao.php';

try {
    // Buscar todos os produtos do banco
    $sql = "SELECT idproduto, nome, preco, estoque, marca, imagem, descricao 
            FROM Produto 
            WHERE estoque > 0 
            ORDER BY idproduto";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $products = [];
    
    foreach ($produtos as $produto) {
        // Determinar categoria baseada no nome do produto
        $categoria = determinarCategoria($produto['nome']);
        
        // Gerar caminhos das imagens
        $imagePaths = gerarCaminhosImagens($produto['idproduto'], $categoria, $produto['nome']);
        
        $products[] = [
            'id' => (int)$produto['idproduto'],
            'category' => $categoria,
            'title' => $produto['nome'],
            'price' => (float)$produto['preco'],
            'description' => $produto['descricao'] ?: 'Descrição não disponível.',
            'image' => $imagePaths['main'],
            'thumbnails' => $imagePaths['thumbnails'],
            'stock' => (int)$produto['estoque'],
            'marca' => $produto['marca']
        ];
    }
    
    echo json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao carregar produtos: ' . $e->getMessage()]);
}

/**
 * Determina a categoria do produto baseado no nome
 */
function determinarCategoria($nome) {
    $nome = strtolower($nome);
    
    if (strpos($nome, 'violino') !== false) return 'violino';
    if (strpos($nome, 'viola') !== false && strpos($nome, 'caipira') === false) return 'viola';
    if (strpos($nome, 'viola') !== false && strpos($nome, 'caipira') !== false) return 'viola_caipira';
    if (strpos($nome, 'violoncelo') !== false) return 'violoncelo';
    if (strpos($nome, 'contrabaixo') !== false || strpos($nome, 'baixo') !== false) return 'baixo';
    if (strpos($nome, 'bandolim') !== false) return 'bandolim';
    if (strpos($nome, 'ukulele') !== false) return 'ukulele';
    if (strpos($nome, 'banjo') !== false) return 'banjo';
    if (strpos($nome, 'violão') !== false) return 'violao';
    if (strpos($nome, 'guitarra') !== false) return 'guitarra';
    if (strpos($nome, 'cavaquinho') !== false) return 'cavaquinho';
    
    return 'instrumento'; // categoria padrão
}

/**
 * Gera os caminhos das 4 imagens baseado na estrutura do catálogo
 */
function gerarCaminhosImagens($id, $categoria, $nome) {
    // Mapear categorias para pastas do catálogo
    $categoriaPastas = [
        'violino' => 'violinos',
        'viola' => 'violas', 
        'viola_caipira' => 'violas_caipiras',
        'violoncelo' => 'violoncelos',
        'baixo' => 'baixos',
        'bandolim' => 'bandolins',
        'ukulele' => 'ukuleles',
        'banjo' => 'banjos',
        'violao' => 'violões',
        'guitarra' => 'guitarras',
        'cavaquinho' => 'cavaquinhos'
    ];
    
    $pasta = $categoriaPastas[$categoria] ?? 'instrumentos';
    
    // Determinar número da pasta baseado no ID ou nome
    $numeroPasta = determinarNumeroPasta($id, $categoria);
    
    // Nome base da imagem
    $nomeImagem = $categoria;
    if ($categoria === 'viola_caipira') $nomeImagem = 'viola_caipira';
    
    // Caminho principal
    $caminhoBase = "catálogo/{$pasta}/{$numeroPasta}*/";
    $imagemPrincipal = "{$caminhoBase}{$nomeImagem}{$numeroPasta}.png";
    
    // 4 thumbnails (imagem principal + 3 variações)
    $thumbnails = [
        "{$caminhoBase}{$nomeImagem}{$numeroPasta}.png",
        "{$caminhoBase}{$nomeImagem}{$numeroPasta}- verso.png",
        "{$caminhoBase}{$nomeImagem}{$numeroPasta}- detalhes.png",
        "{$caminhoBase}{$nomeImagem}{$numeroPasta}- afinadores.png"
    ];
    
    return [
        'main' => $imagemPrincipal,
        'thumbnails' => $thumbnails
    ];
}

/**
 * Determina o número da pasta baseado no ID e categoria
 */
function determinarNumeroPasta($id, $categoria) {
    // Mapping específico baseado na ordem dos INSERTs no banco
    $mapeamento = [
        // Violinos (IDs 1-8)
        'violino' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8],
        
        // Violas (IDs 9-16) 
        'viola' => [9 => 1, 10 => 2, 11 => 3, 12 => 4, 13 => 5, 14 => 6, 15 => 7, 16 => 8],
        
        // Violoncelos (IDs 17-24)
        'violoncelo' => [17 => 1, 18 => 2, 19 => 3, 20 => 4, 21 => 5, 22 => 6, 23 => 7, 24 => 8],
        
        // Baixos (IDs 25-32)
        'baixo' => [25 => 1, 26 => 2, 27 => 3, 28 => 4, 29 => 5, 30 => 6, 31 => 7, 32 => 8],
        
        // Bandolins (IDs 33-40)
        'bandolim' => [33 => 1, 34 => 2, 35 => 3, 36 => 4, 37 => 5, 38 => 6, 39 => 7, 40 => 8],
        
        // Ukuleles (IDs 41-48)
        'ukulele' => [41 => 1, 42 => 2, 43 => 3, 44 => 4, 45 => 5, 46 => 6, 47 => 7, 48 => 8],
        
        // Violas Caipiras (IDs 49-56)
        'viola_caipira' => [49 => 1, 50 => 2, 51 => 3, 52 => 4, 53 => 5, 54 => 6, 55 => 7, 56 => 8],
        
        // Banjos (IDs 57-64)
        'banjo' => [57 => 1, 58 => 2, 59 => 3, 60 => 4, 61 => 5, 62 => 6, 63 => 7, 64 => 8],
        
        // Violões (IDs 65-72)
        'violao' => [65 => 1, 66 => 2, 67 => 3, 68 => 4, 69 => 5, 70 => 6, 71 => 7, 72 => 8],
        
        // Guitarras (IDs 73-77)
        'guitarra' => [73 => 1, 74 => 2, 75 => 3, 76 => 4, 77 => 5],
        
        // Cavaquinhos (IDs 78-81)
        'cavaquinho' => [78 => 1, 79 => 2, 80 => 3, 81 => 4]
    ];
    
    return $mapeamento[$categoria][$id] ?? 1;
}
?>