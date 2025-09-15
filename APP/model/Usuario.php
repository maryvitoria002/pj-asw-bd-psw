<?php

require_once __DIR__ . '/../BD/Conexao.php';

class Usuario {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Conexao::getInstancia();
    }

    // Cadastra um novo usuário no banco de dados
    public function cadastrar($dados) {
        try {
            // Verificar se o CPF já existe
            if ($this->cpfExiste($dados['cpf'])) {
                return ['sucesso' => false, 'mensagem' => 'CPF já cadastrado no sistema.'];
            }
            
            // Verificar se o email já existe
            if ($this->emailExiste($dados['email'])) {
                return ['sucesso' => false, 'mensagem' => 'Email já cadastrado no sistema.'];
            }
            
            // Validar CPF
            if (!$this->validarCpf($dados['cpf'])) {
                return ['sucesso' => false, 'mensagem' => 'CPF inválido.'];
            }
            
            // Senha sem criptografia
            $sql = "INSERT INTO ClienteUsuario (cpf, nome_completo, rg, email, senha, telefone, data_cadastro) 
                    VALUES (:cpf, :nome_completo, :rg, :email, :senha, :telefone, CURDATE())";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cpf', $dados['cpf']);
            $stmt->bindParam(':nome_completo', $dados['nome_completo']);
            $stmt->bindParam(':rg', $dados['rg']);
            $stmt->bindParam(':email', $dados['email']);
            $stmt->bindParam(':senha', $dados['senha']); // Senha em texto puro
            $stmt->bindParam(':telefone', $dados['telefone']);
            
            if ($stmt->execute()) {
                // Criar carrinho para o novo usuário
                $this->criarCarrinho($dados['cpf']);
                return ['sucesso' => true, 'mensagem' => 'Usuário cadastrado com sucesso!'];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Erro ao cadastrar usuário.'];
            }
            
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()];
        }
    }
    
    // Autentica um usuário
    public function autenticar($email, $senha) {
        try {
            $sql = "SELECT cpf, nome_completo, email, senha FROM ClienteUsuario WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $usuario = $stmt->fetch();
            
            if ($usuario && $senha === $usuario['senha']) {
                // Remove a senha do array retornado
                unset($usuario['senha']);
                return ['sucesso' => true, 'usuario' => $usuario];
            } else {
                return ['sucesso' => false, 'mensagem' => 'Email ou senha incorretos.'];
            }
            
        } catch (PDOException $e) {
            return ['sucesso' => false, 'mensagem' => 'Erro no banco de dados: ' . $e->getMessage()];
        }
    }
    
    /**
     * Busca um usuário pelo CPF
     * @param string $cpf
     * @return array|null Dados do usuário ou null se não encontrado
     */
    public function buscarPorCpf($cpf) {
        try {
            $sql = "SELECT cpf, nome_completo, rg, email, telefone, data_cadastro FROM ClienteUsuario WHERE cpf = :cpf";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->execute();
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Busca um usuário pelo email
     * @param string $email
     * @return array|null Dados do usuário ou null se não encontrado
     */
    public function buscarPorEmail($email) {
        try {
            $sql = "SELECT cpf, nome_completo, rg, email, telefone, data_cadastro FROM ClienteUsuario WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Verifica se um CPF já existe no banco
     * @param string $cpf
     * @return bool
     */
    private function cpfExiste($cpf) {
        $sql = "SELECT COUNT(*) FROM ClienteUsuario WHERE cpf = :cpf";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Verifica se um email já existe no banco
     * @param string $email
     * @return bool
     */
    private function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM ClienteUsuario WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Valida um CPF
     * @param string $cpf
     * @return bool
     */
    private function validarCpf($cpf) {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        // Calcula os dígitos verificadores
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
    
    /**
     * Cria um carrinho para o usuário
     * @param string $cpf
     * @return bool
     */
    private function criarCarrinho($cpf) {
        try {
            $sql = "INSERT INTO Carrinho (cliente_cpf) VALUES (:cpf)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cpf', $cpf);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
