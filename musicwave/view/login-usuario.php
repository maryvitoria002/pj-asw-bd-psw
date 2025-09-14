<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link rel="shortcut icon" href="../img/mw..png" type="image/x-icon">
    <title>Login - MusicWave</title>
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #b45f06;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #b45f06;
        }
        
        .btn-login {
            width: 100%;
            background: #b45f06;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-login:hover {
            background: #8a4605;
        }
        
        .btn-login:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .cadastro-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .cadastro-link a {
            color: #b45f06;
            text-decoration: none;
        }
        
        .cadastro-link a:hover {
            text-decoration: underline;
        }
        
        .voltar-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #b45f06;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .voltar-btn:hover {
            background: #8a4605;
            color: white;
            text-decoration: none;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle .toggle-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="voltar-btn">
        <i class="bi bi-arrow-left"></i>
        Voltar
    </a>

    <div class="login-container">
        <div class="login-header">
            <img src="../img/logomw.png" alt="MusicWave" style="height: 60px; margin-bottom: 10px;">
            <h1>Entrar</h1>
            <p>Acesse sua conta MusicWave</p>
        </div>

        <div id="alert" class="alert"></div>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <div class="password-toggle">
                    <input type="password" id="senha" name="senha" required>
                    <button type="button" class="toggle-btn" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                Entrar
            </button>
        </form>

        <div class="cadastro-link">
            <p>Não tem uma conta? <a href="cadastro-usuario.php">Criar conta</a></p>
        </div>
    </div>

    <script>
        // Toggle para mostrar/ocultar senha
        function togglePassword() {
            const passwordInput = document.getElementById('senha');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }

        // Validação e envio do formulário
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('btnLogin');
            const alert = document.getElementById('alert');
            
            // Desabilitar botão e mostrar loading
            btn.disabled = true;
            btn.textContent = 'Entrando...';
            hideAlert();
            
            // Coletar dados do formulário
            const formData = new FormData(this);
            formData.append('acao', 'login');
            
            try {
                const response = await fetch('../../APP/controller/LoginController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.sucesso) {
                    showAlert('Login realizado com sucesso! Redirecionando...', 'success');
                    
                    // Verificar se há URL de redirecionamento
                    const urlParams = new URLSearchParams(window.location.search);
                    const redirectUrl = urlParams.get('redirect');
                    
                    // Redirecionar após 1 segundo
                    setTimeout(() => {
                        if (redirectUrl) {
                            window.location.href = '../' + redirectUrl;
                        } else {
                            window.location.href = '../index.php';
                        }
                    }, 1000);
                } else {
                    showAlert(data.mensagem, 'error');
                }
            } catch (error) {
                console.error('Erro:', error);
                showAlert('Erro de comunicação com o servidor', 'error');
            } finally {
                // Reabilitar botão
                btn.disabled = false;
                btn.textContent = 'Entrar';
            }
        });
        
        function showAlert(message, type) {
            const alert = document.getElementById('alert');
            alert.textContent = message;
            alert.className = `alert alert-${type}`;
            alert.style.display = 'block';
        }
        
        function hideAlert() {
            const alert = document.getElementById('alert');
            alert.style.display = 'none';
        }

        // Verificar se já está logado
        window.addEventListener('load', async function() {
            try {
                const response = await fetch('../../APP/controller/LogoutController.php?acao=verificar_sessao');
                const data = await response.json();
                
                if (data.logado) {
                    showAlert('Você já está logado! Redirecionando...', 'success');
                    setTimeout(() => {
                        window.location.href = '../index.php';
                    }, 1000);
                }
            } catch (error) {
                // Silenciar erro de verificação de sessão
            }
        });
    </script>
</body>
</html>
