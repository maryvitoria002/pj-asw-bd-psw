<?php
session_start();
require_once '../BD/Conexao.php';

header('Content-Type: application/json');

class AdminController {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = Conexao::getInstancia();
        } catch (Exception $e) {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Erro de conexão com o banco de dados'
            ]);
            exit;
        }
    }
    
    public function login($usuario, $senha) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id_admin, usuario, senha, nome_completo, email, nivel_acesso, ativo 
                FROM Administrador 
                WHERE usuario = ? AND ativo = TRUE
            ");
            $stmt->execute([$usuario]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($admin && password_verify($senha, $admin['senha'])) {
                // Atualizar último login
                $this->atualizarUltimoLogin($admin['id_admin']);
                
                // Criar sessão
                $_SESSION['admin_logado'] = true;
                $_SESSION['admin_id'] = $admin['id_admin'];
                $_SESSION['admin_usuario'] = $admin['usuario'];
                $_SESSION['admin_nome'] = $admin['nome_completo'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_nivel'] = $admin['nivel_acesso'];
                
                return [
                    'sucesso' => true,
                    'mensagem' => 'Login realizado com sucesso',
                    'admin' => [
                        'id' => $admin['id_admin'],
                        'usuario' => $admin['usuario'],
                        'nome' => $admin['nome_completo'],
                        'nivel' => $admin['nivel_acesso']
                    ]
                ];
            } else {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário ou senha inválidos'
                ];
            }
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro interno do servidor'
            ];
        }
    }
    
    public function logout() {
        session_destroy();
        return [
            'sucesso' => true,
            'mensagem' => 'Logout realizado com sucesso'
        ];
    }
    
    public function verificarSessao() {
        if (!isset($_SESSION['admin_logado']) || !$_SESSION['admin_logado']) {
            return [
                'sucesso' => false,
                'mensagem' => 'Acesso negado. Faça login como administrador.'
            ];
        }
        
        return [
            'sucesso' => true,
            'admin' => [
                'id' => $_SESSION['admin_id'],
                'usuario' => $_SESSION['admin_usuario'],
                'nome' => $_SESSION['admin_nome'],
                'nivel' => $_SESSION['admin_nivel']
            ]
        ];
    }
    
    private function atualizarUltimoLogin($adminId) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE Administrador 
                SET ultimo_login = CURRENT_TIMESTAMP 
                WHERE id_admin = ?
            ");
            $stmt->execute([$adminId]);
        } catch (Exception $e) {
            // Log do erro, mas não interromper o login
        }
    }
    
    // ===== GESTÃO DE PRODUTOS =====
    
    public function listarProdutos($limite = null, $offset = null) {
        try {
            $sql = "SELECT * FROM Produto ORDER BY nome";
            if ($limite) {
                $sql .= " LIMIT $limite";
                if ($offset) {
                    $sql .= " OFFSET $offset";
                }
            }
            
            $stmt = $this->pdo->query($sql);
            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Contar total
            $totalStmt = $this->pdo->query("SELECT COUNT(*) as total FROM Produto");
            $total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            return [
                'sucesso' => true,
                'produtos' => $produtos,
                'total' => $total
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao listar produtos: ' . $e->getMessage()
            ];
        }
    }
    
    public function adicionarProduto($nome, $preco, $estoque, $marca, $imagem = null) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO Produto (nome, preco, estoque, marca, imagem) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$nome, $preco, $estoque, $marca, $imagem]);
            
            return [
                'sucesso' => true,
                'mensagem' => 'Produto adicionado com sucesso',
                'id' => $this->pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao adicionar produto: ' . $e->getMessage()
            ];
        }
    }
    
    public function editarProduto($id, $nome, $preco, $estoque, $marca, $imagem = null) {
        try {
            if ($imagem) {
                $stmt = $this->pdo->prepare("
                    UPDATE Produto 
                    SET nome = ?, preco = ?, estoque = ?, marca = ?, imagem = ? 
                    WHERE idproduto = ?
                ");
                $stmt->execute([$nome, $preco, $estoque, $marca, $imagem, $id]);
            } else {
                $stmt = $this->pdo->prepare("
                    UPDATE Produto 
                    SET nome = ?, preco = ?, estoque = ?, marca = ? 
                    WHERE idproduto = ?
                ");
                $stmt->execute([$nome, $preco, $estoque, $marca, $id]);
            }
            
            return [
                'sucesso' => true,
                'mensagem' => 'Produto atualizado com sucesso'
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao editar produto: ' . $e->getMessage()
            ];
        }
    }
    
    public function removerProduto($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM Produto WHERE idproduto = ?");
            $stmt->execute([$id]);
            
            return [
                'sucesso' => true,
                'mensagem' => 'Produto removido com sucesso'
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao remover produto: ' . $e->getMessage()
            ];
        }
    }
    
    // ===== GESTÃO DE USUÁRIOS =====
    
    public function listarUsuarios() {
        try {
            $stmt = $this->pdo->query("
                SELECT cpf, nome_completo, email, telefone, data_cadastro 
                FROM ClienteUsuario 
                ORDER BY data_cadastro DESC
            ");
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'sucesso' => true,
                'usuarios' => $usuarios
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao listar usuários: ' . $e->getMessage()
            ];
        }
    }
    
    public function removerUsuario($cpf) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM ClienteUsuario WHERE cpf = ?");
            $stmt->execute([$cpf]);
            
            return [
                'sucesso' => true,
                'mensagem' => 'Usuário removido com sucesso'
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao remover usuário: ' . $e->getMessage()
            ];
        }
    }
    
    // ===== DASHBOARD ESTATÍSTICAS =====
    
    public function obterEstatisticas() {
        try {
            // Total de produtos
            $produtosStmt = $this->pdo->query("SELECT COUNT(*) as total FROM Produto");
            $totalProdutos = $produtosStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total de usuários
            $usuariosStmt = $this->pdo->query("SELECT COUNT(*) as total FROM ClienteUsuario");
            $totalUsuarios = $usuariosStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total de pedidos
            $pedidosStmt = $this->pdo->query("SELECT COUNT(*) as total FROM Pedido");
            $totalPedidos = $pedidosStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Produtos com baixo estoque
            $estoqueStmt = $this->pdo->query("SELECT COUNT(*) as total FROM Produto WHERE estoque < 10");
            $produtosBaixoEstoque = $estoqueStmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            return [
                'sucesso' => true,
                'estatisticas' => [
                    'total_produtos' => $totalProdutos,
                    'total_usuarios' => $totalUsuarios,
                    'total_pedidos' => $totalPedidos,
                    'produtos_baixo_estoque' => $produtosBaixoEstoque
                ]
            ];
        } catch (Exception $e) {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao obter estatísticas: ' . $e->getMessage()
            ];
        }
    }
}

// Processar requisições
$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'login':
            $usuario = trim($_POST['usuario'] ?? '');
            $senha = $_POST['senha'] ?? '';
            
            if (empty($usuario) || empty($senha)) {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Usuário e senha são obrigatórios'
                ]);
            } else {
                $resultado = $controller->login($usuario, $senha);
                echo json_encode($resultado);
            }
            break;
            
        case 'logout':
            $resultado = $controller->logout();
            echo json_encode($resultado);
            break;
            
        case 'adicionar_produto':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $nome = trim($_POST['nome'] ?? '');
            $preco = floatval($_POST['preco'] ?? 0);
            $estoque = intval($_POST['estoque'] ?? 0);
            $marca = trim($_POST['marca'] ?? '');
            $imagem = $_POST['imagem'] ?? null;
            
            if (empty($nome) || $preco <= 0 || $estoque < 0) {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Dados inválidos. Verifique os campos obrigatórios.'
                ]);
            } else {
                $resultado = $controller->adicionarProduto($nome, $preco, $estoque, $marca, $imagem);
                echo json_encode($resultado);
            }
            break;
            
        case 'editar_produto':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $id = intval($_POST['id'] ?? 0);
            $nome = trim($_POST['nome'] ?? '');
            $preco = floatval($_POST['preco'] ?? 0);
            $estoque = intval($_POST['estoque'] ?? 0);
            $marca = trim($_POST['marca'] ?? '');
            $imagem = $_POST['imagem'] ?? null;
            
            if ($id <= 0 || empty($nome) || $preco <= 0 || $estoque < 0) {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'Dados inválidos. Verifique os campos obrigatórios.'
                ]);
            } else {
                $resultado = $controller->editarProduto($id, $nome, $preco, $estoque, $marca, $imagem);
                echo json_encode($resultado);
            }
            break;
            
        case 'remover_produto':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $id = intval($_POST['id'] ?? 0);
            if ($id <= 0) {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'ID do produto inválido'
                ]);
            } else {
                $resultado = $controller->removerProduto($id);
                echo json_encode($resultado);
            }
            break;
            
        case 'remover_usuario':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $cpf = trim($_POST['cpf'] ?? '');
            if (empty($cpf)) {
                echo json_encode([
                    'sucesso' => false,
                    'mensagem' => 'CPF inválido'
                ]);
            } else {
                $resultado = $controller->removerUsuario($cpf);
                echo json_encode($resultado);
            }
            break;
            
        default:
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Ação não reconhecida'
            ]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $acao = $_GET['acao'] ?? '';
    
    switch ($acao) {
        case 'verificar_sessao':
            $resultado = $controller->verificarSessao();
            echo json_encode($resultado);
            break;
            
        case 'listar_produtos':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $limite = isset($_GET['limite']) ? intval($_GET['limite']) : null;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : null;
            
            $resultado = $controller->listarProdutos($limite, $offset);
            echo json_encode($resultado);
            break;
            
        case 'listar_usuarios':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $resultado = $controller->listarUsuarios();
            echo json_encode($resultado);
            break;
            
        case 'estatisticas':
            $verificacao = $controller->verificarSessao();
            if (!$verificacao['sucesso']) {
                echo json_encode($verificacao);
                break;
            }
            
            $resultado = $controller->obterEstatisticas();
            echo json_encode($resultado);
            break;
            
        default:
            echo json_encode([
                'sucesso' => false,
                'mensagem' => 'Ação não reconhecida'
            ]);
    }
} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Método não permitido'
    ]);
}
?>
