/*
====================================================================
🎮 LÓGICA JAVASCRIPT DO DASHBOARD ADMINISTRATIVO
====================================================================

🎯 PROPÓSITO:
Gerencia toda a interação do usuário com o dashboard admin.
Controla navegação, formulários, CRUD e comunicação com o backend.

🔧 FUNCIONALIDADES PRINCIPAIS:

📱 NAVEGAÇÃO E INTERFACE:
✅ Controle de seções (dashboard, produtos, usuários)
✅ Sidebar responsiva
✅ Modais para formulários
✅ Sistema de alertas visuais

📦 CRUD DE PRODUTOS:
✅ Carregar lista: carregarProdutos() - Linha ~100
✅ Adicionar novo: salvarProduto() - Linha ~230
✅ Editar existente: editarProduto() - Linha ~320
✅ Remover: removerProduto() - Linha ~380

👥 CRUD DE USUÁRIOS:
✅ Carregar lista: carregarUsuarios() - Linha ~450
✅ Remover: removerUsuario() - Linha ~500

🖼️ UPLOAD DE IMAGENS:
✅ Seleção e preview: handleImageUpload() - Linha ~520
✅ Envio para servidor: uploadImageToServer() - Linha ~550

📊 DASHBOARD:
✅ Carregar estatísticas: carregarEstatisticas() - Linha ~70
✅ Verificar sessão: verificarSessaoAdmin() - Linha ~25

🔄 COMUNICAÇÃO API:
- Todas as funções usam fetch() para requisições AJAX
- Retorno em JSON padronizado
- Tratamento de erros consistente

🎨 INTERFACE:
- Bootstrap 5 para responsividade
- Modais para formulários
- Alertas com cores da paleta do site
- Animações suaves

🔒 SEGURANÇA:
- Verificação de sessão em todas as operações
- Validação de dados no frontend
- Redirecionamento automático se não logado
====================================================================
*/

// ===== VARIÁVEIS GLOBAIS =====
let currentSection = 'dashboard';
let produtos = [];
let usuarios = [];

// ===== INICIALIZAÇÃO =====
document.addEventListener('DOMContentLoaded', function() {
    // Verificar sessão admin
    verificarSessaoAdmin();
    
    // Carregar dados iniciais
    carregarEstatisticas();
    
    // Configurar event listeners
    configurarEventListeners();
    
    // Mostrar seção inicial
    mostrarSecao('dashboard');
});

// ===== VERIFICAÇÃO DE SESSÃO =====
async function verificarSessaoAdmin() {
    try {
        const response = await fetch('../APP/controller/AdminController.php?acao=verificar_sessao');
        const data = await response.json();
        
        if (!data.sucesso) {
            window.location.href = 'login-admin.php';
        }
    } catch (error) {
        console.error('Erro ao verificar sessão:', error);
        window.location.href = 'login-admin.php';
    }
}

// ===== EVENT LISTENERS =====
function configurarEventListeners() {
    // Navegação sidebar
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const section = this.getAttribute('data-section');
            mostrarSecao(section);
        });
    });
    
    // Quick actions
    document.querySelectorAll('.btn-quick-action').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = this.getAttribute('data-section');
            mostrarSecao(section);
        });
    });
    
    // Form produto
    document.getElementById('produto-form').addEventListener('submit', salvarProduto);
    
    // Upload de imagem
    document.getElementById('produto-imagem').addEventListener('change', handleImageUpload);
}

// ===== NAVEGAÇÃO =====
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
}

function mostrarSecao(sectionName) {
    // Atualizar navegação ativa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    document.querySelector(`[data-section="${sectionName}"]`).classList.add('active');
    
    // Esconder todas as seções
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Mostrar seção selecionada
    document.getElementById(`${sectionName}-section`).classList.add('active');
    
    // Atualizar título da página
    const titles = {
        'dashboard': 'Dashboard',
        'produtos': 'Produtos',
        'usuarios': 'Usuários',
        'pedidos': 'Pedidos',
        'configuracoes': 'Configurações'
    };
    document.querySelector('.page-title').textContent = titles[sectionName];
    
    // Carregar dados específicos da seção
    currentSection = sectionName;
    switch(sectionName) {
        case 'produtos':
            carregarProdutos();
            break;
        case 'usuarios':
            carregarUsuarios();
            break;
        case 'dashboard':
            carregarEstatisticas();
            break;
    }
}

// ============================================================================
// 📊 DASHBOARD - ESTATÍSTICAS E VISÃO GERAL
// ============================================================================

/**
 * 📈 CARREGAR ESTATÍSTICAS DO DASHBOARD
 * Busca dados gerais do sistema para exibir nos cards do dashboard
 * Atualiza: total de produtos, usuários, vendas, etc.
 */
async function carregarEstatisticas() {
    try {
        const response = await fetch('../APP/controller/AdminController.php?acao=estatisticas');
        const data = await response.json();
        
        if (data.sucesso) {
            const stats = data.estatisticas;
            document.getElementById('total-produtos').textContent = stats.total_produtos;
            document.getElementById('total-usuarios').textContent = stats.total_usuarios;
            document.getElementById('total-pedidos').textContent = stats.total_pedidos;
            document.getElementById('produtos-baixo-estoque').textContent = stats.produtos_baixo_estoque;
        }
    } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
    }
}

// ===== GERENCIAMENTO DE PRODUTOS =====
// ============================================================================
// 📦 CRUD DE PRODUTOS
// ============================================================================

/**
 * 📋 READ - CARREGAR LISTA DE PRODUTOS
 * Busca todos os produtos do banco e exibe na tabela
 * Inclui botões de ação (editar/deletar) para cada item
 */
async function carregarProdutos() {
    try {
        const response = await fetch('../APP/controller/AdminController.php?acao=listar_produtos');
        const data = await response.json();
        
        if (data.sucesso) {
            produtos = data.produtos;
            renderizarTabelaProdutos();
        } else {
            mostrarAlerta('erro', 'Erro ao carregar produtos: ' + data.mensagem);
        }
    } catch (error) {
        console.error('Erro ao carregar produtos:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

function renderizarTabelaProdutos() {
    const tbody = document.getElementById('produtos-tbody');
    tbody.innerHTML = '';
    
    produtos.forEach(produto => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${produto.idproduto}</td>
            <td>
                <div class="d-flex align-items-center">
                    ${produto.imagem ? 
                        `<img src="../musicwave/${produto.imagem}" alt="${produto.nome}" 
                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; margin-right: 10px;">` : 
                        '<div class="bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 5px; margin-right: 10px;"><i class="bi bi-image text-muted"></i></div>'
                    }
                    <span>${produto.nome}</span>
                </div>
            </td>
            <td>R$ ${parseFloat(produto.preco).toFixed(2)}</td>
            <td>
                <span class="badge ${produto.estoque < 10 ? 'badge-danger' : produto.estoque < 20 ? 'badge-warning' : 'badge-success'}">
                    ${produto.estoque}
                </span>
            </td>
            <td>${produto.marca || '-'}</td>
            <td>
                <button class="btn btn-outline-primary btn-sm me-2" onclick="editarProduto(${produto.idproduto})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm" onclick="removerProduto(${produto.idproduto}, '${produto.nome}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function mostrarModalProduto(produto = null) {
    const modal = new bootstrap.Modal(document.getElementById('produtoModal'));
    const form = document.getElementById('produto-form');
    const title = document.getElementById('produtoModalTitle');
    
    // Limpar preview anterior
    removerPreview();
    
    if (produto) {
        // Editar produto
        title.textContent = 'Editar Produto';
        document.getElementById('produto-id').value = produto.idproduto;
        document.getElementById('produto-nome').value = produto.nome;
        document.getElementById('produto-marca').value = produto.marca || '';
        document.getElementById('produto-preco').value = produto.preco;
        document.getElementById('produto-estoque').value = produto.estoque;
        document.getElementById('produto-imagem-url').value = produto.imagem || '';
        
        // Mostrar imagem existente se houver
        if (produto.imagem) {
            document.getElementById('preview-img').src = `../musicwave/${produto.imagem}`;
            document.getElementById('image-preview').style.display = 'block';
        }
    } else {
        // Novo produto
        title.textContent = 'Adicionar Produto';
        form.reset();
        document.getElementById('produto-id').value = '';
        document.getElementById('produto-imagem-url').value = '';
    }
    
    modal.show();
}

function editarProduto(id) {
    const produto = produtos.find(p => p.idproduto == id);
    if (produto) {
        mostrarModalProduto(produto);
    }
}

/**
 * ➕ CREATE/UPDATE - SALVAR PRODUTO
 * Processa formulário de produto (novo ou edição)
 * Faz upload de imagem se selecionada
 * Envia dados para o backend via AJAX
 */
async function salvarProduto(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const id = formData.get('id');
    const imageFile = document.getElementById('produto-imagem').files[0];
    const imagemUrl = document.getElementById('produto-imagem-url').value;
    
    try {
        let finalImageUrl = imagemUrl; // URL existente
        
        // Se há uma nova imagem, fazer upload primeiro
        if (imageFile) {
            mostrarAlerta('sucesso', 'Fazendo upload da imagem...');
            
            const uploadResult = await uploadImageToServer(imageFile);
            
            if (uploadResult.sucesso) {
                finalImageUrl = uploadResult.url;
                mostrarAlerta('sucesso', 'Imagem enviada com sucesso!');
            } else {
                mostrarAlerta('erro', 'Erro no upload: ' + uploadResult.mensagem);
                return;
            }
        }
        
        // Criar FormData para salvar produto
        const productData = new FormData();
        productData.append('acao', id ? 'editar_produto' : 'adicionar_produto');
        productData.append('nome', formData.get('nome'));
        productData.append('preco', formData.get('preco'));
        productData.append('estoque', formData.get('estoque'));
        productData.append('marca', formData.get('marca'));
        productData.append('imagem', finalImageUrl);
        
        if (id) {
            productData.append('id', id);
        }
        
        console.log('Salvando produto com dados:', {
            acao: id ? 'editar_produto' : 'adicionar_produto',
            nome: formData.get('nome'),
            preco: formData.get('preco'),
            estoque: formData.get('estoque'),
            marca: formData.get('marca'),
            imagem: finalImageUrl
        });
        
        const response = await fetch('../APP/controller/AdminController.php', {
            method: 'POST',
            body: productData
        });
        
        const data = await response.json();
        console.log('Resposta do salvamento:', data);
        
        if (data.sucesso) {
            mostrarAlerta('sucesso', data.mensagem);
            bootstrap.Modal.getInstance(document.getElementById('produtoModal')).hide();
            carregarProdutos();
            carregarEstatisticas();
            
            // Limpar form
            form.reset();
            removerPreview();
        } else {
            mostrarAlerta('erro', data.mensagem);
        }
    } catch (error) {
        console.error('Erro ao salvar produto:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

async function removerProduto(id, nome) {
    if (!confirm(`Tem certeza que deseja remover o produto "${nome}"?`)) {
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('acao', 'remover_produto');
        formData.append('id', id);
        
        const response = await fetch('../APP/controller/AdminController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.sucesso) {
            mostrarAlerta('sucesso', data.mensagem);
            carregarProdutos();
            carregarEstatisticas();
        } else {
            mostrarAlerta('erro', data.mensagem);
        }
    } catch (error) {
        console.error('Erro ao remover produto:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

// ===== GERENCIAMENTO DE USUÁRIOS =====
async function carregarUsuarios() {
    try {
        const response = await fetch('../APP/controller/AdminController.php?acao=listar_usuarios');
        const data = await response.json();
        
        if (data.sucesso) {
            usuarios = data.usuarios;
            renderizarTabelaUsuarios();
        } else {
            mostrarAlerta('erro', 'Erro ao carregar usuários: ' + data.mensagem);
        }
    } catch (error) {
        console.error('Erro ao carregar usuários:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

function renderizarTabelaUsuarios() {
    const tbody = document.getElementById('usuarios-tbody');
    tbody.innerHTML = '';
    
    usuarios.forEach(usuario => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${usuario.cpf}</td>
            <td>${usuario.nome_completo}</td>
            <td>${usuario.email}</td>
            <td>${usuario.telefone || '-'}</td>
            <td>${formatarData(usuario.data_cadastro)}</td>
            <td>
                <button class="btn btn-outline-danger btn-sm" onclick="removerUsuario('${usuario.cpf}', '${usuario.nome_completo}')">
                    <i class="bi bi-trash"></i> Remover
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

async function removerUsuario(cpf, nome) {
    if (!confirm(`Tem certeza que deseja remover o usuário "${nome}"?`)) {
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('acao', 'remover_usuario');
        formData.append('cpf', cpf);
        
        const response = await fetch('../APP/controller/AdminController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.sucesso) {
            mostrarAlerta('sucesso', data.mensagem);
            carregarUsuarios();
            carregarEstatisticas();
        } else {
            mostrarAlerta('erro', data.mensagem);
        }
    } catch (error) {
        console.error('Erro ao remover usuário:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

// ===== LOGOUT =====
async function realizarLogout() {
    if (!confirm('Tem certeza que deseja sair?')) {
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('acao', 'logout');
        
        const response = await fetch('../APP/controller/AdminController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.sucesso) {
            window.location.href = 'login-admin.php';
        } else {
            mostrarAlerta('erro', 'Erro ao fazer logout');
        }
    } catch (error) {
        console.error('Erro ao fazer logout:', error);
        mostrarAlerta('erro', 'Erro de comunicação com o servidor');
    }
}

// ===== UTILITÁRIOS =====
function mostrarAlerta(tipo, mensagem) {
    // Remover alertas existentes
    const alertasExistentes = document.querySelectorAll('.alert-flutuante');
    alertasExistentes.forEach(alerta => alerta.remove());
    
    // Criar novo alerta
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo === 'sucesso' ? 'success' : 'danger'} alert-flutuante`;
    alerta.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;
    
    const icon = tipo === 'sucesso' ? 'bi-check-circle' : 'bi-exclamation-triangle';
    alerta.innerHTML = `
        <i class="bi ${icon}"></i> ${mensagem}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(alerta);
    
    // Remover automaticamente após 5 segundos
    setTimeout(() => {
        if (alerta.parentElement) {
            alerta.remove();
        }
    }, 5000);
}

function formatarData(dataString) {
    const data = new Date(dataString);
    return data.toLocaleDateString('pt-BR');
}

function formatarMoeda(valor) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(valor);
}

// ===== CSS ANIMATIONS =====
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .alert-flutuante {
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
`;
document.head.appendChild(style);

// ===== UPLOAD DE IMAGENS =====
async function handleImageUpload(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    // Validar arquivo
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        mostrarAlerta('erro', 'Tipo de arquivo não permitido. Use apenas JPG, PNG ou GIF');
        e.target.value = '';
        return;
    }
    
    if (file.size > 5 * 1024 * 1024) { // 5MB
        mostrarAlerta('erro', 'Arquivo muito grande. Máximo permitido: 5MB');
        e.target.value = '';
        return;
    }
    
    // Mostrar preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('image-preview').style.display = 'block';
    };
    reader.readAsDataURL(file);
    
    mostrarAlerta('sucesso', 'Imagem carregada. Clique em "Salvar" para confirmar o upload.');
}

function removerPreview() {
    document.getElementById('produto-imagem').value = '';
    document.getElementById('produto-imagem-url').value = '';
    document.getElementById('image-preview').style.display = 'none';
    document.getElementById('preview-img').src = '';
}

async function uploadImageToServer(file) {
    const formData = new FormData();
    formData.append('acao', 'upload');
    formData.append('imagem', file);
    
    try {
        const response = await fetch('../APP/controller/ImageUploadController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Erro no upload:', error);
        return {
            sucesso: false,
            mensagem: 'Erro de comunicação com o servidor: ' + error.message
        };
    }
}
