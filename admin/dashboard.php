<?php
/*
====================================================================
📋 DASHBOARD ADMINISTRATIVO - INTERFACE PRINCIPAL
====================================================================

🎯 PROPÓSITO:
Interface completa para administração do sistema MusicWave.
Permite gerenciar produtos, usuários e visualizar estatísticas.

🔧 FUNCIONALIDADES PRINCIPAIS:
✅ Dashboard com estatísticas gerais
✅ CRUD completo de Produtos (Criar, Ler, Editar, Deletar)
✅ CRUD completo de Usuários (Criar, Ler, Editar, Deletar)
✅ Upload de imagens para produtos
✅ Interface responsiva com Bootstrap 5
✅ Modais para formulários
✅ Sistema de alertas visuais

📦 SEÇÕES DISPONÍVEIS:
- Dashboard: Visão geral e estatísticas
- Produtos: Gerenciamento do catálogo
- Usuários: Gerenciamento de clientes

🎨 DESIGN:
- Paleta de cores dourada (#f7bd6d, #fdfaf5)
- Sidebar responsiva
- Modais para formulários
- Tabelas com paginação

🔒 SEGURANÇA:
- Verificação de sessão admin
- Proteção contra acesso não autorizado

📁 ARQUIVOS RELACIONADOS:
- admin-script.js: Lógica JavaScript
- admin-styles.css: Estilos personalizados
- AdminController.php: Backend CRUD
- ImageUploadController.php: Upload de imagens
====================================================================
*/

session_start();

// Verificar se está logado como admin
if (!isset($_SESSION['admin_logado']) || !$_SESSION['admin_logado']) {
    header('Location: login-admin.php');
    exit;
}

// Definir nível padrão se não existir
if (!isset($_SESSION['admin_nivel'])) {
    $_SESSION['admin_nivel'] = 'administrador';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - MusicWave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="admin-styles.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="bi bi-music-note-beamed"></i> MusicWave</h4>
            <span class="sidebar-subtitle">Painel Administrativo</span>
        </div>
        
        <div class="admin-info">
            <div class="admin-avatar">
                <i class="bi bi-person-circle"></i>
            </div>
            <div class="admin-details">
                <div class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_nome']); ?></div>
                <div class="admin-role"><?php echo ucfirst($_SESSION['admin_nivel']); ?></div>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="#" class="nav-link active" data-section="dashboard">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="#" class="nav-link" data-section="produtos">
                <i class="bi bi-box"></i> Produtos
            </a>
            <a href="#" class="nav-link" data-section="usuarios">
                <i class="bi bi-people"></i> Usuários
            </a>
            <a href="#" class="nav-link" data-section="pedidos">
                <i class="bi bi-cart"></i> Pedidos
            </a>
            <a href="#" class="nav-link" data-section="configuracoes">
                <i class="bi bi-gear"></i> Configurações
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="#" class="logout-btn" onclick="realizarLogout()">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">Dashboard</h1>
            <div class="header-actions">
                <span class="welcome-text">Bem-vindo, <?php echo htmlspecialchars($_SESSION['admin_nome']); ?></span>
            </div>
        </header>
        
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="content-section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-box"></i>
                    </div>
                    <div class="stat-details">
                        <h3 id="total-produtos">-</h3>
                        <p>Total de Produtos</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-details">
                        <h3 id="total-usuarios">-</h3>
                        <p>Usuários Cadastrados</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-cart"></i>
                    </div>
                    <div class="stat-details">
                        <h3 id="total-pedidos">-</h3>
                        <p>Pedidos Realizados</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stat-details">
                        <h3 id="produtos-baixo-estoque">-</h3>
                        <p>Produtos com Baixo Estoque</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-graph-up"></i> Ações Rápidas</h5>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions">
                                <button class="btn btn-primary btn-quick-action" data-section="produtos">
                                    <i class="bi bi-plus-circle"></i> Adicionar Produto
                                </button>
                                <button class="btn btn-success btn-quick-action" data-section="usuarios">
                                    <i class="bi bi-person-plus"></i> Ver Usuários
                                </button>
                                <button class="btn btn-warning btn-quick-action" data-section="pedidos">
                                    <i class="bi bi-cart-check"></i> Verificar Pedidos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-clock-history"></i> Atividade Recente</h5>
                        </div>
                        <div class="card-body">
                            <div class="activity-feed">
                                <div class="activity-item">
                                    <i class="bi bi-person-plus text-success"></i>
                                    <span>Sistema iniciado com sucesso</span>
                                    <small class="text-muted">Agora</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Produtos Section -->
        <section id="produtos-section" class="content-section">
            <div class="section-header">
                <h2><i class="bi bi-box"></i> Gerenciamento de Produtos</h2>
                <button class="btn btn-primary" onclick="mostrarModalProduto()">
                    <i class="bi bi-plus-circle"></i> Adicionar Produto
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Marca</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="produtos-tbody">
                        <!-- Produtos carregados via JavaScript -->
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Usuários Section -->
        <section id="usuarios-section" class="content-section">
            <div class="section-header">
                <h2><i class="bi bi-people"></i> Gerenciamento de Usuários</h2>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>CPF</th>
                            <th>Nome Completo</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="usuarios-tbody">
                        <!-- Usuários carregados via JavaScript -->
                    </tbody>
                </table>
            </div>
        </section>
        
        <!-- Pedidos Section -->
        <section id="pedidos-section" class="content-section">
            <div class="section-header">
                <h2><i class="bi bi-cart"></i> Gerenciamento de Pedidos</h2>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Funcionalidade em desenvolvimento
            </div>
        </section>
        
        <!-- Configurações Section -->
        <section id="configuracoes-section" class="content-section">
            <div class="section-header">
                <h2><i class="bi bi-gear"></i> Configurações</h2>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5>Informações da Conta</h5>
                    <p><strong>Usuário:</strong> <?php echo htmlspecialchars($_SESSION['admin_usuario']); ?></p>
                    <p><strong>Nome:</strong> <?php echo htmlspecialchars($_SESSION['admin_nome']); ?></p>
                    <p><strong>Nível:</strong> <?php echo ucfirst($_SESSION['admin_nivel']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['admin_email']); ?></p>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Modal Produto -->
    <div class="modal fade" id="produtoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produtoModalTitle">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="produto-form">
                    <div class="modal-body">
                        <input type="hidden" id="produto-id" name="id">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="produto-nome" class="form-label">Nome do Produto</label>
                                    <input type="text" class="form-control" id="produto-nome" name="nome" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="produto-marca" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="produto-marca" name="marca">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="produto-preco" class="form-label">Preço (R$)</label>
                                    <input type="number" class="form-control" id="produto-preco" name="preco" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="produto-estoque" class="form-label">Estoque</label>
                                    <input type="number" class="form-control" id="produto-estoque" name="estoque" min="0" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="produto-imagem" class="form-label">Imagem do Produto</label>
                            <input type="file" class="form-control" id="produto-imagem" name="imagem" accept="image/*">
                            <div class="form-text">Formatos aceitos: JPG, PNG, GIF (máximo 5MB)</div>
                            
                            <!-- Preview da imagem -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <label class="form-label">Preview:</label>
                                <div class="image-preview-container">
                                    <img id="preview-img" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removerPreview()">
                                        <i class="bi bi-trash"></i> Remover Imagem
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Campo hidden para manter URL existente -->
                            <input type="hidden" id="produto-imagem-url" name="imagem_url">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin-script.js"></script>
    
    <script>
        // Função para logout administrativo
        async function realizarLogout() {
            if (confirm('Tem certeza que deseja sair do painel administrativo?')) {
                try {
                    const response = await fetch('../APP/controller/AdminController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'acao=logout'
                    });
                    
                    const data = await response.json();
                    
                    if (data.sucesso) {
                        alert('Logout realizado com sucesso!');
                        window.location.href = 'login-admin.php';
                    } else {
                        alert('Erro ao fazer logout: ' + data.mensagem);
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    // Forçar logout mesmo se der erro
                    window.location.href = 'login-admin.php';
                }
            }
        }
        
        // Logout automático quando fechar aba/navegador
        window.addEventListener('beforeunload', function() {
            fetch('../APP/controller/AdminController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'acao=logout',
                keepalive: true
            });
        });
        
        // Logout automático quando sair da página
        window.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                fetch('../APP/controller/AdminController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'acao=logout',
                    keepalive: true
                });
            }
        });
    </script>
</body>
</html>
