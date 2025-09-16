<?php
session_start();

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../BD/Conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

function erro($msg, $status = 400) {
    http_response_code($status);
    echo json_encode(['sucesso' => false, 'mensagem' => $msg]);
    exit;
}

try {
    if (!isset($_SESSION['usuario_logado']) || !$_SESSION['usuario_logado']) {
        erro('Usuário não autenticado', 401);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        erro('Método não permitido', 405);
    }

    $cpf = $_SESSION['usuario_id'] ?? null;
    if (!$cpf) erro('CPF não encontrado', 401);

    $pdo = Conexao::getInstancia();

    // Pedidos do usuário
    $sqlPedidos = "SELECT idpedido, datapedido, dataentrega, total, status FROM Pedido WHERE cliente_cpf = :cpf ORDER BY idpedido DESC";
    $stmt = $pdo->prepare($sqlPedidos);
    $stmt->execute([':cpf' => $cpf]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Itens por pedido
    $sqlItens = "SELECT ip.pedido_idpedido, ip.quantidade, ip.precounitario, p.nome AS produto, p.idproduto
                 FROM ItemPedido ip INNER JOIN Produto p ON p.idproduto = ip.produto_idproduto
                 WHERE ip.pedido_idpedido = :pedido";
    $stmtItens = $pdo->prepare($sqlItens);

    foreach ($pedidos as &$pedido) {
        $stmtItens->execute([':pedido' => $pedido['idpedido']]);
        $pedido['itens'] = $stmtItens->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode(['sucesso' => true, 'pedidos' => $pedidos], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    erro('Erro ao buscar histórico: ' . $e->getMessage(), 500);
}
