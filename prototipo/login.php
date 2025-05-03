<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Simulação de login
    if ($email == "cliente@exemplo.com" && $senha == "123456") {
        echo "<h2>Login realizado com sucesso!</h2>";
    } else {
        echo "<h2>Falha no login. Verifique seu e-mail ou senha.</h2>";
    }
}
?>
