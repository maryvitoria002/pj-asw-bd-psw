<?php
require_once '../APP/sessao.php';
$usuario_logado = usuarioLogado();
$dados_usuario = dadosUsuario();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="img/mw..png" type="image/x-icon">
    <title>Catálogo</title>
</head>
<body>

     <!-- cabeçalho -->
  <header>
    <div class="logo-img">
      <img src="img/logomw.png" alt="logo">
    </div>
    <div class="search-container"> <input type="text" id="search-input" placeholder="Navegue..." autocomplete="off" />
            <div id="search-suggestions" class="search-suggestions"></div> </div>
  <button class="bubbles" onclick="pedirCep()">     
  <span class="text" id="cep-texto">Informe seu CEP</span>
</button>
      <button class="bubbles">
  <span class="text"><a href="loja.php">Loja</a></span>
</button>
<button class="bubbles" onclick="alert('TESTE CARRINHO!'); toggleCarrinho();">
    <span class="text">Carrinho (<span id="cart-count">0</span>)</span>
</button>
     
      <button id="btn-afinador" class="bubbles" onclick="abrirAfinador()">
  <span class="text">Afinador</span>
</button>
  </header>
  <!-- cabeçalho -->

     <!-- sidebar -->

   <aside id="sidebar">
        <a href="perfil.php"><i class="bi bi-person-circle" style="color: black; font-size: 30px"></i></a>
        <a href="index.php"><i class="bi bi-house-door" style="color: black;font-size: 30px"></i></a>
        <a href="#notificacoes"><i class="bi bi-bell" style="color: black; font-size: 30px"></i></a>
        <?php if ($usuario_logado): ?>
        <a href="#" onclick="logout()" title="Sair"><i class="bi bi-box-arrow-right" style="color: #d63384; font-size: 30px"></i></a>
        <?php endif; ?>
        <a id="dark-toggle-wrapper" title="Ativar/Desativar modo escuro">
            <label class="container" id="dark-toggle">
                <input type="checkbox" id="darkModeSwitch">
                <svg viewBox="0 0 384 512" class="moon">
                    <path d="M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"></path>
                </svg>
                <svg viewBox="0 0 512 512" class="sun">
                    <path d="M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z"></path>
                </svg>
            </label>
        </a>
    </aside>

   <!-- sidebar -->

<!-- catálogo de instrumentos -->

    <main>
        <section class="store-section">
            <div class="small-container-instrumentos">
                <h2 class="categoria-titulo" id="current-category-title">Instrumentos</h2>

                <div class="filter-pagination-container">
                    <div class="filter-container">
                        <label for="category-filter">Filtrar por Categoria:</label>
                        <select id="category-filter"></select>
                    </div>
                    </div>
                    

                <div class="row-instrumentos-" id="product-list">
                    </div>
            </div>
        </section>
    </main>

    <!-- catálogo de instrumentos -->

    <!-- carrinho -->

    <div id="carrinhoLateral" class="carrinho-lateral">
        <div class="carrinho-header">
            <h2>Seu Carrinho</h2>
            <button class="carrinho-fechar" onclick="toggleCarrinho()">✖</button>
        </div>
        <ul class="carrinho-body" id="carrinho-items">
            </ul>
        <div class="carrinho-total">
            <p>Total: <span id="carrinho-total-valor">R$0,00</span></p>
        </div>
        <div class="carrinho-acoes">
            <button class="btn-finalizar" onclick="finalizarCompraPix()">Finalizar Compra com PIX</button>
            <button class="btn-limpar" onclick="clearCart()">Limpar Carrinho</button>
        </div>
    </div>

       <!-- carrinho -->

       <!-- modal dos produtos -->

    <div id="modalDetalhesProduto" class="modal-detalhes-produto">
        <div class="modal-conteudo">
            <span class="modal-fechar" onclick="fecharModalDetalhes()">&times;</span>
            <div class="modal-imagem-container">
                <img id="modal-imagem-principal" class="modal-imagem-principal" src="" alt="Imagem do Produto">
                <div id="modal-thumbnails" class="modal-thumbnails">
                    </div>
            </div>
            <div class="modal-detalhes-info">
                <h3 id="modal-titulo"></h3>
                <p id="modal-preco" class="modal-preco"></p>
                <p id="modal-descricao" class="modal-descricao"></p>
                <button class="add-to-cart-btn" onclick="addItemToCartFromModal()">Adicionar ao Carrinho</button>
            </div>
        </div>
    </div>

    <div id="modalPixPagamento" class="modal-pix-pagamento">
        <div class="modal-pix-conteudo">
            <span class="modal-fechar" onclick="fecharModalPix()">&times;</span>
            <h3>Pagamento via PIX</h3>
            <p>Escaneie o QR Code ou use a chave PIX abaixo para finalizar seu pedido.</p>
            <div class="pix-qr-code">
                <img id="pix-qr-code-img" src="" alt="QR Code PIX">
            </div>
            <p>Total a pagar: <strong id="pix-total-valor">R$0,00</strong></p>
            <p>Chave PIX (E-mail): <strong id="pix-key-value">lojamusicwave.pagamento@email.com</strong></p>
            <p style="font-size: 0.9em; margin-top: 20px; color: #888;">Após o pagamento, seu pedido será automaticamente processado. Não é necessário enviar comprovante.</p>
        </div>
    </div>

      <!-- modal dos produtos -->

 <!-- afinador lateral -->
<div id="afinadorLateral" class="painel-lateral">
  <button onclick="fecharAfinador()">✖</button>
  <h2 style="text-align:center; color:#b45f06;">Afinador</h2>
  <select id="instrumento" onchange="carregarCordas()">
    <option value="baixo">Baixo</option>
     <option value="bandolim">Bandolim</option>
      <option value="banjo"> Banjo</option>
       <option value="cavaquinho">Cavaquinho</option>
        <option value="guitarra">Guitarra</option>
         <option value="ukulele">Ukulelê</option>
          <option value="viola_caipira">Viola Caipira</option>
           <option value="viola_arco">Viola de Arco</option>
            <option value="violao">Violão</option>
             <option value="violino">Violino</option>
              <option value="violoncelo">Violoncelo</option>
  </select>
  <div id="cordas-lista"></div>
  <div id="afinacao-visual"></div>
  <div style="margin-top: 20px;">
    <p>Frequência detectada: <span id="frequencia-atual">-- Hz</span></p>
    <div id="indicador-visual" style="height: 20px; background: #ddd; margin: 10px 0; border-radius: 10px;">
      <div id="barra-afinacao" style="height: 100%; width: 0%; background: #f7bd6d; border-radius: 10px; transition: all 0.3s;"></div>
    </div>
  </div>
</div>
    <!-- afinador lateral -->

   <footer>
        <div class="footer-list">
            <ul>
                <li class="footer-list_header">Música</li>
                <li><a href="#">Mais vendidos</a></li>
                <li><a href="#">Promoções</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Destaques</a></li>
            </ul>

            <ul>
                <li class="footer-list_header">Documentos</li>
                <li><a href="#">Sobre</a></li>
                <li><a href="#">Políticas de Privacidade</a></li>
                <li><a href="#">Termos de Serviço</a></li>
                <li><a href="#">Cookies</a></li>
            </ul>


            <ul>
                <li class="footer-list_header">Para você</li>
                <li><a href="#">Manuais</a></li>
                <li><a href="#">Tutoriais</a></li>
                <li><a href="#">Dicas e Truques</a></li>
                <li><a href="#">F&Q</a></li>
            </ul>


            <ul>
                <li class="footer-list_header">Trabalhe conosco</li>
                <li><a href="#">Afiliar</a></li>
                <li><a href="#">Colaborações</a></li>
                <li><a href="#">Patrocinadores</a></li>
                <li><a href="#">Parcerias</a></li>
            </ul>
        </div>
        <p>Copyright &copy; 2025 MusicWave. Todos os direitos reservados. </p>
    </footer>

<script src="script.js"></script>

<script>
    console.log("🚀 SCRIPT INICIADO!");
    /*
    ====================================================================
    🛒 SISTEMA DE LOJA DINÂMICO - CARREGA PRODUTOS DO BANCO
    ====================================================================
    
    🎯 FUNCIONALIDADES:
    ✅ Carrega produtos do banco de dados via API
    ✅ Mantém 4 imagens por produto (principal + 3 thumbnails)
    ✅ Sistema de carrinho e modal
    ✅ Filtros por categoria
    ✅ Busca de produtos
    ✅ Responsivo e otimizado
    ====================================================================
    */

    // ===== VARIÁVEIS GLOBAIS =====
    let products = []; // Será carregado do banco via API
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let currentPage = 1;
    const productsPerPage = 8;
    let currentCategory = 'all'; 
    let currentSearchQuery = ''; 

    // ===== ELEMENTOS DOM =====
    const searchInput = document.getElementById('search-input');
    const searchSuggestions = document.getElementById('search-suggestions');
    const productListDiv = document.getElementById('product-list'); 

    // ===== CARREGAR PRODUTOS DO BANCO =====
    async function carregarProdutosDoBanco() {
        try {
            console.log('🔄 Carregando produtos do banco de dados...');
            
            const response = await fetch('api-produtos.php');
            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            products = data;
            console.log(`✅ ${products.length} produtos carregados com sucesso!`);
            
            // Inicializar interface após carregar produtos
            inicializarLoja();
            
        } catch (error) {
            console.error('❌ Erro ao carregar produtos:', error);
            
            // Mostrar mensagem de erro para o usuário
            if (productListDiv) {
                productListDiv.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <h3>❌ Erro ao carregar produtos</h3>
                        <p>Não foi possível conectar ao banco de dados.</p>
                        <p>Erro: ${error.message}</p>
                        <button onclick="carregarProdutosDoBanco()" style="margin-top: 20px; padding: 10px 20px; background: #f7bd6d; border: none; border-radius: 5px; cursor: pointer;">
                            🔄 Tentar Novamente
                        </button>
                    </div>
                `;
            }
        }
    }

    // ===== INICIALIZAR LOJA =====
    function inicializarLoja() {
        // Configurar categorias dinâmicas
        configurarCategorias();
        
        // Renderizar produtos inicial
        renderProducts();
        
        // Configurar busca
        configurarBusca();
        
        // Atualizar contador do carrinho
        updateCartCount();
        
        console.log('🛒 Loja inicializada com sucesso!');
    }

    // ===== CONFIGURAR CATEGORIAS DINÂMICAS =====
    function configurarCategorias() {
        const allCategories = [...new Set(products.map(p => p.category))];
        const categoryFilter = document.getElementById('category-filter');
        
        if (categoryFilter) {
            categoryFilter.innerHTML = '<option value="all">Todas as Categorias</option>';
            
            allCategories.forEach(category => {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category.charAt(0).toUpperCase() + category.slice(1).replace('_', ' ');
                categoryFilter.appendChild(option);
            });
            
            categoryFilter.addEventListener('change', (e) => {
                currentCategory = e.target.value;
                currentPage = 1;
                renderProducts();
            });
        }
    }

    // ===== CONFIGURAR SISTEMA DE BUSCA =====
    function configurarBusca() {
        const searchSuggestionsList = [
            ...new Set(products.map(p => p.category)),
            "baixo", "bandolim", "banjo", "guitarra", "ukulele", 
            "viola", "violão", "violino", "violoncelo", "cavaquinho"
        ].filter(item => item && item.length > 2);

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();
                currentSearchQuery = query;
                currentPage = 1;
                
                if (query.length > 0) {
                    mostrarSugestoes(query, searchSuggestionsList);
                } else {
                    if (searchSuggestions) searchSuggestions.innerHTML = '';
                }
                
                renderProducts();
            });
        }
    }

    // ===== MOSTRAR SUGESTÕES DE BUSCA =====
    function mostrarSugestoes(query, sugestoes) {
        if (!searchSuggestions) return;
        
        const filteredSuggestions = sugestoes
            .filter(s => s.toLowerCase().includes(query))
            .slice(0, 5);
        
        searchSuggestions.innerHTML = filteredSuggestions
            .map(suggestion => `
                <div class="suggestion-item" onclick="selecionarSugestao('${suggestion}')">
                    ${suggestion}
                </div>
            `).join('');
    }

    // ===== SELECIONAR SUGESTÃO =====
    function selecionarSugestao(suggestion) {
        if (searchInput) searchInput.value = suggestion;
        currentSearchQuery = suggestion.toLowerCase();
        if (searchSuggestions) searchSuggestions.innerHTML = '';
        currentPage = 1;
        renderProducts();
    }

    // ===== INICIALIZAR QUANDO A PÁGINA CARREGAR =====
    document.addEventListener('DOMContentLoaded', function() {
        console.log("🚀 Página carregada! Inicializando sistemas...");
        
        // Carregar produtos do banco
        carregarProdutosDoBanco();
        
        // Adicionar evento alternativo ao botão do carrinho
        const botaoCarrinho = document.querySelector('button[onclick="toggleCarrinho()"]');
        if (botaoCarrinho) {
            console.log("✅ Botão do carrinho encontrado!");
            botaoCarrinho.addEventListener('click', function(e) {
                e.preventDefault();
                console.log("🖱️ Clique detectado no botão do carrinho!");
                toggleCarrinho();
            });
        } else {
            console.error("❌ Botão do carrinho não encontrado!");
        }
        
        // Verificar se carrinho lateral existe
        const carrinhoLateral = document.getElementById("carrinhoLateral");
        if (carrinhoLateral) {
            console.log("✅ Elemento carrinhoLateral encontrado!");
        } else {
            console.error("❌ Elemento carrinhoLateral não encontrado!");
        }
    });

    // ===== FILTRAR PRODUTOS =====
    function filterProducts(category, searchQuery) {
        return products.filter(product => {
            const matchesCategory = category === 'all' || product.category === category;
            const matchesSearch = searchQuery === '' || 
                product.title.toLowerCase().includes(searchQuery) ||
                product.category.toLowerCase().includes(searchQuery) ||
                product.description.toLowerCase().includes(searchQuery);
            return matchesCategory && matchesSearch;
        });
    }

    // ===== RENDERIZAR PRODUTOS =====
    function renderProducts() {
        const filteredProducts = filterProducts(currentCategory, currentSearchQuery);
        const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
        const startIndex = (currentPage - 1) * productsPerPage;
        const endIndex = startIndex + productsPerPage;
        const productsToShow = filteredProducts.slice(startIndex, endIndex);

        if (!productListDiv) return;

        if (productsToShow.length === 0) {
            productListDiv.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #666;">
                    <h3>🔍 Nenhum produto encontrado</h3>
                    <p>Tente ajustar os filtros ou termo de busca.</p>
                </div>
            `;
            return;
        }

        productListDiv.innerHTML = productsToShow.map(product => `
            <div class="product-card">
                <div class="product-image-container">
                    <img src="${product.image}" alt="${product.title}" class="product-image">
                </div>
                <div class="product-info">
                    <h3 class="product-title">${product.title}</h3>
                    <p class="product-price">R$ ${product.price.toFixed(2)}</p>
                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Adicionar ao Carrinho</button>
                        <button class="view-details-btn" onclick="openProductModal(${product.id})">Ver Detalhes</button>
                    </div>
                </div>
            </div>
        `).join('');

        // Renderizar paginação
        renderPagination(totalPages);

        // Atualizar título da categoria
        updateCategoryTitle();
    }

    // ===== RENDERIZAR PAGINAÇÃO =====
    function renderPagination(totalPages) {
        if (totalPages <= 1) return;

        let paginationHTML = '<div class="pagination-container"><div class="pagination">';
        
        // Botão anterior
        if (currentPage > 1) {
            paginationHTML += `<button class="pagination-btn" onclick="changePage(${currentPage - 1})">‹ Anterior</button>`;
        }
        
        // Números das páginas
        for (let i = 1; i <= totalPages; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            paginationHTML += `<button class="pagination-btn ${activeClass}" onclick="changePage(${i})">${i}</button>`;
        }
        
        // Botão próximo
        if (currentPage < totalPages) {
            paginationHTML += `<button class="pagination-btn" onclick="changePage(${currentPage + 1})">Próximo ›</button>`;
        }
        
        paginationHTML += '</div></div>';
        productListDiv.insertAdjacentHTML('afterend', paginationHTML);
    }

    // ===== ALTERAR PÁGINA =====
    function changePage(page) {
        currentPage = page;
        renderProducts();
    }

    // ===== ATUALIZAR TÍTULO DA CATEGORIA =====
    function updateCategoryTitle() {
        const titleElement = document.getElementById('current-category-title');
        if (titleElement) {
            if (currentCategory === 'all') {
                titleElement.textContent = 'Todos os Instrumentos';
            } else {
                titleElement.textContent = currentCategory.charAt(0).toUpperCase() + currentCategory.slice(1).replace('_', ' ');
            }
        }
    }

    // ===== ABRIR MODAL DO PRODUTO =====
    function openProductModal(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        // Preencher dados do modal
        document.getElementById('modal-titulo').textContent = product.title;
        document.getElementById('modal-preco').textContent = `R$ ${product.price.toFixed(2)}`;
        document.getElementById('modal-descricao').textContent = product.description;
        document.getElementById('modal-imagem-principal').src = product.image;

        // Configurar thumbnails
        const thumbnailsContainer = document.getElementById('modal-thumbnails');
        thumbnailsContainer.innerHTML = product.thumbnails.map((thumb, index) => 
            `<img src="${thumb}" alt="Thumbnail ${index + 1}" class="thumbnail" onclick="changeMainImage('${thumb}')">`
        ).join('');

        // Armazenar ID do produto para uso no carrinho
        document.getElementById('modalDetalhesProduto').dataset.productId = productId;

        // Mostrar modal
        document.getElementById('modalDetalhesProduto').style.display = 'flex';
    }

    // ===== FECHAR MODAL DE DETALHES =====
    function fecharModalDetalhes() {
        document.getElementById('modalDetalhesProduto').style.display = 'none';
    }

    // ===== TROCAR IMAGEM PRINCIPAL =====
    function changeMainImage(imageSrc) {
        document.getElementById('modal-imagem-principal').src = imageSrc;
    }

    // ===== ADICIONAR ITEM AO CARRINHO DO MODAL =====
    function addItemToCartFromModal() {
        const productId = parseInt(document.getElementById('modalDetalhesProduto').dataset.productId);
        addToCart(productId);
        fecharModalDetalhes();
    }

    // ===== FUNÇÕES DO CARRINHO =====

    // Atualizar contagem do carrinho
    function updateCartCount() {
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        document.getElementById("cart-count").textContent = totalItems;
    }

    // Adicionar ao carrinho
    function addToCart(productId) {
        const product = products.find(p => p.id === productId);
        if (!product) return;

        const existingItem = cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: product.id,
                title: product.title,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        updateCartDisplay();
        
        // Feedback visual
        console.log(`✅ ${product.title} adicionado ao carrinho!`);
    }

    // Atualizar exibição do carrinho
    function updateCartDisplay() {
        console.log("🔄 UpdateCartDisplay chamado!");
        const cartItems = document.getElementById("carrinho-items");
        const cartTotal = document.getElementById("carrinho-total-valor");

        if (!cartItems || !cartTotal) {
            console.error("❌ Elementos do carrinho não encontrados!");
            return;
        }

        console.log("🛒 Itens no carrinho:", cart.length);
        
        if (cart.length === 0) {
            cartItems.innerHTML = '<li style="text-align: center; padding: 20px; color: #666;">Seu carrinho está vazio</li>';
            cartTotal.textContent = "R$0,00";
            return;
        }

        cartItems.innerHTML = cart.map(item => `
            <li class="carrinho-item">
                <img src="${item.image}" alt="${item.title}" class="carrinho-item-img">
                <div class="carrinho-item-info">
                    <h4>${item.title}</h4>
                    <p>R$ ${item.price.toFixed(2)}</p>
                    <div class="quantity-controls">
                        <button onclick="changeQuantity(${item.id}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="changeQuantity(${item.id}, 1)">+</button>
                        <button onclick="removeFromCart(${item.id})" class="remove-btn">🗑️</button>
                    </div>
                </div>
            </li>
        `).join('');

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.textContent = `R$ ${total.toFixed(2)}`;
    }

    // Alterar quantidade
    function changeQuantity(productId, change) {
        const item = cart.find(item => item.id === productId);
        if (!item) return;

        item.quantity += change;
        
        if (item.quantity <= 0) {
            removeFromCart(productId);
        } else {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            updateCartDisplay();
        }
    }

    // Remover do carrinho
    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        updateCartDisplay();
    }

    // Limpar carrinho
    function clearCart() {
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        updateCartDisplay();
    }

    // Toggle carrinho lateral
    function toggleCarrinho() {
        console.log("🛒 Toggle carrinho chamado!");
        const carrinhoLateral = document.getElementById("carrinhoLateral");
        if (carrinhoLateral) {
            console.log("✅ Elemento carrinhoLateral encontrado!");
            console.log("📍 Classes antes:", carrinhoLateral.className);
            carrinhoLateral.classList.toggle("ativo");
            console.log("� Classes depois:", carrinhoLateral.className);
            console.log("�🔄 Classe 'ativo' toggled!");
            
            // Debug: forçar estilo inline para teste
            if (carrinhoLateral.classList.contains("ativo")) {
                carrinhoLateral.style.transform = "translateX(0)";
                console.log("🎯 Carrinho ABERTO com estilo inline");
            } else {
                carrinhoLateral.style.transform = "translateX(100%)";
                console.log("🎯 Carrinho FECHADO com estilo inline");
            }
            
            updateCartDisplay();
        } else {
            console.error("❌ Elemento carrinhoLateral não encontrado!");
        }
    }

    // Finalizar compra PIX
    function finalizarCompraPix() {
        if (cart.length === 0) {
            alert("Seu carrinho está vazio!");
            return;
        }

        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        
        // Configurar modal PIX
        document.getElementById("pix-total-valor").textContent = `R$ ${total.toFixed(2)}`;
        document.getElementById("pix-qr-code-img").src = "img/qr_code.png";
        
        // Mostrar modal PIX
        document.getElementById("modalPixPagamento").style.display = "flex";
        
        // Fechar carrinho lateral
        toggleCarrinho();
    }

    // Fechar modal PIX
    function fecharModalPix() {
        document.getElementById("modalPixPagamento").style.display = "none";
    }

</script>

</body>
</html>