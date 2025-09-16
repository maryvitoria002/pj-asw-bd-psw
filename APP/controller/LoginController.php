<?php
session_start();

// Headers CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Verificar método
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($metodo !== 'POST') {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido'
    ]);
    exit();
}

try {
    // Conectar ao banco
    $dsn = "mysql:host=localhost;dbname=projeto;charset=utf8mb4";
    $pdo = new PDO($dsn, "root", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Validar dados
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Email e senha são obrigatórios'
        ]);
        exit();
    }
    
    // Buscar usuário no banco
    $sql = "SELECT * FROM ClienteUsuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Usuário não encontrado'
        ]);
        exit();
    }
    
    // Verificar senha (comparação com SHA256)
    $senhaCriptografada = hash('sha256', $senha);
    
    if ($senhaCriptografada !== $usuario['senha']) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Senha incorreta'
        ]);
        exit();
    }
    
    // Login bem-sucedido - criar sessão
    $_SESSION['usuario_logado'] = true;
    $_SESSION['usuario_id'] = $usuario['cpf'];
    $_SESSION['usuario_nome'] = $usuario['nome_completo'];
    $_SESSION['usuario_email'] = $usuario['email'];
    
    echo json_encode([
        'sucesso' => true,
        'mensagem' => 'Login realizado com sucesso!',
        'usuario' => [
            'nome' => $usuario['nome_completo'],
            'email' => $usuario['email']
        ]
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro na conexão com banco de dados: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro interno: ' . $e->getMessage()
    ]);
}
?>
