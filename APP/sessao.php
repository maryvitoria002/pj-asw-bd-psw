<?php
session_start();

function usuarioLogado() {
    return isset($_SESSION['usuario_logado']);
}

function dadosUsuario() {
    if (!usuarioLogado()) {
        return null;
    }
    
    return [
        'cpf' => $_SESSION['usuario_id'] ?? '',
        'nome' => $_SESSION['usuario_nome'] ?? '',
        'email' => $_SESSION['usuario_email'] ?? ''
    ];
}

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

function logout() {
    session_unset();
    session_destroy();
}

function saudacaoUsuario() {
    $dados = dadosUsuario();
    if (!$dados) {
        return 'Visitante';
    }
    
    $nome_parts = explode(' ', $dados['nome']);
    return $nome_parts[0];
}

