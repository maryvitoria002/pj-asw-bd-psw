<?php
session_start();

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Verificar método e ação
$metodo = $_SERVER['REQUEST_METHOD'];
$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

if ($metodo === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    switch ($acao) {
        case 'logout':
            // Destruir sessão
            session_unset();
            session_destroy();
            
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Logout realizado com sucesso!'
            ]);
            break;
            
        case 'verificar_sessao':
            if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
                echo json_encode([
                    'sucesso' => true,
                    'logado' => true,
                    'usuario' => $_SESSION['usuario_nome'] ?? 'Usuário'
                ]);
            } else {
                echo json_encode([
                    'sucesso' => true,
                    'logado' => false
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Ação não encontrada'
            ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro interno: ' . $e->getMessage()
    ]);
}
?>
