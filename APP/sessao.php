<?php
session_start();

/**
 * Verifica se o usuário está logado
 * @return bool
 */
function usuarioLogado() {
    return isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true;
}

/**
 * Retorna os dados do usuário logado
 * @return array|null
 */
function dadosUsuario() {
    if (!usuarioLogado()) {
        return null;
    }
    
    return [
        'cpf' => $_SESSION['usuario_cpf'] ?? '',
        'nome' => $_SESSION['usuario_nome'] ?? '',
        'email' => $_SESSION['usuario_email'] ?? ''
    ];
}

/**
 * Redireciona para login se não estiver logado
 * @param string $redirect_url URL para redirecionamento após login
 */
function requererLogin($redirect_url = null) {
    if (!usuarioLogado()) {
        $login_url = 'view/login-usuario.php';
        if ($redirect_url) {
            $login_url .= '?redirect=' . urlencode($redirect_url);
        }
        header('Location: ' . $login_url);
        exit;
    }
}

/**
 * Faz logout do usuário
 */
function logout() {
    session_unset();
    session_destroy();
}

/**
 * Retorna saudação personalizada
 * @return string
 */
function saudacaoUsuario() {
    $dados = dadosUsuario();
    if (!$dados) {
        return 'Visitante';
    }
    
    $nome_parts = explode(' ', $dados['nome']);
    return $nome_parts[0];
}
