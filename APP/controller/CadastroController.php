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
    
    // Validar dados obrigatórios
    $nome_completo = $_POST['nome_completo'] ?? '';
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? ''); // Remove pontos e traços
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // Dados opcionais
    $rg = $_POST['rg'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    
    if (empty($nome_completo) || empty($cpf) || empty($email) || empty($senha)) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Nome, CPF, email e senha são obrigatórios'
        ]);
        exit();
    }
    
    // Validar CPF
    function validarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
    
    if (!validarCPF($cpf)) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'CPF inválido'
        ]);
        exit();
    }
    
    // Verificar se CPF já existe
    $sql = "SELECT cpf FROM ClienteUsuario WHERE cpf = :cpf";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'CPF já cadastrado no sistema'
        ]);
        exit();
    }
    
    // Verificar se email já existe
    $sql = "SELECT email FROM ClienteUsuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Email já cadastrado no sistema'
        ]);
        exit();
    }
    
    // Validar senha
    if (strlen($senha) < 6) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Senha deve ter pelo menos 6 caracteres'
        ]);
        exit();
    }
    
    // Inserir usuário (senha sem criptografia)
    $sql = "INSERT INTO ClienteUsuario (cpf, nome_completo, rg, email, senha, telefone, data_cadastro) 
            VALUES (:cpf, :nome_completo, :rg, :email, :senha, :telefone, CURDATE())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':nome_completo', $nome_completo);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha); // Senha em texto puro
    $stmt->bindParam(':telefone', $telefone);
    
    if ($stmt->execute()) {
        // Criar carrinho para o novo usuário
        try {
            $sqlCarrinho = "INSERT INTO Carrinho (cliente_cpf, data_criacao) VALUES (:cpf, CURDATE())";
            $stmtCarrinho = $pdo->prepare($sqlCarrinho);
            $stmtCarrinho->bindParam(':cpf', $cpf);
            $stmtCarrinho->execute();
        } catch (Exception $e) {
            // Se der erro no carrinho, não falha o cadastro
            error_log("Erro ao criar carrinho: " . $e->getMessage());
        }
        
        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Usuário cadastrado com sucesso!'
        ]);
    } else {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro ao cadastrar usuário'
        ]);
    }
    
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
