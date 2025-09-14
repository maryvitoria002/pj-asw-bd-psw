<?php

session_start();
require_once __DIR__ . '/../model/Usuario.php';

class UsuarioController {
    private $usuario;
    
    public function __construct() {
        $this->usuario = new Usuario();
    }
    
    /**
     * Processa as requisições baseado no método HTTP e ação
     */
    public function processarRequisicao() {
        $metodo = $_SERVER['REQUEST_METHOD'];
        $acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
        
        header('Content-Type: application/json');
        
        try {
            switch ($acao) {
                case 'cadastrar':
                    if ($metodo === 'POST') {
                        $this->cadastrarUsuario();
                    } else {
                        $this->retornarErro('Método não permitido');
                    }
                    break;
                    
                case 'login':
                    if ($metodo === 'POST') {
                        $this->autenticarUsuario();
                    } else {
                        $this->retornarErro('Método não permitido');
                    }
                    break;
                    
                case 'logout':
                    $this->logout();
                    break;
                    
                case 'verificar_sessao':
                    $this->verificarSessao();
                    break;
                    
                default:
                    $this->retornarErro('Ação não encontrada');
            }
        } catch (Exception $e) {
            $this->retornarErro('Erro interno do servidor: ' . $e->getMessage());
        }
    }
    
    /**
     * Cadastra um novo usuário
     */
    private function cadastrarUsuario() {
        // Validar dados de entrada
        $dados = $this->validarDadosCadastro();
        
        if (!$dados) {
            return;
        }
        
        // Tentar cadastrar
        $resultado = $this->usuario->cadastrar($dados);
        
        if ($resultado['sucesso']) {
            echo json_encode([
                'sucesso' => true,
                'mensagem' => $resultado['mensagem']
            ]);
        } else {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $resultado['mensagem']
            ]);
        }
    }
    
    /**
     * Autentica um usuário
     */
    private function autenticarUsuario() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        
        // Validações básicas
        if (empty($email) || empty($senha)) {
            $this->retornarErro('Email e senha são obrigatórios');
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->retornarErro('Email inválido');
            return;
        }
        
        $resultado = $this->usuario->autenticar($email, $senha);
        
        if ($resultado['sucesso']) {
            // Criar sessão
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_cpf'] = $resultado['usuario']['cpf'];
            $_SESSION['usuario_nome'] = $resultado['usuario']['nome_completo'];
            $_SESSION['usuario_email'] = $resultado['usuario']['email'];
            
            echo json_encode([
                'sucesso' => true,
                'mensagem' => 'Login realizado com sucesso!',
                'usuario' => $resultado['usuario']
            ]);
        } else {
            echo json_encode([
                'sucesso' => false,
                'mensagem' => $resultado['mensagem']
            ]);
        }
    }
    
    /**
     * Faz logout do usuário
     */
    private function logout() {
        session_unset();
        session_destroy();
        
        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'Logout realizado com sucesso!'
        ]);
    }
    
    /**
     * Verifica se o usuário está logado
     */
    private function verificarSessao() {
        if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
            echo json_encode([
                'logado' => true,
                'usuario' => [
                    'cpf' => $_SESSION['usuario_cpf'],
                    'nome' => $_SESSION['usuario_nome'],
                    'email' => $_SESSION['usuario_email']
                ]
            ]);
        } else {
            echo json_encode([
                'logado' => false
            ]);
        }
    }
    
    /**
     * Valida os dados do cadastro
     * @return array|false
     */
    private function validarDadosCadastro() {
        $cpf = $_POST['cpf'] ?? '';
        $nome_completo = $_POST['nome_completo'] ?? '';
        $rg = $_POST['rg'] ?? '';
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmar_senha = $_POST['confirmar_senha'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        
        // Validações
        if (empty($cpf) || empty($nome_completo) || empty($email) || empty($senha)) {
            $this->retornarErro('CPF, nome completo, email e senha são obrigatórios');
            return false;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->retornarErro('Email inválido');
            return false;
        }
        
        if (strlen($senha) < 6) {
            $this->retornarErro('A senha deve ter pelo menos 6 caracteres');
            return false;
        }
        
        if ($senha !== $confirmar_senha) {
            $this->retornarErro('As senhas não coincidem');
            return false;
        }
        
        // Limpar CPF (remover caracteres especiais)
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Limpar telefone (remover caracteres especiais)
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        
        return [
            'cpf' => $cpf,
            'nome_completo' => trim($nome_completo),
            'rg' => trim($rg),
            'email' => trim(strtolower($email)),
            'senha' => $senha,
            'telefone' => $telefone
        ];
    }
    
    /**
     * Retorna erro em formato JSON
     * @param string $mensagem
     */
    private function retornarErro($mensagem) {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => $mensagem
        ]);
    }
}

// Processar requisição se este arquivo for chamado diretamente
if (basename($_SERVER['PHP_SELF']) === 'UsuarioController.php') {
    $controller = new UsuarioController();
    $controller->processarRequisicao();
}
