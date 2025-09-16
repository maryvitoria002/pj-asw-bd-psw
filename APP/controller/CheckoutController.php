<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../BD/Conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function respostaErro($mensagem, $status = 400) {
    http_response_code($status);
    echo json_encode(['sucesso' => false, 'mensagem' => $mensagem]);
    exit;
}

try {
    if (!isset($_SESSION['usuario_logado']) || !$_SESSION['usuario_logado']) {
        respostaErro('Usuário não autenticado', 401);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respostaErro('Método não permitido', 405);
    }

    $cpf = $_SESSION['usuario_id'] ?? null;
    if (!$cpf) {
        respostaErro('CPF do usuário não encontrado na sessão', 401);
    }

    // Aceitar JSON ou form-urlencoded
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($contentType, 'application/json') !== false) {
        $data = json_decode(file_get_contents('php://input'), true);
    } else {
        $data = $_POST;
        // Se items vier como JSON string em form-urlencoded
        if (isset($data['items']) && is_string($data['items'])) {
            $try = json_decode($data['items'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['items'] = $try;
            }
        }
    }

    $metodo = $data['metodo'] ?? $data['forma_pagamento'] ?? 'PIX';
    $items = $data['items'] ?? [];

    if (!in_array($metodo, ['PIX', 'CARTAO', 'BOLETO'])) {
        respostaErro('Método de pagamento inválido. Use PIX, CARTAO ou BOLETO.');
    }
    if (!is_array($items) || count($items) === 0) {
        respostaErro('Carrinho vazio ou inválido.');
    }

    $pdo = Conexao::getInstancia();
    $pdo->beginTransaction();

    // Criar pedido
    $stmt = $pdo->prepare("INSERT INTO Pedido (datapedido, dataentrega, total, status, cliente_cpf) VALUES (CURDATE(), NULL, 0, :status, :cpf)");
    $statusPedido = 'PROCESSANDO';
    $stmt->execute([':status' => $statusPedido, ':cpf' => $cpf]);
    $pedidoId = (int)$pdo->lastInsertId();

    $total = 0.0;

    // Preparar statements
    $stmtLock = $pdo->prepare("SELECT preco, estoque FROM Produto WHERE idproduto = :id FOR UPDATE");
    $stmtUpdateEstoque = $pdo->prepare("UPDATE Produto SET estoque = estoque - :qtd WHERE idproduto = :id");
    $stmtItem = $pdo->prepare("INSERT INTO ItemPedido (produto_idproduto, pedido_idpedido, quantidade, precounitario) VALUES (:id, :pedido, :qtd, :preco)");

    foreach ($items as $item) {
        $id = (int)($item['id'] ?? $item['produto_id'] ?? 0);
        $qtd = (int)($item['qtd'] ?? $item['quantidade'] ?? 0);
        if ($id <= 0 || $qtd <= 0) {
            $pdo->rollBack();
            respostaErro('Item do carrinho inválido.');
        }

        // Lock do produto
        $stmtLock->execute([':id' => $id]);
        $prod = $stmtLock->fetch(PDO::FETCH_ASSOC);
        if (!$prod) {
            $pdo->rollBack();
            respostaErro("Produto ID $id não encontrado.");
        }
        if ($prod['estoque'] < $qtd) {
            $pdo->rollBack();
            respostaErro("Estoque insuficiente para o produto ID $id. Disponível: {$prod['estoque']}.");
        }

        // Atualizar estoque
        $stmtUpdateEstoque->execute([':qtd' => $qtd, ':id' => $id]);

        // Inserir item
        $preco = (float)$prod['preco'];
        $stmtItem->execute([
            ':id' => $id,
            ':pedido' => $pedidoId,
            ':qtd' => $qtd,
            ':preco' => $preco
        ]);

        $total += $preco * $qtd;
    }

    // Atualizar total do pedido
    $stmtUpdPedido = $pdo->prepare("UPDATE Pedido SET total = :total WHERE idpedido = :pedido");
    $stmtUpdPedido->execute([':total' => $total, ':pedido' => $pedidoId]);

    // Registrar pagamento (simulado)
    $stmtPag = $pdo->prepare("INSERT INTO Pagamento (data_retirada, forma_pagamento, valor, comprovante, pedido_idpedido, cliente_cpf) VALUES (NULL, :forma, :valor, NULL, :pedido, :cpf)");
    $stmtPag->execute([
        ':forma' => $metodo,
        ':valor' => $total,
        ':pedido' => $pedidoId,
        ':cpf' => $cpf
    ]);

    $pdo->commit();

    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Pedido criado com sucesso!',
        'pedido_id' => $pedidoId,
        'total' => $total,
        'status' => $statusPedido,
        'metodo' => $metodo
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    respostaErro('Erro ao processar checkout: ' . $e->getMessage(), 500);
}
