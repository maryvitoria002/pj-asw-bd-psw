<?php
session_start();

// REMOVIDO: Redirecionamento automático para dashboard
// Agora só exibe a tela de login sempre
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
            background: linear-gradient(135deg, #f7bd6d 0%, #d4910a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-login-container {
            background: #fdfaf5;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(212, 145, 10, 0.2);
            padding: 40px;
            max-width: 450px;
            width: 100%;
            border: 2px solid #f7bd6d;
        }
        
        .admin-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .admin-logo i {
            font-size: 4rem;
            color: #f7bd6d;
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
            border: 2px solid #f7bd6d;
            padding: 15px;
            background: #ffffff;
        }
        
        .form-control:focus {
            border-color: #d4910a;
            box-shadow: 0 0 0 0.2rem rgba(247, 189, 109, 0.25);
            background: #fdfaf5;
        }
        
        .btn-admin-login {
            background: linear-gradient(135deg, #f7bd6d 0%, #d4910a 100%);
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            width: 100%;
            color: #ffffff;
        }
        
        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(247, 189, 109, 0.4);
            background: linear-gradient(135deg, #d4910a 0%, #b8800a 100%);
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
            color: #f7bd6d;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-site a:hover {
            text-decoration: underline;
            color: #d4910a;
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
        
        <div style="background: #fff3cd; border: 1px solid #f7bd6d; border-radius: 8px; padding: 15px; margin-top: 20px; text-align: center;">
            <small style="color: #856404;">
                <i class="bi bi-info-circle"></i> <strong>Credenciais de teste:</strong><br>
                Usuário: <code>admin</code> | Senha: <code>123456</code>
            </small>
        </div>
        
        <div class="back-to-site">
            <a href="#" onclick="voltarAoSite()">
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
        
        // Função para voltar ao site com logout automático
        async function voltarAoSite() {
            try {
                // Tentar fazer logout se estiver logado
                await fetch('../APP/controller/AdminController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'acao=logout',
                    keepalive: true
                });
            } catch (error) {
                console.log('Logout automático falhou, mas continuando...');
            }
            
            // Redirecionar para o site
            window.location.href = '../musicwave/index.php';
        }
    </script>
</body>
</html>
