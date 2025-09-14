<?php
session_start();

// Se já estiver logado como admin, redireciona para o dashboard
if (isset($_SESSION['admin_logado'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - MusicWave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        
        .admin-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .admin-logo i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .admin-title {
            color: #333;
            font-weight: 700;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control {
            border-radius: 12px;
            border: 2px solid #e1e5e9;
            padding: 15px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-admin-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .back-to-site {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-site a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-site a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-logo">
            <i class="bi bi-shield-lock"></i>
            <h2 class="admin-title">Painel Administrativo</h2>
            <p class="text-muted">MusicWave</p>
        </div>
        
        <div id="message-container"></div>
        
        <form id="admin-login-form">
            <div class="form-floating">
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required>
                <label for="usuario"><i class="bi bi-person"></i> Usuário</label>
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                <label for="senha"><i class="bi bi-lock"></i> Senha</label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-admin-login">
                <i class="bi bi-box-arrow-in-right"></i> Entrar no Sistema
            </button>
        </form>
        
        <div class="back-to-site">
            <a href="../musicwave/index.php">
                <i class="bi bi-arrow-left"></i> Voltar ao site
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('admin-login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const messageContainer = document.getElementById('message-container');
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Mostrar loading
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Verificando...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(this);
                formData.append('acao', 'login');
                
                const response = await fetch('../APP/controller/AdminController.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.sucesso) {
                    messageContainer.innerHTML = `
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Login realizado com sucesso! Redirecionando...
                        </div>
                    `;
                    
                    setTimeout(() => {
                        window.location.href = 'dashboard.php';
                    }, 1500);
                } else {
                    messageContainer.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> ${data.mensagem}
                        </div>
                    `;
                }
            } catch (error) {
                messageContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-wifi-off"></i> Erro de comunicação com o servidor
                    </div>
                `;
            }
            
            // Restaurar botão
            submitBtn.innerHTML = '<i class="bi bi-box-arrow-in-right"></i> Entrar no Sistema';
            submitBtn.disabled = false;
        });
    </script>
</body>
</html>
