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
<button class="bubbles" onclick="toggleCarrinho()">
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
        <option value="guitarra"> Guitarra</option> 
            <option value="ukulele">Ukulele</option>
              <option value="viola"> Viola</option>
                <option value="viola_caipira">Viola Caipira</option>
                     <option value="violino"> Violino</option>  
                        <option value="violao"> Violão</option>
                          <option value="violoncelo">Violoncelo</option>
  </select>
  <p id="descricao"></p>
  <img id="imgInstrumento" class="instrumento-img" src="" alt="Instrumento" style="display:none;" />
  <div class="cordas" id="cordas"></div>
  <button class="btn-todas" onclick="tocarTodasCordas()">Tocar todas as cordas</button>
</div>


  <!-- afinador lateral -->



<script src="script.js"></script>


<script>
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
            const productListDiv = document.getElementById('product-list');
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
            ...new Set(products.map(p => p.title.toLowerCase().split(' ')).flat()),
            "baixo", "bandolim", "banjo", "guitarra", "ukulele", 
            "viola", "violão", "violino", "violoncelo", "cavaquinho"
        ].filter(item => item.length > 2);

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();
                currentSearchQuery = query;
                currentPage = 1;
                
                if (query.length > 0) {
                    mostrarSugestoes(query, searchSuggestionsList);
                } else {
                    searchSuggestions.innerHTML = '';
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
        searchInput.value = suggestion;
        currentSearchQuery = suggestion.toLowerCase();
        searchSuggestions.innerHTML = '';
        currentPage = 1;
        renderProducts();
    }

    // ===== FILTRAR PRODUTOS =====
                category: "baixo",
                title: "Contrabaixo Waldman Gjj-105 Bk Preto 5 Cordas",
                price: 2399.90,
                description: "O Contrabaixo Waldman GJJ-105 BK Preto de 5 Cordas é uma excelente escolha para baixistas que buscam qualidade e versatilidade. Com corpo em Basswood e braço em Maple, este instrumento oferece durabilidade e um som encorpado. O acabamento em verniz proporciona um visual elegante e proteção extra. Equipado com 20 trastes e 2 captadores Soapbar passivos, permite uma ampla gama de tonalidades. Os controles incluem Volume 1, Volume 2 e Tone, facilitando ajustes rápidos durante a performance. A ponte cromada garante estabilidade na afinação e durabilidade. O modelo GJJ-105 BK é ideal para diversos estilos musicais, especialmente jazz, graças ao seu design tipo Jazz Bass. O diapasão é feito de Technical Wood, oferecendo uma sensação suave ao tocar. Este contrabaixo é novo e pronto para elevar suas performances musicais a um novo patamar.",
                image: "catálogo/baixos/4 Contrabaixo Waldman Gjj-105 Bk Preto 5 Cordas/baixo4.png",
                thumbnails: ["catálogo/baixos/4 Contrabaixo Waldman Gjj-105 Bk Preto 5 Cordas/baixo4.png",
                "catálogo/baixos/4 Contrabaixo Waldman Gjj-105 Bk Preto 5 Cordas/baixo4- verso.png",
                "catálogo/baixos/4 Contrabaixo Waldman Gjj-105 Bk Preto 5 Cordas/baixo4- detalhes.png"] },

            { id: 5,
                category: "baixo",
                title: "Kit Contra Baixo 5 Cordas Giannini Gb205a Ativo + Acessórios",
                price: 2049.00,
                description: "Este kit inclui o contrabaixo Giannini GB205A, um modelo ativo de 5 cordas para destros, com corpo em Poplar, braço em Maple e escala em Rosewood. Possui 24 trastes e 2 captadores cerâmicos tipo Soap Bar. O kit é completo com capa acolchoada, correia, cabo P10 e afinador digital clip.",
                image: "catálogo/baixos/5 Kit Contra Baixo 5 Cordas Giannini Gb205a Ativo + Acessórios/baixo5.png",
                thumbnails: ["catálogo/baixos/5 Kit Contra Baixo 5 Cordas Giannini Gb205a Ativo + Acessórios/baixo5.png",
                "catálogo/baixos/5 Kit Contra Baixo 5 Cordas Giannini Gb205a Ativo + Acessórios/baixo5- detalhes.png",
                "catálogo/baixos/5 Kit Contra Baixo 5 Cordas Giannini Gb205a Ativo + Acessórios/baixo5- completo.png"
            ] },

            { id: 6,
                category: "baixo",
                title: "Contra Baixo Strinberg Sab66 Ativo 6 Cordas",
                price: 2899.00,
                description: "O Contrabaixo Strinberg SAB66 é um modelo ativo de 6 cordas para destros, com acabamento fosco (satin) e corpo em Ash. Possui braço em Maple e diapasão em Techwood. Conta com 2 captadores Soap Bar e 24 trastes.",
                image: "catálogo/baixos/6 Contra Baixo Strinberg Sab66 Ativo 6 Cordas/baixo6.png",
                thumbnails: ["catálogo/baixos/6 Contra Baixo Strinberg Sab66 Ativo 6 Cordas/baixo6.png",
                        "catálogo/baixos/6 Contra Baixo Strinberg Sab66 Ativo 6 Cordas/baixo6- verso.png",
                        "catálogo/baixos/6 Contra Baixo Strinberg Sab66 Ativo 6 Cordas/baixo6- detalhes.png",
                        "catálogo/baixos/6 Contra Baixo Strinberg Sab66 Ativo 6 Cordas/baixo6- afinadores.png"
                ] },

            {id: 7,
    category: "baixo",
    title: "Contra Baixo Tagima Custom Millenium Top 4 Cordas Ativo",
    price: 2299.00,
    description: "O Contrabaixo Tagima Custom Millenium Top é um modelo ativo de 4 cordas para destros, com acabamento fosco e corpo em Okoume. Possui braço em Maple e diapasão em Techwood. Equipado com 2 captadores Single e 24 trastes. Acompanha palheta Groover.",
    image: "catálogo/baixos/7 Contra Baixo Tagima Custom Millenium Top 4 Cordas Ativo/baixo7.png",
    thumbnails: [
      "catálogo/baixos/7 Contra Baixo Tagima Custom Millenium Top 4 Cordas Ativo/baixo7.png",
      "catálogo/baixos/7 Contra Baixo Tagima Custom Millenium Top 4 Cordas Ativo/baixo7- afinadores.png",
      "catálogo/baixos/7 Contra Baixo Tagima Custom Millenium Top 4 Cordas Ativo/baixo7- detalhes.png"
    ]
  },

  {
    id: 8,
    category: "baixo",
    title: "Kit De Baixo Fender Squier Affinity Precison Bass",
    price: 4565.94,
    description: "Este kit inclui o contrabaixo Fender Squier Affinity Precision Bass PJ, um modelo de 4 cordas para destros, com acabamento Gloss Polyurethane e corpo em Álamo. Conta com um captador de braço P Bass single-coil split e um captador de ponte J Bass single-coil, além de 20 trastes. O kit completo vem com amplificador Rumble 15 (15 watts), gig bag acolchoado, alça e cabo.",
    image: "catálogo/baixos/8 Kit De Baixo Fender Squier Affinity Precison Bass/baixo8.png",
    thumbnails: [
      "catálogo/baixos/8 Kit De Baixo Fender Squier Affinity Precison Bass/baixo8.png",
      "catálogo/baixos/8 Kit De Baixo Fender Squier Affinity Precison Bass/baixo8- detalhes.png",
      "catálogo/baixos/8 Kit De Baixo Fender Squier Affinity Precison Bass/baixo8- verso.png"
    ]
  },

//  baixo



     // bandolim (8 itens)
            { id: 9, 
                category: "bandolim", 
                title: "Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico ", 
                price: 767.67, 
                description: "Este bandolim Marquês BND-100Nbac é um modelo estudante acústico, com 8 cordas e acabamento fosco em cor marrom-claro (natural sombra). Possui braço e corpo em Mogno, com formato de corpo A-Style.", 
                image: "catálogo/bandolins/1 Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico/bandolim1.png", 
                thumbnails: ["catálogo/bandolins/1 Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico/bandolim1.png", 
                "catálogo/bandolins/1 Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico/bandolim1- verso.png", 
                "catálogo/bandolins/1 Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico/bandolim1- detalhes.png",
                "catálogo/bandolins/1 Bandolim Marquês Bnd100 Estudante Natural Sombra Acústico/bandolim1- afinadores.png"
            ] },

            { id: 10, 
                category: "bandolim", 
                title: "Bandolim Marquês Bnd-100 Ns Acústico", 
                price: 925.00, 
                description: "O Bandolim Marquês BND-100 NS é um modelo acústico de 8 cordas. Possui braço em Cedro.", 
                image: "catálogo/bandolins/2 Bandolim Marquês Bnd-100 Ns Acústico/bandolim2.png", 
                thumbnails: ["catálogo/bandolins/2 Bandolim Marquês Bnd-100 Ns Acústico/bandolim2.png",
                    "catálogo/bandolins/2 Bandolim Marquês Bnd-100 Ns Acústico/bandolim2- detalhes.png",
                    "catálogo/bandolins/2 Bandolim Marquês Bnd-100 Ns Acústico/bandolim2- afinadores.png"
                ] },


            { id: 11, 
                category: "bandolim", 
                title: "Bandolim Marquês Bnd-100 Nb Acústico", 
                price: 975.00, 
                description: "Este bandolim Marquês BND-100 NB é um modelo acústico para destros, com 8 cordas e acabamento fosco. Possui braço em Cedro e formato de corpo A-Style.", 
                image: "catálogo/bandolins/3 Bandolim Marquês Bnd-100 Nb Acústico/bandolim3.png", 
                thumbnails: ["catálogo/bandolins/3 Bandolim Marquês Bnd-100 Nb Acústico/bandolim3.png",
                    "catálogo/bandolins/3 Bandolim Marquês Bnd-100 Nb Acústico/bandolim3- verso.png",
                    "catálogo/bandolins/3 Bandolim Marquês Bnd-100 Nb Acústico/bandolim3- afinadores.png"
                ] },


            { id: 12, 
                category: "bandolim", 
                title: "Bandolim Marques Bnd-100 Estudante Natural Sombra Acústico", 
                price: 749.90, 
                description: "O Bandolim Marquês BND-100Nbac é um modelo estudante acústico, com 8 cordas e cor natural (sombra). Possui braço em Cedro.", 
                image: "catálogo/bandolins/4 Bandolim Marques Bnd-100 Estudante Natural Sombra Acústico/bandolim4.png", 
                thumbnails: ["catálogo/bandolins/4 Bandolim Marques Bnd-100 Estudante Natural Sombra Acústico/bandolim4.png",
                    "catálogo/bandolins/4 Bandolim Marques Bnd-100 Estudante Natural Sombra Acústico/bandolim4- verso.png",
                    "catálogo/bandolins/4 Bandolim Marques Bnd-100 Estudante Natural Sombra Acústico/bandolim4- detalhes.png"
                ] },


            { id: 13, 
                category: "bandolim", 
                title: "Bandolim Tagima Acústico BM50", 
                 price: 831.89, 
                description: "Este bandolim acústico Giannini Raiz BS1 é um modelo de 8 cordas para destros, com acabamento fosco. Possui corpo em Imbuia e Marupá (madeira Gonçalo Alves), e braço em Cedro. Inclui estojo.", 
                image: "catálogo/bandolins/5 Bandolim Acústico Giannini Raiz BS1 NS/bandolim5.png", 
                thumbnails: ["catálogo/bandolins/5 Bandolim Acústico Giannini Raiz BS1 NS/bandolim5.png",
                    "catálogo/bandolins/5 Bandolim Acústico Giannini Raiz BS1 NS/bandolim5- verso.png",
                    "catálogo/bandolins/5 Bandolim Acústico Giannini Raiz BS1 NS/bandolim5- detalhes.png"
                ] },


            { id: 14, 
                category: "bandolim", 
                title: "Bandolim Rozini Profissional Natural Rb22", 
                price: 3975.99, 
                description: "O Bandolim Rozini Profissional RB22 é um modelo acústico de 8 cordas para destros, na cor natural e com acabamento brilhante. Possui corpo em Jacarandá e braço em Cedro.", 
                image: "catálogo/bandolins/6 Bandolim Rozini Profissional Natural Rb22/bandolim6.png", 
                thumbnails: ["catálogo/bandolins/6 Bandolim Rozini Profissional Natural Rb22/bandolim6.png",
                    "catálogo/bandolins/6 Bandolim Rozini Profissional Natural Rb22/bandolim6- cravelhas.png",
                    "catálogo/bandolins/6 Bandolim Rozini Profissional Natural Rb22/bandolim6- detalhes.png"
                ] },


            { id: 15, 
                category: "bandolim", 
                title: "Bandolim Giannini Acústico Natural Gonçalo Alves", 
                price: 973.07, 
                description: "Este bandolim acústico Giannini é de 8 cordas, na cor natural. Possui braço em Cedro e corpo em Marupá maciço (Gonçalo Alves).", 
                image: "catálogo/bandolins/7 Bandolim Giannini Acústico Natural Gonçalo Alves/bandolim7.png", 
                thumbnails: ["catálogo/bandolins/7 Bandolim Giannini Acústico Natural Gonçalo Alves/bandolim7.png",
                    "catálogo/bandolins/7 Bandolim Giannini Acústico Natural Gonçalo Alves/bandolim7- verso.png",
                    "catálogo/bandolins/7 Bandolim Giannini Acústico Natural Gonçalo Alves/bandolim7- cravelhas.png",
                    "catálogo/bandolins/7 Bandolim Giannini Acústico Natural Gonçalo Alves/bandolim7- detalhes.png"
                ] },


            { id: 16, 
                category: "bandolim", 
                title: "Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini", 
                price: 4497.30, 
                description: "O Bandolim Rozini Profissional RB25HH, modelo Hamilton de Holanda, é um bandolim elétrico de 10 cordas para destros, com acabamento brilhante. Possui corpo em Madeira de Bordo e braço em Cedro/Jacarandá. Inclui estojo.", 
                image: "catálogo/bandolins/8 Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini/bandolim8.png", 
                thumbnails: ["catálogo/bandolins/8 Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini/bandolim8.png",
                    "catálogo/bandolins/8 Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini/bandolim8- cordas.png",
                    "catálogo/bandolins/8 Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini/bandolim8- detalhes.png",
                    "catálogo/bandolins/8 Bandolim Profirb25hh Hamilton De Holanda Elétrico - Rozini/bandolim8- case.png"
                ] },

             // Banjo (8 items)
            { id: 17, 
                category: "banjo", 
                title: "Banjo Acústico Strinberg Wb50 Natural Bluegrass", 
                price: 1355.00, 
                description: "Este Banjo Acústico Strinberg WB50 é um modelo de 5 cordas, com acabamento brilhante na cor natural (bluegrass). Possui corpo em Mahogany Laminado e braço em Nato, com 22 trastes e ressonador.", 
                image: "catálogo/banjos/1 Banjo Acústico Strinberg Wb50 Natural Bluegrass/banjo1.png", 
                thumbnails: ["catálogo/banjos/1 Banjo Acústico Strinberg Wb50 Natural Bluegrass/banjo1.png",
                    "catálogo/banjos/1 Banjo Acústico Strinberg Wb50 Natural Bluegrass/banjo1- verso.png",
                    "catálogo/banjos/1 Banjo Acústico Strinberg Wb50 Natural Bluegrass/banjo1- afinadores.png",
                    "catálogo/banjos/1 Banjo Acústico Strinberg Wb50 Natural Bluegrass/banjo1- detalhes.png",
                ] },

            { id: 18, 
                category: "banjo", 
                title: "Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia", 
                price: 1189.00, 
                description: "Este Banjo Eletroacústico é ideal para estudantes. Possui acabamento natural fosco, proporcionando um visual elegante.", 
                image: "catálogo/banjos/2 Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia/banjo2.png", 
                thumbnails: ["catálogo/banjos/2 Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia/banjo2.png",
                    "catálogo/banjos/2 Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia/banjo2-verso.png",
                    "catálogo/banjos/2 Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia/banjo2-detalhes.png",
                    "catálogo/banjos/2 Banjo Estudante Rozini Rj14 Elétric Caixa Larga Fosco Imbuia/banjo2-afinadores.png",
                ] },

            { id: 19, 
                category: "banjo", 
                title: "Banjo Americano Strinberg Wb50", 
                price: 2050.95, 
                description: "O Banjo Americano Strinberg WB50 é um modelo de 5 cordas, com acabamento brilhante e corpo em Nato.", 
                image: "catálogo/banjos/3 Banjo Americano Strinberg Wb50/banjo3.png", 
                thumbnails: ["catálogo/banjos/3 Banjo Americano Strinberg Wb50/banjo3.png",
                    "catálogo/banjos/3 Banjo Americano Strinberg Wb50/banjo3- frente e verso.png",
                    "catálogo/banjos/3 Banjo Americano Strinberg Wb50/banjo3- braço.png",
                    "catálogo/banjos/3 Banjo Americano Strinberg Wb50/banjo3- detalhes.png",
                ] },

            { id: 20, 
                category: "banjo", 
                title: "Banjo Giannini Bluegrass", 
                price: 1756.87, 
                description: "Este Banjo Americano Strinberg WB50 é um modelo acústico de 5 cordas, com acabamento brilhante. Possui corpo em Mahogany Laminado e braço em Nato, com 22 trastes e ressonador.", 
                image: "catálogo/banjos/4 Banjo Americano Strinberg WB50 (Acabamento Brilhante)/banjo4.png", 
                thumbnails: ["catálogo/banjos/4 Banjo Americano Strinberg WB50 (Acabamento Brilhante)/banjo4.png", 
                    "catálogo/banjos/4 Banjo Americano Strinberg WB50 (Acabamento Brilhante)/banjo4- verso.png", 
                    "catálogo/banjos/4 Banjo Americano Strinberg WB50 (Acabamento Brilhante)/banjo4- afinadores.png", 
                    "catálogo/banjos/4 Banjo Americano Strinberg WB50 (Acabamento Brilhante)/banjo4- detalhes.png", 
                ] },

            { id: 21, 
                category: "banjo", 
                title: "Banjo AKLOT", 
                price: 1829.055, 
                description: "Este banjo AKLOT de 5 cordas, na cor transparente, possui dimensões de 105 x 15 x 43 centímetros. É feito inteiramente de madeira de bordo, o que proporciona um som muito brilhante e claro. A cabeça, feita de madeira de bordo de tigre importada da Europa, complementa a cabeça do tambor Remo. O banjo conta com uma abertura nas costas e cabeça Remo profissional de alta qualidade, fixada por 18 suportes ajustáveis. Possui haste de treliça bidirecional para ajuste do pescoço e da cabeça do tambor. Para melhor manutenção do tom, a ponte de madeira maciça é combinada com a sela de touro, otimizando a vibração das cordas, e os pinos selados protegem as engrenagens e facilitam a afinação. O kit inclui o banjo, cordas, afinador, chaves de afinação, palheta de dedo, alças, pano de limpeza e bolsa de show, sendo completo para iniciantes e profissionais.", 
                image: "catálogo/banjos/5 Banjo AKLOT/banjo5- completo.png", 
                thumbnails: ["catálogo/banjos/5 Banjo AKLOT/banjo5- completo.png",
                    "catálogo/banjos/5 Banjo AKLOT/banjo5.png",
                    "catálogo/banjos/5 Banjo AKLOT/banjo5- frente e verso.png",
                    "catálogo/banjos/5 Banjo AKLOT/banjo5- detalhes.png"
                ] },

            { id: 22, 
                category: "banjo", 
                title: "Banjo Ativo Rozini Color Rj11 At. Vd Verde", 
                price: 2080.00, 
                description: "O Banjo Ativo Rozini Color RJ11 AT. VD é um modelo de 4 cordas na cor verde, com acabamento brilhante e 19 braçadeiras. Possui corpo em Mogno.", 
                image: "catálogo/banjos/6 Banjo Ativo Rozini Color Rj11 At. Vd Verde/banjo6.png", 
                thumbnails: ["catálogo/banjos/6 Banjo Ativo Rozini Color Rj11 At. Vd Verde/banjo6.png", 
                    "catálogo/banjos/6 Banjo Ativo Rozini Color Rj11 At. Vd Verde/banjo6- verso.png", 
                    "catálogo/banjos/6 Banjo Ativo Rozini Color Rj11 At. Vd Verde/banjo6- afinador.webp", 
                    "catálogo/banjos/6 Banjo Ativo Rozini Color Rj11 At. Vd Verde/banjo6- detalhes.webp"
                ] },

            { id: 23, 
                category: "banjo", 
                title: "Banjo Rozini Rj11 At.az Elétrico Azul", 
                price: 2080.00, 
                description: "Este é um banjo elétrico Rozini, modelo RJ11 At.az, com 4 cordas, na cor azul-claro e acabamento brilhante. Possui corpo feito de Mogno e conta com ressonador.", 
                image: "catálogo/banjos/7 Banjo Rozini Rj11 At.az Elétrico Azul/banjo7.png", 
                thumbnails: ["catálogo/banjos/7 Banjo Rozini Rj11 At.az Elétrico Azul/banjo7.png",
                    "catálogo/banjos/7 Banjo Rozini Rj11 At.az Elétrico Azul/banjo7- verso.png",
                    "catálogo/banjos/7 Banjo Rozini Rj11 At.az Elétrico Azul/banjo7- frente.png",
                    "catálogo/banjos/7 Banjo Rozini Rj11 At.az Elétrico Azul/banjo7- cravelhas.png"
                ] },

            { id: 24, 
                category: "banjo", 
                title: "Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado", 
                price: 1842.67, 
                description: "Este é um banjo elétrico Marquês, modelo BAJ-224BKSEL, com 4 cordas, acabamento acetinado na cor preta e dourado. Possui corpo e braço de Mogno, com 18 braçadeiras e 19 trastes. Conta com ressonador.", 
                image: "catálogo/banjos/8 Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado/banjo8.png", 
                thumbnails: [ "catálogo/banjos/8 Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado/banjo8.png",
                     "catálogo/banjos/8 Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado/banjo8- verso.png",
                      "catálogo/banjos/8 Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado/banjo8- frente e verso.png",
                       "catálogo/banjos/8 Banjo Marquês Eletroacústico Baj-224bksel Preto E Dourado/banjo8- detalhes.png",
                ] },


             // Cavaquinhos
    { id: 25, 
        category: "cavaquinho", 
        title: "Cavaquinho Cavaco Estudante Acústico Natural Ou Preto", 
        price: 278.00, 
        description: "Este cavaquinho acústico Roos #054 é um modelo estudante para destros , na cor natural e com acabamento fosco. Possui corpo em Mogno , tampo em Marupá , braço em Pinho , diapasão e ponte em Bordo. As cordas são de Aço.", 
        image: "catálogo/cavaquinhos/1 Cavaquinho Cavaco Estudante Acústico Natural Ou Preto/cavaquinho1.png", 
        thumbnails: ["catálogo/cavaquinhos/1 Cavaquinho Cavaco Estudante Acústico Natural Ou Preto/cavaquinho1.png",
            "catálogo/cavaquinhos/1 Cavaquinho Cavaco Estudante Acústico Natural Ou Preto/cavaquinho1- verso.png",
            "catálogo/cavaquinhos/1 Cavaquinho Cavaco Estudante Acústico Natural Ou Preto/cavaquinho1- detalhes.png"
        ] },


    { id: 26, 
        category: "cavaquinho", 
        title: "Cavaco Rozini Rc10.el.fi Elétrico Fosco Caixa Larga", 
        price: 789.00, 
        description: "O Cavaco Rozini RC10.EL.F.I é um modelo eletroacústico para destros , com acabamento brilhante  e caixa larga. Possui corpo laminado , tampo em Abeto , braço em Cedro , diapasão em Blackwood e ponte em Bordo. As cordas são de Aço.", 
        image: "catálogo/cavaquinhos/2 Cavaco Rozini Rc10.el.fi Elétrico Fosco Caixa Larga/cavaquinho2.png", 
        thumbnails: ["catálogo/cavaquinhos/2 Cavaco Rozini Rc10.el.fi Elétrico Fosco Caixa Larga/cavaquinho2.png",
            "catálogo/cavaquinhos/2 Cavaco Rozini Rc10.el.fi Elétrico Fosco Caixa Larga/cavaquinho2- cravelhas.png",
            "catálogo/cavaquinhos/2 Cavaco Rozini Rc10.el.fi Elétrico Fosco Caixa Larga/cavaquinho2- verso das cravelhas.png"
        ] },


    { id: 27, 
        category: "cavaquinho", 
        title: "Cavaquinho Toks Eletroacústico Natural", 
        price: 565.00, 
        description: "Este cavaquinho eletroacústico Toks é para destros , na cor natural e com acabamento brilhante. Possui corpo em Imbuia , tampo em Marfim , braço em Caxeta , diapasão em Sabina maciça e ponte em Bordo. As cordas são de Aço. Acompanha palhetas.", 
        image: "catálogo/cavaquinhos/3 Cavaquinho Toks Eletroacústico Natural +/cavaquinho3.png", 
        thumbnails: [ "catálogo/cavaquinhos/3 Cavaquinho Toks Eletroacústico Natural +/cavaquinho3.png",
             "catálogo/cavaquinhos/3 Cavaquinho Toks Eletroacústico Natural +/cavaquinho3- detalhes.png"
        ] },


    { id: 28, 
    category: "cavaquinho", 
    title: "Cavaco Acústico Strinberg Cs25 Hbs Com Kit", 
    price: 465.90, 
    description: "Este é um cavaquinho acústico Strinberg, modelo CS25 HBS, para destros, na cor marrom-claro e acabamento brilhante. Possui corpo de Spruce e braço de Linden. As cordas são de Aço e o kit inclui palhetas e afinador.", 
    image: "catálogo/cavaquinhos/4 Cavaco Acústico Strinberg Cs25 Hbs Com Kit/cavaquinho4.png", 
    thumbnails: ["catálogo/cavaquinhos/4 Cavaco Acústico Strinberg Cs25 Hbs Com Kit/cavaquinho4.png", 
        "catálogo/cavaquinhos/4 Cavaco Acústico Strinberg Cs25 Hbs Com Kit/cavaquinho4- frente.png", 
        "catálogo/cavaquinhos/4 Cavaco Acústico Strinberg Cs25 Hbs Com Kit/cavaquinho4- verso.png", 
        "catálogo/cavaquinhos/4 Cavaco Acústico Strinberg Cs25 Hbs Com Kit/cavaquinho4- cravelhas.png", 
    ] },


    { id: 29, 
        category: "cavaquinho", 
        title: "Cavaco Acústico Rozini Rc10 Caixa Larga - Fosco Imbuia", 
        price: 705.28, 
        description:"Este é um cavaquinho acústico Rozini, modelo RC10ACFI, para destros, com acabamento brilhante e caixa larga. Possui corpo de Marfim, tampo de Abeto, braço de Cedro, diapasão de Blackwood e ponte de Bordo. As cordas são de Aço. Suas dimensões são 10 cm de altura, 30 cm de largura e 62 cm de comprimento, com peso de 1,25 kg.", 
        image: "catálogo/cavaquinhos/5 Cavaco Acústico Rozini Rc10 Caixa Larga - Fosco Imbuia/cavaquinho5.png", 
        thumbnails: ["catálogo/cavaquinhos/5 Cavaco Acústico Rozini Rc10 Caixa Larga - Fosco Imbuia/cavaquinho5.png", 
            "catálogo/cavaquinhos/5 Cavaco Acústico Rozini Rc10 Caixa Larga - Fosco Imbuia/cavaquinho5- detalhes.png", 
            "catálogo/cavaquinhos/5 Cavaco Acústico Rozini Rc10 Caixa Larga - Fosco Imbuia/cavaquinho5- cravelhas.png", 
        ] },


    { id: 30, 
        category: "cavaquinho", 
        title: "Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh", 
        price: 556.82, 
        description: "Este é um cavaquinho acústico Terra, modelo TCV 01 MH, com acabamento fosco na cor Mahogany. Possui tampo, faixa e fundo de Mahogany (Mogno), braço de Cedro, e escala e cavalete de Black Walnut. O nut e rastilho são de Osso, e as tarraxas niqueladas 2+2. Acompanha capa.", 
        image: "catálogo/cavaquinhos/6 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho6.png", 
        thumbnails: ["catálogo/cavaquinhos/6 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho6.png",
            "catálogo/cavaquinhos/6 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho6- case.png",
            "catálogo/cavaquinhos/6 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho6- cravelhas.png"
        ] },


    { id: 31, 
        category: "cavaquinho", 
        title: "Cavaco Acústico Estudante Natural Cor MYTH ", 
        price: 284.14, 
        description: "Este é um cavaquinho acústico estudante Myth / Austin, modelo Iniciante, para destros, na cor natural e com acabamento brilhante. Possui corpo e tampo de Tília, braço de Okoumé e ponte de Wood. As cordas são de Aço e tem 61 cm de comprimento.", 
        image: "catálogo/cavaquinhos/7 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho7.png", 
        thumbnails: ["catálogo/cavaquinhos/7 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho7.png",
            "catálogo/cavaquinhos/7 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho7-.png",
            "catálogo/cavaquinhos/7 Cavaquinho Terra Acustico Fosco Com Capa Mahogany Tcv 01 Mh/cavaquinho7detalhes.png"
        ] },


    { id: 32, 
        category: "cavaquinho", 
        title: "Cavaco Iniciante Estudo Acústico Preto Com Capa", 
        price: 299.20, 
        description: "Este é um cavaquinho acústico da marca Roos, na cor preta e com acabamento fosco. É um modelo para destros, feito de madeira tanto no corpo quanto no braço. Possui cordas de Aço e acompanha capa. Suas dimensões são 6,5 cm de altura, 23 cm de largura e 59 cm de comprimento, com peso de 1 kg.", 
        image: "catálogo/cavaquinhos/8 Cavaco Iniciante Estudo Acústico Preto Com Capa/cavaquinho8.png", 
        thumbnails: ["catálogo/cavaquinhos/8 Cavaco Iniciante Estudo Acústico Preto Com Capa/cavaquinho8.png",
            "catálogo/cavaquinhos/8 Cavaco Iniciante Estudo Acústico Preto Com Capa/cavquinho8- verso.png",
            "catálogo/cavaquinhos/8 Cavaco Iniciante Estudo Acústico Preto Com Capa/cavaquinho8- case.png",
            "catálogo/cavaquinhos/8 Cavaco Iniciante Estudo Acústico Preto Com Capa/cavaquinho8- cravelhas.png"
        ] },


             // Guitarras (8 items)
            { id: 33,
                category:
                "guitarra",
                title: "Guitarra Fender Standard Stratocaster Olympic White",
                price: 6562.00, description: "A Guitarra Fender Standard Stratocaster , lançada em 2022 , é um modelo para destros , com 6 cordas , na cor Olympic White e acabamento Gloss. Possui corpo e tampo em Poplar , braço e diapasão em Madeira de bordo. Conta com 3 captadores e alavanca.",
                image: "catálogo/guitarras//1 Guitarra Fender Standard Stratocaster Olympic White/guitarra1.png",
                thumbnails: ["catálogo/guitarras//1 Guitarra Fender Standard Stratocaster Olympic White/guitarra1.png",
                "catálogo/guitarras//1 Guitarra Fender Standard Stratocaster Olympic White/guitarra1- verso.png",
                "catálogo/guitarras//1 Guitarra Fender Standard Stratocaster Olympic White/guitarra1- cravelhas.png"] },

            { id: 34,
                category: "guitarra",
                title: "Guitarra Elétrica Gibson Modern Collection Les Paul",
                price: 17495.00,
                description: "A Guitarra Elétrica Gibson Les Paul Tribute da Modern Collection é um modelo para destros , com 6 cordas , na cor Satin Tobacco Burst e acabamento em laca nitrocelulósica acetinada. Possui formato de corpo Les Paul , corpo em Mogno , braço em Bordo com construção Set-in , e diapasão em Pau-rosa. Conta com 22 trastes Medium Jumbo , 2 captadores Humbucker (490R no braço e 490T na ponte) , chave seletora de 3 posições e controles de Tone e Volume. A ponte é fixa do tipo Aluminum Nashville Tune-o-matic e inclui estojo e kit de acessórios Gibson.",
                image: "catálogo/guitarras/2 Guitarra Elétrica Gibson Modern Collection Les Paul/guitarra2.png",
                thumbnails: ["catálogo/guitarras/2 Guitarra Elétrica Gibson Modern Collection Les Paul/guitarra2.png",
                    "catálogo/guitarras/2 Guitarra Elétrica Gibson Modern Collection Les Paul/guitarra2- verso.png",
                    "catálogo/guitarras/2 Guitarra Elétrica Gibson Modern Collection Les Paul/guitarra2- cravelhas.png",
                    "catálogo/guitarras/2 Guitarra Elétrica Gibson Modern Collection Les Paul/guitarra2- detalhes.png"
                ] },

            { id: 35,
                category: "guitarra",
                title: "Guitarra Fender Standard Telecaster Butterscotch Blonde",
                price: 6234.00,
                description: "A Guitarra Fender Standard Telecaster , lançada em 2024 , é um modelo para destros , com 6 cordas , na cor Butterscotch Blonde e acabamento em Poliuretano brilhante. Possui corpo e tampo em Choupo/Álamo , e braço e diapasão em Bordo. Conta com 2 captadores.",
                image: "catálogo/guitarras/3 Guitarra Fender Standard Telecaster Butterscotch Blonde/guitarra3.png",
                thumbnails: ["catálogo/guitarras/3 Guitarra Fender Standard Telecaster Butterscotch Blonde/guitarra3.png",
                    "catálogo/guitarras/3 Guitarra Fender Standard Telecaster Butterscotch Blonde/guitarra3- verso.png",
                    "catálogo/guitarras/3 Guitarra Fender Standard Telecaster Butterscotch Blonde/guitarra3- cravelhas.png",
                    "catálogo/guitarras/3 Guitarra Fender Standard Telecaster Butterscotch Blonde/guitarra3- detalhes.png"
                ] },

            { id: 36,
                category: "guitarra",
                title: "Guitarra elétrica Queen's D137561 Stratocaster",
                price: 664.93,
                description: "Esta é uma guitarra elétrica Queen's, modelo D137561, no formato Stratocaster, para destros, nas cores Vermelho/Branco. Possui corpo de Hardwood, braço de Bordo e diapasão de Bordo-acerneiro. Conta com 6 cordas, 22 trastes e 3 captadores Single Coil (braço, meio e ponte) com chave seletora de 5 posições. A ponte é do tipo Synch Tremolo e inclui alavanca. Os controles são de chave seletora de captadores, Tone e Volume. Acompanha cabo de conexão, chave Allen e escala.",
                image: "catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4.png",
                thumbnails: ["catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4.png",
                    "catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4- verso.png",
                    "catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4- detalhes.png",
                    "catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4- cavalete.png",
                    "catálogo/guitarras/4 Guitarra elétrica Queen's D137561 Stratocaster/guitarra4- cravelhas.png"
                ] },

            { id: 37,
                category: "guitarra",
                title: "Guitarra Strato Tagima Memphis Mg30 Sb Sunburst",
                price: 813.19,
                description: "Esta é uma guitarra elétrica Tagima Memphis, modelo MG-30, no formato Stratocaster, para destros, na cor Sunburst e acabamento Satin. Possui corpo de Tília, braço de Bordo e diapasão de Madeira técnica. Conta com 6 cordas, 22 trastes e 3 captadores Single Coils cerâmicos by Memphis com chave seletora de 5 posições. A ponte é do tipo Synch Tremolo e inclui alavanca.",
                image: "catálogo/guitarras/5 Guitarra Strato Tagima Memphis Mg30 Sb Sunburst/guitarra5.png",
                thumbnails: ["catálogo/guitarras/5 Guitarra Strato Tagima Memphis Mg30 Sb Sunburst/guitarra5.png",
                    "catálogo/guitarras/5 Guitarra Strato Tagima Memphis Mg30 Sb Sunburst/guitarra5- lateral.png",
                    "catálogo/guitarras/5 Guitarra Strato Tagima Memphis Mg30 Sb Sunburst/guitarra5- detalhes.png",
                    "catálogo/guitarras/5 Guitarra Strato Tagima Memphis Mg30 Sb Sunburst/guitarra5- cravelhas.png"
                ] },

            { id: 38,
                category: "guitarra",
                title: "Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue",
                price: 748.36,
                description: "Esta é uma guitarra elétrica Strinberg STS Series, modelo STS100, no formato Stratocaster, para destros, na cor Metallic Blue e acabamento brilhante. Possui corpo de Tília (tampo de Besswood sólido), braço de Bordo e diapasão de Bordo. Conta com 6 cordas, 22 trastes e 3 captadores Single Coil com chave seletora de 5 posições. A ponte é do tipo Tremolo vintage e inclui alavanca. Os controles são de chave seletora de captadores, Tone e Volume.",
                image: "catálogo/guitarras/6 Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue/guitarra6.png",
                thumbnails: ["catálogo/guitarras/6 Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue/guitarra6.png",
                    "catálogo/guitarras/6 Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue/guitarra6- verso.png",
                    "catálogo/guitarras/6 Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue/guitarra6- detalhes.png"
                ] },

            { id: 39,
                category: "guitarra",
                title: "Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood",
                price: 1389.00,
                description: "Esta é uma guitarra elétrica Strinberg LPS Series, modelo LPS230, no formato Les Paul, para destros, na cor Transparent Blue e acabamento brilhante. Possui corpo de Besswood, braço de Maple e diapasão de Techwood. Conta com 6 cordas, 22 trastes Medium Jumbo e 2 captadores Humbucker com chave seletora de 3 posições. A ponte é do tipo Tune-o-matic (fixa) e acompanha palheta.",
                image: "catálogo/guitarras/7 Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood/guitarra7.png",
                thumbnails: ["catálogo/guitarras/7 Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood/guitarra7.png",
                    "catálogo/guitarras/7 Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood/guitarra7- verso.png",
                    "catálogo/guitarras/7 Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood/guitarra7- cravelhas.png",
                    "catálogo/guitarras/7 Guitarra Strinberg Les Paul LPS230 Blue Nova!! Destro Transparent Blue Techwood/guitarra7- detalhes.png"
                ] },

            { id: 40,
                category: "guitarra",
                title: "Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco",
                price: 2490.00,
                description: "Esta é uma guitarra elétrica Ibanez RG GIO, modelo GRGR131EX, para destros, na cor Black Flat e acabamento fosco. Possui corpo de Choupo, braço de Bordo e diapasão de Amaranto. Conta com 6 cordas, 24 trastes Jumbo e 2 captadores Humbucker (Infinity R) com chave seletora de 5 posições. A ponte é do tipo F106 (fixa). Os controles são de chave seletora de captadores, Tone e Volume.",
                image: "catálogo/guitarras/8 Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco/guitarra8.png", 
                thumbnails: ["catálogo/guitarras/8 Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco/guitarra8.png",
                    "catálogo/guitarras/8 Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco/guitarra8- verso.png",
                    "catálogo/guitarras/8 Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco/guitarra8- detalhes.png",
                    "catálogo/guitarras/8 Guitarra elétrica Ibanez RG GIO GRGR131EX de Choupo Black Flat Fosco/guitarra8- cravelhas.png"
                ] },


             // Ukulele (8 items)
            { id: 41, 
                category: "ukulele", 
                title: "Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador", 
                price: 174.057, 
                description: "O Ukulele Seven Concert SUK-23 LB é um modelo acústico na cor azul (claro), com 4 cordas e acabamento fosco. Feito de Mogno, acompanha capa e palhetas.", 
                image: "catálogo/ukuleles/1 Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador/ukulele1.png", 
                thumbnails: ["catálogo/ukuleles/1 Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador/ukulele1.png",
                "catálogo/ukuleles/1 Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador/ukulele1- verso.png",
                "catálogo/ukuleles/1 Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador/ukulele1- detalhes.png",
                "catálogo/ukuleles/1 Ukulele Azul Claro Seven Concert SUK-23 LB C Capa E Afinador/ukulele1- case.png"
            ] },

            { id: 42, 
                category: "ukulele", 
                title: "Ukulele Rosa Seven Concert Suk-23 Pi C/ Capa E Afinador", 
                price: 184.75, 
                description: "Este ukulele Seven Concert SUK-23 PI é um modelo acústico para destros, na cor rosa, com 4 cordas e acabamento fosco. Acompanha capa e afinador.", 
                image: "catálogo/ukuleles/2 Ukulele Rosa Seven Concert Suk-23 Pi C Capa E Afinador/ukulele2.png", thumbnails: ["catálogo/ukuleles/2 Ukulele Rosa Seven Concert Suk-23 Pi C Capa E Afinador/ukulele2.png",
                "catálogo/ukuleles/2 Ukulele Rosa Seven Concert Suk-23 Pi C Capa E Afinador/ukulele2- verso.png",
                "catálogo/ukuleles/2 Ukulele Rosa Seven Concert Suk-23 Pi C Capa E Afinador/ukulele2- detalhes.png",
                "catálogo/ukuleles/2 Ukulele Rosa Seven Concert Suk-23 Pi C Capa E Afinador/ukulele2- case.png"
            ] },

            { id: 43, 
                category: "ukulele", 
                title: "Ukulele Preto Seven Concert Suk-23 Bk C/ Capa Afinador", 
                price: 187.00, 
                description: "O Ukulele Seven Concert SUK-23 BK é um modelo acústico preto, com 4 cordas e acabamento fosco. Feito de Basswood, vem com capa, afinador e palheta.", 
                image: "catálogo/ukuleles/3 Ukulele Preto Seven Concert Suk-23 Bk C Capa Afinador/ukulele3.png", 
                thumbnails: ["catálogo/ukuleles/3 Ukulele Preto Seven Concert Suk-23 Bk C Capa Afinador/ukulele3.png",
                    "catálogo/ukuleles/3 Ukulele Preto Seven Concert Suk-23 Bk C Capa Afinador/ukulele3- verso.png",
                    "catálogo/ukuleles/3 Ukulele Preto Seven Concert Suk-23 Bk C Capa Afinador/ukulele3- detalhes.png",
                    "catálogo/ukuleles/3 Ukulele Preto Seven Concert Suk-23 Bk C Capa Afinador/ukulele3- case.png"
                ] },

            { id: 44, 
                category: "ukulele", 
                title: "Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador", 
                price: 175.57, 
                description: "Este ukulele Seven Concert SUK-23 NT é um modelo acústico na cor natural, com 4 cordas e acabamento fosco. Feito de Mogno e Picea, acompanha capa e palhetas.", 
                image: "catálogo/ukuleles/4 Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador/ukulele4.png", 
                thumbnails: ["catálogo/ukuleles/4 Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador/ukulele4.png",
                    "catálogo/ukuleles/4 Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador/ukulele4- verso.png",
                    "catálogo/ukuleles/4 Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador/ukulele4- detalhes.png",
                    "catálogo/ukuleles/4 Ukulele Natural Seven Concert Suk-23 Nt C Capa Afinador/ukulele4- case.png"
                ] },

            { id: 45, 
                category: "ukulele", 
                title: "Ukulele Concert Bahardan", 
                price: 139.00, 
                description: "Este Ukulele Concert da marca Bahardan é compacto e portátil, com 21 polegadas, ideal para viajar com uma mochila ou praticar em casa. Possui material de mogno selecionado que oferece um tom quente e suave. Seu design de aparência requintada conta com um delicado processo de laca e tensão de cordas moderada, facilitando o toque para iniciantes. A curvatura científica do corpo garante um design ergonômico, evitando o cansaço ao segurar o instrumento. Após afinação profissional, a entonação é estável. É equipado com acessórios de alta qualidade, incluindo bolsa, alça e plectrums, para atender às necessidades de uso e transporte diários.", 
                image: "catálogo/ukuleles/5 Ukulele Concert Bahardan/ukulele5.png", 
                thumbnails: ["catálogo/ukuleles/5 Ukulele Concert Bahardan/ukulele5.png",
                    "catálogo/ukuleles/5 Ukulele Concert Bahardan/ukulele5- cravelhas.png",
                    "catálogo/ukuleles/5 Ukulele Concert Bahardan/ukulele5- detalhes.png"
                ] },

            { id: 46, 
                category: "ukulele", 
                title: "Ukulele de Viagem ANVAR", 
                price: 500.00, 
                description: "Este ukulele de viagem da marca ANVAR, na cor preta, é construído em fibra de carbono e policarbonato, o que o torna ultrarresistente, impermeável e fácil de limpar. É ideal para viagens, acampamentos ou uso em praias, pesando apenas 0,57kg e tendo 4,5cm de espessura, o que permite que caiba em qualquer mochila. Além disso, suporta variações de temperatura e umidade sem deformar. Seu design inovador apresenta corpo curvo, braço radiado e abertura lateral de ressonância, proporcionando um som mais brilhante, quente e equilibrado que ukuleles de madeira tradicional, sendo perfeito para pop, folk havaiano e estilos acústicos. O kit completo para iniciantes inclui afinador digital preciso, cordas de náilon premium, capotraste de mola, 3 palhetas ergonômicas, alça ajustável e mochila protetora. Indicado para todos os níveis, do iniciante ao profissional, possui braço estreito com trastes polidos e ação baixa das cordas, facilitando o aprendizado e reduzindo a fadiga dos dedos.", 
                image: "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6.png", 
                thumbnails: ["catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6.png",
                    "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6- verso.png",
                    "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6- conforto.png",
                    "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6- cordas.png",
                    "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6- detalhado.png",
                    "catálogo/ukuleles/6 Ukulele de Viagem ANVAR/ukulele6- som.png"
                ] },

            { id: 47, 
                category: "ukulele", 
                title: "Ukulele Acústico Concert 23EP Abacaxi Ébano c/Bag - Malibu", 
                price: 760.00, 
                description: "Este ukulele acústico Concert da marca Malibu, modelo 23EP, possui um design exclusivo com formato de abacaxi, acabamento fosco e corpo em ébano laminado. Suas dimensões são 66 x 25 x 10 centímetros. A construção premium inclui braço fabricado em Okume, oferecendo excelente estabilidade e conforto ao tocar. Os componentes técnicos contam com escala e cavalete em Technical Wood, proporcionando ótima durabilidade e sonoridade. O ukulele acompanha bag para transporte.", 
                image: "catálogo/ukuleles/7 Ukulele Acústico Concert 23EP Abacaxi Ébano cBag - Malibu/ukulele7.png", 
                thumbnails: [ "catálogo/ukuleles/7 Ukulele Acústico Concert 23EP Abacaxi Ébano cBag - Malibu/ukulele7.png",
                     "catálogo/ukuleles/7 Ukulele Acústico Concert 23EP Abacaxi Ébano cBag - Malibu/ukulele7- verso.png",
                      "catálogo/ukuleles/7 Ukulele Acústico Concert 23EP Abacaxi Ébano cBag - Malibu/ukulele7- case.png",
                       "catálogo/ukuleles/7 Ukulele Acústico Concert 23EP Abacaxi Ébano cBag - Malibu/ukulele7- detalhes.png"
                ] },



            { id: 48, 
                category: "ukulele", 
                title: "Ukulele Concerto Concert Acústico Zebra Wood", 
                price: 259.00, 
                description: "Este ukulele apresenta uma bela cor Madeira Zebra (natural). Tanto o tampo quanto o material traseiro são feitos de Zebrawood, conferindo-lhe uma estética única. As cordas também são de madeira de Zebra, complementando o visual distinto do instrumento.", 
                image: "catálogo/ukuleles/8 Ukulele Concerto Concert Acústico Zebra Wood/ukulele8.png", 
                thumbnails: ["catálogo/ukuleles/8 Ukulele Concerto Concert Acústico Zebra Wood/ukulele8.png",
                    "catálogo/ukuleles/8 Ukulele Concerto Concert Acústico Zebra Wood/ukulele8- verso.png",
                    "catálogo/ukuleles/8 Ukulele Concerto Concert Acústico Zebra Wood/ukulele8- cravelhas.png",
                    "catálogo/ukuleles/8 Ukulele Concerto Concert Acústico Zebra Wood/ukulele8- frente e verso.png",
                ] },


             // Viola caipira (8 items)
            { id: 49, 
                category: "viola_caipira", 
                title: "Viola eletroacústica Giannini Start VS-14 EQ ", 
                price: 484.50, 
                description: "Esta viola eletroacústica Giannini Start VS-14 EQ é para destros, na cor preta, com acabamento em verniz brilhante. Possui 10 cordas de metal, tampo, fundo e laterais em Tília, e diapasão em Sabina Sólida. Conta com equalizador e afinador integrados.", 
                image: "catálogo/violas_caipiras/1 Viola eletroacústica Giannini Start VS-14 EQ para destros black sabina solida verniz brilhante/viola1.png", 
                thumbnails: ["catálogo/violas_caipiras/1 Viola eletroacústica Giannini Start VS-14 EQ para destros black sabina solida verniz brilhante/viola1.png",
                    "catálogo/violas_caipiras/1 Viola eletroacústica Giannini Start VS-14 EQ para destros black sabina solida verniz brilhante/viola1- verso.png",
                    "catálogo/violas_caipiras/1 Viola eletroacústica Giannini Start VS-14 EQ para destros black sabina solida verniz brilhante/viola1- detalhes.png"
                ] },

            { id: 50, 
                category: "viola_caipira", 
                title: "Viola Caipira Giannini Acústica Iniciante Vs14 Cinturada", 
                price: 460.00, 
                description: "A Viola Caipira Giannini Acústica Iniciante VS14 é um modelo cinturado, com 10 cordas de aço e acabamento em verniz brilhante. Possui tampo em Linden, fundo e laterais em Tília, e braço em Cedro.", 
                image: "catálogo/violas_caipiras/2 Viola Caipira Giannini Acústica Iniciante Vs14 Cinturada/viola2.png", 
                thumbnails: [ "catálogo/violas_caipiras/2 Viola Caipira Giannini Acústica Iniciante Vs14 Cinturada/viola2.png",
                     "catálogo/violas_caipiras/2 Viola Caipira Giannini Acústica Iniciante Vs14 Cinturada/viola2- detalhes.png"
                ] },

            { id: 51, 
                category: "viola_caipira", 
                title: "Viola Acústica Caipira Giannini Start Vs-14 10 Cordas Aço", 
                price: 475.90, 
                description: "A Viola Acústica Caipira Giannini Start VS-14 possui 10 cordas de aço, com tampo, lateral e fundo em Basswood. O braço é de Okoume com tensor, e a escala e o cavalete são de Sabina maciça, com acabamento em verniz brilhante.", 
                image: "catálogo/violas_caipiras/3 Viola Acústica Caipira Giannini Start Vs-14 10 Cordas Aço/viola3.png", 
                thumbnails: ["catálogo/violas_caipiras/3 Viola Acústica Caipira Giannini Start Vs-14 10 Cordas Aço/viola3.png",
                    "catálogo/violas_caipiras/3 Viola Acústica Caipira Giannini Start Vs-14 10 Cordas Aço/viola3- verso.png",
                    "catálogo/violas_caipiras/3 Viola Acústica Caipira Giannini Start Vs-14 10 Cordas Aço/viola3- detalhes.png"
                ] },

            { id: 52, 
                category: "viola_caipira", 
                title: "Viola Eletroacustica Caipira Giannini Start Vs-14 Natural", 
                price: 654.80, 
                description: "Esta viola eletroacústica Giannini Start VS-14 é para destros, na cor natural, com acabamento envernizado. Possui 10 cordas de metal, tampo, fundo e laterais em Tília. Conta com equalizador e afinador integrados.", 
                image: "catálogo/violas_caipiras/4 Viola Eletroacustica Caipira Giannini Start Vs-14 Natural/viola4.png", 
                thumbnails: ["catálogo/violas_caipiras/4 Viola Eletroacustica Caipira Giannini Start Vs-14 Natural/viola4.png",
                    "catálogo/violas_caipiras/4 Viola Eletroacustica Caipira Giannini Start Vs-14 Natural/viola4- verso.png",
                    "catálogo/violas_caipiras/4 Viola Eletroacustica Caipira Giannini Start Vs-14 Natural/viola4- detalhes.png"
                ] },

            { id: 53, 
                category: "viola_caipira", 
                title: "Viola Caipira Acústica Rozini RV155.AC Clássica", 
                price: 1450.00, 
                description: "Esta é uma viola caipira acústica clássica Rozini, modelo RV155 AC.F.I, para destros, na cor natural. Possui 10 cordas e é feita de madeira Imbuia.", 
                image: "catálogo/violas_caipiras/5 Viola Caipira Acústica Rozini RV155.AC Clássica/viola5.png", 
                thumbnails: ["catálogo/violas_caipiras/5 Viola Caipira Acústica Rozini RV155.AC Clássica/viola5.png",
                    "catálogo/violas_caipiras/5 Viola Caipira Acústica Rozini RV155.AC Clássica/viola5- verso.png",
                    "catálogo/violas_caipiras/5 Viola Caipira Acústica Rozini RV155.AC Clássica/viola5- cravelhas.png",
                    "catálogo/violas_caipiras/5 Viola Caipira Acústica Rozini RV155.AC Clássica/viola5- frente.png"
                ] },

            { id: 54, 
                category: "viola_caipira", 
                title: "Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco", 
                price: 1330.57, 
                description: "Esta é uma viola caipira acústica Ponteio Rozini, modelo RV151.AC.F.I, com acabamento fosco. É feita de madeira Imbuia.", 
                image: "catálogo/violas_caipiras/6 Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco/viola6.png",
             thumbnails: ["catálogo/violas_caipiras/6 Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco/viola6.png",
                    "catálogo/violas_caipiras/6 Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco/viola6- verso.png",
                    "catálogo/violas_caipiras/6 Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco/viola6- cravelhas.png",
                    "catálogo/violas_caipiras/6 Viola Caipira Acústica Rozini RV151.AC.F.I Ponteio Fosco/viola6- detalhes.png"
                ] },

            { id: 55, 
                category: "viola_caipira", 
                title: "Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo", 
                price: 1502.70 , 
                description: "Esta é uma viola caipira elétrica ativa Ponteio Rozini, modelo RV151EG. É feita de madeira e acompanha capa luxo.", 
                image: "catálogo/violas_caipiras/7 Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo/viola7.png",
            thumbnails: ["catálogo/violas_caipiras/7 Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo/viola7.png",
                    "catálogo/violas_caipiras/7 Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo/viola7- completo.png",
                    "catálogo/violas_caipiras/7 Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo/viola7- verso.png",
                    "catálogo/violas_caipiras/7 Viola Caipira Ponteio Rozini Elétrica Ativa RV151 Capa Luxo/viola7- case.png"
                ] },

            { id: 56, 
                category: "viola_caipira", 
                title: "Viola Caipira Ponteio Acústica Marquês VIL-51", 
                price: 978.52, 
                description: "Esta é uma viola caipira acústica Ponteio Marquês, modelo VIL-51, para destros. Possui formato de corpo caipira, tampo e acabamento em Plywood, e diapasão em Rosewood.", 
                image: "catálogo/violas_caipiras/8 Viola Caipira Ponteio Acústica Marquês VIL-51/viola8.png",
            thumbnails: ["catálogo/violas_caipiras/8 Viola Caipira Ponteio Acústica Marquês VIL-51/viola8.png",
                    "catálogo/violas_caipiras/8 Viola Caipira Ponteio Acústica Marquês VIL-51/viola8- verso.png",
                   "catálogo/violas_caipiras/8 Viola Caipira Ponteio Acústica Marquês VIL-51/viola8- afinador.png",
                   "catálogo/violas_caipiras/8 Viola Caipira Ponteio Acústica Marquês VIL-51/viola8- cravelhas.png"
                ] },

            // Viola de arco (8 items)

             {
    id: 57,
    category: "viola_de_arco",
    title: "Viola De Arco Rolim Milor 40cm Serie Especial ",
    price: 2687.90,
    description: "A Viola de Arco Rolim Milor é um modelo acústico de 40 cm, para destros, com acabamento brilhante e 4 cordas. Inclui como acessórios: arco de crina genuína, breu e estojo.",
    image: "catálogo/violas/1 Viola De Arco Rolim Milor/viola1- frente e verso.png",
    thumbnails: [
      "catálogo/violas/1 Viola De Arco Rolim Milor/viola1- frente e verso.png",
      "catálogo/violas/1 Viola De Arco Rolim Milor/viola1-.png",
      "catálogo/violas/1 Viola De Arco Rolim Milor/viola1- case.png"
    ]
  },
  {
    id: 58,
    category: "viola_de_arco",
    title: "Viola Clássica de Arco Alan AL 1310 4/4",
    price: 647.00,
    description: "Esta viola clássica de arco Alan, tamanho 4/4, na cor madeira, possui dimensões de 66 x 23 x 4,5 cm. Seu tampo é revestido em Spruce, enquanto a traseira e as laterais são em Maple. Conta com cravelhas, queixeira e estandarte em Boxwood, escala em Maple, e 4 micro afinadores metálicos. Os filetes são entalhados, e o instrumento vem com um luxuoso estojo térmico, arco de crina sintética de 75 cm, breu e cavalete.",
    image: "catálogo/violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2.png",
    thumbnails: [
      "catálogo/violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2.png",
      "catálogo/violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2- completa.png",
      "catálogo/violas/2 Viola Clássica de Arco AL 1310 44 Alan Com Case Arco Breu Cavalete/viola2- case.png"
    ]
  },
  {
    id: 59,
    category: "viola_de_arco",
    title: "Viola de Arco Profissional Stradivarius",
    price: 5999.00,
    description: "A Viola de Arco Profissional Stradivarius, da marca 'Viola Chinesa Harmonizada', é um modelo acústico para destros.",
    image: "catálogo/violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- frente e verso.png",
    thumbnails: [
      "catálogo/violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- frente e verso.png",
      "catálogo/violas/3 Viola De Arco Profissional STRADIVARIUS/viola3- cavalete.jpg",
      "catálogo/violas/3 Viola De Arco Profissional STRADIVARIUS/viola3.png"
    ]
  },
  {
    id: 60,
    category: "viola_de_arco",
    title: "Viola de Arco 4/4 VA150 Envernizado EAGLE",
    price: 1279.00,
    description: "A Viola de Arco Eagle VA150 é um modelo 4/4 com dimensões de 13 x 31 x 86 cm. Possui tampo em Maple e parte traseira em Ébano e Maple, com acabamento envernizado.",
    image: "catálogo/violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- frente.png",
    thumbnails: [
      "catálogo/violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- frente.png",
      "catálogo/violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- verso.png",
      "catálogo/violas/4 Viola de Arco 44 VA150 Envernizado EAGLE/viola4- dentro da case.png"
    ]
  },
  {
    id: 61,
    category: "viola_de_arco",
    title: "Viola Clássica Envelhecida Alan AL 1310 3/4 E",
    price: 660.00,
    description: "A Viola Clássica Envelhecida Alan AL 1310 3/4 E possui acabamento marrom fosco envelhecido. Com dimensões de 88 x 36 x 16 cm, seu tampo é feito de Plywood e as cordas são de aço inoxidável.",
    image: "catálogo/violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- completa.png",
    thumbnails: [
      "catálogo/violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- completa.png",
      "catálogo/violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- verso.png",
      "catálogo/violas/5 Viola Clássica Envelhecida AL 1310 34 E Alan/viola5- inclinada.png"
    ]
  },
  {
    id: 62,
    category: "viola_de_arco",
    title: "Viola Antoni Marsale Série YA320 40,5cm 16",
    price: 2297.00,
    description: "A Viola Antoni Marsale série YA320, de 40,5 cm (16 polegadas), é feita de madeiras maciças (Acero e Abeto) e possui 4 cordas. É ajustada por luthier, vem com estandarte com micro afinador na corda Lá, e acompanha breu, estojo e arco.",
    image: "catálogo/violas/6 Viola Antoni Marsale série YA320/viola6- frente e verso.png",
    thumbnails: [
      "catálogo/violas/6 Viola Antoni Marsale série YA320/viola6- frente e verso.png",
      "catálogo/violas/6 Viola Antoni Marsale série YA320/viola6- voluta e cravelhas.png",
      "catálogo/violas/6 Viola Antoni Marsale série YA320/viola6- dentro da case.png"
    ]
  },
  {
    id: 63,
    category: "viola_de_arco",
    title: "Viola Antoni Marsale Série YA400 Stradivari 42 cm 16,5 Gold",
    price: 2997.00,
    description: "A Viola Antoni Marsale série YA400 Stradivari, de 42 cm (16,5 polegadas), é um instrumento indicado para violistas intermediários e avançados. Seu tampo é feito de Abeto, e o fundo e laterais em Acero de excelente seleção com marezzatura média. Os acessórios e o espelho são de Ébano. Acompanha case retangular e um lindo arco octogonal.",
    image: "catálogo/violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- frente e verso.png",
    thumbnails: [
      "catálogo/violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- frente e verso.png",
      "catálogo/violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- case.png",
      "catálogo/violas/7 Viola Antoni Marsale série YA400 Stradivari 42 cm/viola7- superior.png"
    ]
  },
  {
    id: 64,
    category: "viola_de_arco",
    title: "Viola de Arco Antoni Marsale Série YA110 40,5cm 16",
    price: 1397.00,
    description: "A Viola de Arco Antoni Marsale Série YA110, de 40,5 cm (16 polegadas), na cor laranja-claro, é um modelo acústico Stradivari para destros. Possui 4 cordas e acabamento brilhante.",
    image: "catálogo/violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- frente e verso.png",
    thumbnails: [
      "catálogo/violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- frente e verso.png",
      "catálogo/violas//8 Viola De Arco Antoni Marsale Série Ya110/viola8- voluta e cravelhas.png",
      "catálogo/violas/8 Viola De Arco Antoni Marsale Série Ya110/viola8- case.png"
    ]
  },

           

              // Violinos (8 items)
            { id: 65, category: "violino", title: "Violino Tarttan Série 100 Preto Brilho 4/4",
            price: 697.00,
            description: "Este violino Tarttan Série 100, importado da China, é um 4/4 com acabamento preto brilhante. Fabricado com madeira laminada, é ajustado por luthier e vem com estandarte de 4 micro afinadores. Inclui arco, breu e estojo preto.",
            image: "catálogo/violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png", thumbnails: ["catálogo/violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-removebg-preview.png",
            "catálogo/violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-verso.png",
            "catálogo/violinos/Violino Tarttan Série 100 Preto Brilho 4/4/violin1-case.png"] },

            { id: 66,
                category: "violino",
                title: "Violino Acústico 4/4",
                price: 299.00, description: "Este violino acústico 4/4 da marca Mix, na cor marrom, possui corpo em MDF tanto na parte superior quanto na traseira. Suas dimensões são 70 x 30 x 70 cm e vem completo com arco, breu, cavalete e um luxuoso estojo.",
                image: "catálogo/violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png", thumbnails: ["catálogo/violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2.png", "catálogo/violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- pessoas.jpg", "violinos/2 Violino Acústico 44 Arco Breu Cavalete Mdf Estojo Luxo/violino2- completo.png"] },

            { id: 67,
                category: "violino",
                title: "Violino Alan 4/4 Al-1410 Completo",
                price: 391.00,
                description: "O Violino Alan AL-1410 é um modelo 4/4 completo na cor Sunburst. Com tampo em Spruce (revestido), traseira e lateral em Maple, cravelhas, queixeira e estandarte em Boxwood, e escala em Maple. Inclui 4 micro afinadores, filetes entalhados, estojo térmico de luxo e arco de crina sintética de 75 cm. Suas dimensões são 60 x 21 x 4 cm.",
                image: "catálogo/violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png",
                thumbnails: ["catálogo/violinos/3 Violino Alan 44 Al-1410 Completo/violino3.png",
            "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- case.png",
            "violinos/3 Violino Alan 44 Al-1410 Completo/violino3- com case.png"] },

            { id: 68,
                category: "violino",
                title: "Violino Dominante 9649 3/4",
                price: 439.00,
                description: "Este violino acústico Dominante 9649, tamanho 3/4, apresenta acabamento brilhante na cor natural. Não é para canhotos. O corpo é feito de Spruce e o diapasão de Ébano. Acompanha arco e estojo.",
                image: "catálogo/violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png", thumbnails: ["catálogo/violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4.png",
            "catálogo/violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- dentro da case.png",
            "catálogo/violinos/4 Violino Dominante 9649 34 Natural Acabamento Brilhante/violino4- detalhes.jpg"] },

            { id: 69,
                category: "violino",
                title: "Violino Tarttan Série 100 Natural 4/4 com Case",
                price: 697.00,
                description: "O Violino Tarttan Série 100 da marca Xenox é um modelo 4/4 natural, com acabamento em verniz. Possui tampo de Ácer e parte traseira em madeira compensada. Acompanha case.",
                image: "catálogo/violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png", thumbnails: ["catálogo/violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- com case.png",
            "catálogo/violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- interior.jpg",
            "catálogo/violinos/5 Violino Tarttan Série 100 Natural 44 com Case/violino5- parte inferior.png"] },

            { id: 70,
                category: "violino",
                title: "Violino Eagle VE441 Classic Series 4/4",
                price: 1140.00,
                description: "O Violino Eagle VE441 Classic Series da marca TMZUAMOZ é um modelo 4/4 na cor natural. Possui tampo de Abeto. Suas dimensões são 80 x 30 x 20 cm.",
                image: "catálogo/violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png",
                thumbnails: ["catálogo/violinos/6 Violino Eagle VE441 Classic Series 44/violino6.png", "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- dentro da case.png", "violinos/6 Violino Eagle VE441 Classic Series 44/violino6- frente e verso.png"] },

            { id: 71,
                category: "violino",
                title: "Violino Vogga VON144N 4/4",
                price: 439.00,
                description: "O Violino Vogga VON144N é um modelo 4/4 na cor Natural Fosco. Suas dimensões são 80 x 26 x 11 cm e possui tampo em Spruce.",
                image: "catálogo/violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png", thumbnails: ["catálogo/violinos/7 VIOLINO VOGGA VON144N 44/violino7- completo.png",
                "catálogo/violinos/7 VIOLINO VOGGA VON144N 44/violino7- frente.png",
                "catálogo/violinos/7 VIOLINO VOGGA VON144N 44/violino7- verso.png"] },

            { id: 72,
                category: "violino",
                title: "Violino Vivace Strauss 4/4 Fosco",
                price: 1799.00,
                description: "O Violino Vivace Strauss é um modelo 4/4 com acabamento fosco. Possui tampo de Abeto e parte traseira de madeira de bordo. Acompanha case térmico.",
                image: "catálogo/violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png", thumbnails: ["catálogo/violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8.png",
                   "catálogo/violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- frente.png",
                   "catálogo/violinos/8 Violino Vivace Strauss 44 Fosco Com Case Térmico/violino8- verso.png"] },
           

             // violao
            { id: 73, 
                category: "violao", 
                title: "Violão clássico Phx camerata concertista i cedro natural", 
                price: 1825.00, 
                description: "Este violão clássico PHX Camerata Concertista I LCS-501NA é um modelo acústico de nylon de 6 cordas , para destros , na cor natural e com acabamento acetinado  (verniz brilhante no geral) . Possui tampo de Cedro , lateral e fundo em Rosewood , braço em Nato , escala e cavalete em Rosewood. As tarraxas são especiais luxo/douradas e o rastilho/pestana é de osso.", 
                image: "catálogo/violões/1 Violão clássico Phx camerata concertista i cedro natural/violao1.png", 
                thumbnails: ["catálogo/violões/1 Violão clássico Phx camerata concertista i cedro natural/violao1.png",
                    "catálogo/violões/1 Violão clássico Phx camerata concertista i cedro natural/violao1- detalhes.png"
                ] },

            { id: 74, 
                category: "violao", 
                title: "Violão Folk Elétrico Cutuway", 
                price: 1656.00, 
                description: "O violão folk eletroacústico PHX J. White AH-106NS-41 é um modelo de 6 cordas de aço , para destros , na cor marrom e com acabamento fosco. Possui corte , tampo em Spruce , fundo e laterais em Rosewood , e braço em Cedro Rosa.", 
                image: "catálogo/violões/2 Violão Folk Elétrico Cutuway/violao2.png", 
                thumbnails: ["catálogo/violões/2 Violão Folk Elétrico Cutuway/violao2.png",
                    "catálogo/violões/2 Violão Folk Elétrico Cutuway/violao2- verso.png",
                    "catálogo/violões/2 Violão Folk Elétrico Cutuway/violao2- afinadores.png",
                ] },

            { id: 75, 
                category: "violao", 
                title: "Violão Tagima Frontier", 
                price: 1668.00, 
                description: "Este violão eletroacústico Tagima Frontier EQ Ambience é para destros , de 6 cordas de aço , na cor marrom-claro e com acabamento fosco. Possui formato de corpo Jumbo com corte , tampo em Spruce Sólido , fundo e laterais em Sapele , e braço em Okoume (Shape C). Conta com conectores P10/P2 e acessórios como bateria recarregável e cabo USB tipo C.", 
                image: "catálogo/violões/3 Violão Tagima Frontier/violao3.png", 
                thumbnails: ["catálogo/violões/3 Violão Tagima Frontier/violao3.png",
                    "catálogo/violões/3 Violão Tagima Frontier/violao3- verso.png",
                    "catálogo/violões/3 Violão Tagima Frontier/violao3- afinadores.png",
                    "catálogo/violões/3 Violão Tagima Frontier/violao3- detalhes.png"
                ] },

            { id: 76, 
                category: "violao", 
                title: "Violão Eletroacústico 12 Cordas Giannini Performance D12 Dlx", 
                price: 1666.00, 
                description: "O Violão Eletroacústico Giannini Performance D12 DLX é um modelo de 12 cordas , para destros , na cor natural e com acabamento satin (fosco). Possui formato de corpo Dreadnought e tampo sólido. O material do diapasão é Bordo.", 
                image: "catálogo/violões/4 Violão Eletroacústico 12 Cordas Giannini Performance D12 Dlx/violao4.png", 
                thumbnails: ["catálogo/violões/4 Violão Eletroacústico 12 Cordas Giannini Performance D12 Dlx/violao4.png",
                    "catálogo/violões/4 Violão Eletroacústico 12 Cordas Giannini Performance D12 Dlx/violao4- case.png",
                    "catálogo/violões/4 Violão Eletroacústico 12 Cordas Giannini Performance D12 Dlx/violao4- afinadores.png"
                ] },

            { id: 77, 
                category: "violao", 
                title: "Violão acústico Strinberg SDB30", 
                price: 1663.00, 
                description: "Este violão acústico Strinberg SDB30 é para destros , de 6 cordas de metal , na cor sunburst e com acabamento em verniz brilhante. Possui formato de corpo OM , tampo em Abeto , fundo e laterais em Tilia , e braço em Nato. Conta com 20 trastes e ponte de Alumínio. É um violão ressonador com cone único aranha.", 
                image: "catálogo/violões/5 Violão acústico Strinberg SDB30/violao5.png", 
                thumbnails: ["catálogo/violões/5 Violão acústico Strinberg SDB30/violao5.png",
                    "catálogo/violões/5 Violão acústico Strinberg SDB30/violao5- verso.png",
                    "catálogo/violões/5 Violão acústico Strinberg SDB30/violao5- detalhes.png"
                ] },

            { id: 78, 
                category: "violao", 
                title: "Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat", 
                price: 1779.00, 
                description: "O violão eletroacústico Rozini RX515.RE2 da Linha Studio é para destros , de 6 cordas , na cor natural fosco. Possui formato de corpo Flat com corte , e tampo em Spruce Maciço. É um violão ressonador.", 
                image: "catálogo/violões/6 Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat/violao6.png", 
                thumbnails: ["catálogo/violões/6 Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat/violao6.png",
                    "catálogo/violões/6 Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat/violao6- verso.png",
                    "catálogo/violões/6 Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat/violao6- frente e verso.png",
                    "catálogo/violões/6 Violão Eletroacústico Rozini Rx515.re2 Ativo Studio Flat/violao6- detalhes.webp"
                ] },

            { id: 79, 
                category: "violao", 
                title: "Violão Elétrico Profissional Michael Elegance VME720", 
                price: 1614.05, 
                description: "Este é um violão elétrico profissional Michael Elegance, modelo VME720, com acabamento Open Pore e formato de corpo Mini Jumbo. Possui tampo de Spruce e conta com cutaway.", 
                image: "catálogo/violões/7 Violão Elétrico Profissional Michael Elegance VME720/violao7.png", 
                thumbnails: ["catálogo/violões/7 Violão Elétrico Profissional Michael Elegance VME720/violao7.png",
                    "catálogo/violões/7 Violão Elétrico Profissional Michael Elegance VME720/violao7- verso.png",
                    "catálogo/violões/7 Violão Elétrico Profissional Michael Elegance VME720/violao7- detalhes.png",
                    "catálogo/violões/7 Violão Elétrico Profissional Michael Elegance VME720/violao7- braço e cravelhas.png"
                ] },

            { id: 80, 
                category: "violao", 
                title: "Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural", 
                price: 5200.00, 
                description: "Este é um violão acústico Yamaha CSF-TA da linha CSF, no formato Parlor, para destros, na cor natural e com acabamento brilhante. Possui 6 cordas de metal (Elixir), tampo de Abeto, e fundo e laterais de Mogno. O braço é de Nato. É um violão ressonador e inclui gig bag.", 
                image: "catálogo/violões/8 Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural/violao8.png", 
                thumbnails: ["catálogo/violões/8 Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural/violao8.png",
                    "catálogo/violões/8 Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural/violao8- verso.png",
                    "catálogo/violões/8 Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural/violao8- case.png",
                    "catálogo/violões/8 Violão Yamaha CSF-TA Parlor TransAcoustic Aço C Gig Bag Cor Natural/violao8- cravelhas.png"
                ] },

          

            // Violoncelos (8 items)
            { id: 81,
                category: "violoncelo",
                title: "Violoncelo AL 1210 44 Alan Com Capa Arco Breu",
                price: 1500.00,
                description: "Este violoncelo Alan AL 1210 4/4, na cor marrom avermelhada, mede 123 x 46 x 14 cm. Possui tampo laminado em Spruce, traseira e laterais em Linden, e acabamento em verniz sintético. Conta com cravelhas em Maple, estandarte em Boxwood, 4 micro afinadores metálicos e filetes entalhados. Acompanha arco de crina sintética de 72 cm, capa e breu.",
                image: "catálogo/violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png",
                   thumbnails: ["catálogo/violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1.png",
                   "catálogo/violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- verso.png",
                   "catálogo/violoncelos/1 Violoncelo AL 1210 44 Alan Com Capa Arco Breu/violoncelo1- com case.png"] },

            { id: 82,
                category: "violoncelo",
                title: "Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu",
                price: 1836.10,
                description: "O Violoncelo Envelhecido Alan AL 1210 4/4 E apresenta um acabamento marrom fosco envelhecido. Suas dimensões aproximadas são 133 x 51 x 33 cm, com tampo em Plywood. Acompanha capa, arco e breu.",
                image: "catálogo/violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png",
                thumbnails: ["catálogo/violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2.png",
                "catálogo/violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- verso.png",
                "catálogo/violoncelos/2 Alan, Violoncelo Envelhecido AL 1210 44 E Alan Com Capa Arco Breu/violoncelo2- com case.png"] },

            { id: 83,
                category: "violoncelo",
                title: "VIOLONCELO VOGGA VOC144N 44",
                price: 2308.90,
                description: "O Violoncelo Vogga VOC144N é um modelo 4/4 na cor Natural Fosco. Suas dimensões são 140 x 33 x 52 cm e possui tampo em Abeto.",
                image: "catálogo/violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png",
                thumbnails: ["catálogo/violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3.png",
                "catálogo/violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- verso.png",
                "catálogo/violoncelos/3 VIOLONCELO VOGGA VOC144N 44/violoncelo3- case.png"] },

            { id: 84,
                category: "violoncelo",
                title: "Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello",
                price: 1900.00,
                description: "O Violoncelo Vivace CMO44 Mozart, tamanho 4/4, na cor natural, possui acabamento brilhante. Com dimensões de 14 x 24 x 68 cm, seu tampo é em Spruce Plywood, corpo em Maple Plywood, espelho e cravelhas em Hardwood, e braço em Maple. O estandarte é de Hardwood. Acompanha BAG, arco de Rosewood com crina animal e breu.",
                image: "catálogo/violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png",
                thumbnails: ["catálogo/violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4.png",
                "catálogo/violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- cravelhas.png",
                "catálogo/violoncelos/4 Violoncelo Vivace 44 Cmo44 Mozart Cello Violoncello/violoncelo4- parte superior.png"] },

            { id: 85,
                category: "violoncelo",
                title: "Violoncelo Cello Dasons Acabamento Brilho",
                price: 1744.95,
                description: "O Violoncelo Dasons CP105H está disponível nos tamanhos 3/4 e 4/4, com acabamento brilho. Possui corpo em Plywood, caixa das cravelhas e braço em Hardwood. Inclui arco, resina e afinadores finos, mas não acompanha estojo.",
                image: "catálogo/violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png",
                thumbnails: ["catálogo/violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5.png",
                "catálogo/violoncelos/5 Violoncelo Cello Dasons Acabamento Brilho/violoncelo5- aaaa.png"] },

            { id: 86,
                category: "violoncelo",
                title: "Violoncelo Tarttan Série 100 Preto 4/4",
                price: 2297.00,
                description: "O Violoncelo Tarttan Série 100 é um modelo 4/4 na cor preta. Possui corpo em Plywood, caixa das cravelhas e braço em Ébano. Inclui estojo, arco e afinadores finos, mas não vem com resina.",
                image: "catálogo/violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png",
                thumbnails: ["catálogo/violoncelos/6 Violoncelo Tarttan Série 100 Preto 44/violoncelo6.png"] },

            {id: 87,
    category: "violoncelo",
    title: "Violoncelo Dasons Com Com Arco Capa E Breu",
    price: 1738.45,
    description: "Este Violoncelo Dasons modelo CG001L possui corpo feito de Hardwood. Ele vem completo com arco, capa e breu.",
    image: "catálogo/violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7.png",
    thumbnails: [
      "catálogo/violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7.png",
      "catálogo/violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7- verso.png",
      "catálogo/violoncelos/7 Violoncelo Dasons Com Com Arco Capa E Breu/violoncelo7- case.png"
    ]
  },

  {
    id: 88,
    category: "violoncelo",
    title: "Violoncelo Michael VOM40 4/4 Tradicional",
    price: 3394.70,
    description: "O Violoncelo Michael VOM40 é um modelo 4/4 completo com acabamento tradicional. É ideal para músicos avançados.",
    image: "catálogo/violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo.png",
    thumbnails: [
      "catálogo/violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo.png",
      "catálogo/violoncelos/8 Violoncelo Michael VOM40 44 Tradicional//violoncelo8- cravelhas.png",
      "catálogo/violoncelos/8 Violoncelo Michael VOM40 44 Tradicional/violoncelo8- case.png"
    ]
  }];

        // ===== INICIALIZAR QUANDO A PÁGINA CARREGAR =====
        document.addEventListener('DOMContentLoaded', function() {
            carregarProdutosDoBanco();
        });

        // ===== FILTRAR PRODUTOS =====
        
        //funções do carrinho

        // atualiza a contagem total de itens no ícone do carrinho
        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById("cart-count").textContent = totalItems;
        }

        // formata o preço para o padrão brasileiro (R$X.XX)
        function formatPrice(price) {
            return `R$${price.toFixed(2).replace('.', ',')}`;
        }

        // calcula e atualiza o valor total do carrinho e do modal de pix
        function calculateCartTotal() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById("carrinho-total-valor").textContent = formatPrice(total);
            // atualiza o valor também no modal de pix, se estiver visível
            if (document.getElementById("pix-total-valor")) {
                document.getElementById("pix-total-valor").textContent = formatPrice(total);
            }
            return total;
        }

        // salva o estado atual do carrinho no Local Storage do navegador
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        // renderiza (desenha) todos os itens no carrinho lateral
        function renderCartItems() {
            const carrinhoItemsList = document.getElementById("carrinho-items");
            carrinhoItemsList.innerHTML = ""; // limpa itens existentes

            if (cart.length === 0) {
                carrinhoItemsList.innerHTML = '<li style="text-align: center; color: #888; padding: 20px;">Seu carrinho está vazio.</li>';
            } else {
                cart.forEach(item => {
                    const listItem = document.createElement("li");
                    listItem.classList.add("carrinho-item");
                    listItem.innerHTML = `
                        <img src="${item.image}" alt="${item.title}">
                        <div class="carrinho-info">
                            <h4>${item.title}</h4>
                            <p>${formatPrice(item.price)}</p>
                            <div class="carrinho-quantidade">
                                <button onclick="updateQuantity(${item.id}, -1)">-</button>
                                <span>${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)">+</button>
                                <button style="background-color: #f44336; color: white;"onclick="removeItemFromCart(${item.id})">Remover</button>
                            </div>
                        </div>
                    `;
                    carrinhoItemsList.appendChild(listItem);
                });
            }
            updateCartCount();
            calculateCartTotal();
        }

        // adiciona um item ao carrinho ou incrementa sua quantidade se já existir
        function addItemToCart(productId, quantity = 1) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ ...product, quantity });
            }
            saveCart();
            renderCartItems(); // renderiza para atualizar a lista no carrinho lateral
            alert(`${product.title} adicionado ao carrinho!`);
        }

        // adiciona o produto selecionado no modal de detalhes ao carrinho
        function addItemToCartFromModal() {
           
            if (selectedProduct) {
                addItemToCart(selectedProduct.id, 1);
                fecharModalDetalhes();
            }
        }

        // atualiza a quantidade de um item específico no carrinho
        function updateQuantity(productId, change) {
            const item = cart.find(i => i.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    // se a quantidade chegar a zero ou menos, remove o item
                    removeItemFromCart(productId);
                } else {
                    saveCart();
                    renderCartItems(); // enderiza para mostrar a nova quantidade e total
                }
            }
        }

        // remove um item completamente do carrinho
        function removeItemFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            saveCart();
            renderCartItems(); // Re-renderiza para remover o item da lista
        }

        // limpa todos os itens do carrinho
        function clearCart() {
            if (confirm("Tem certeza que deseja limpar o carrinho?")) {
                cart = [];
                saveCart(); //sSalva o carrinho vazio
                renderCartItems(); //renderiza para mostrar o carrinho vazio
                alert("Carrinho limpo!");
            }
        }

        // abre ou fecha o carrinho lateral
        function toggleCarrinho() {
            const carrinhoLateral = document.getElementById('carrinhoLateral');
            if (carrinhoLateral) {
                carrinhoLateral.classList.toggle('ativo');
                // se o carrinho estiver ativo, renderiza os itens
                if (carrinhoLateral.classList.contains('ativo')) {
                    renderCartItems();
                }
            }
        }
        // funções de finalização de compra (pix) 
function calculateCartTotal() {
    // soma o preço de cada item multiplicado pela sua quantidade.
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    // atualiza o valor no carrinho lateral, se o elemento existir.
    const carrinhoTotalElement = document.getElementById("carrinho-total-valor");
    if (carrinhoTotalElement) {
        carrinhoTotalElement.textContent = formatPrice(total);
    }
    
    // retorna o valor total para ser usado em outras funções.
    // o valor do modal do pix será atualizado separadamente.
    return total;
}




const PIX_KEY = "lojamusicwave@gmail.com";

function finalizarCompraPix() {
    // calcula o valor total do carrinho e armazena na variável 'total'.
    const total = calculateCartTotal();
    if (total === 0) {
        alert("Seu carrinho está vazio. Adicione itens antes de finalizar a compra.");
        return;
    }

    // atualiza o valor no modal do pix explicitamente ANTES de limpar o carrinho.
    document.getElementById("pix-total-valor").textContent = formatPrice(total);

    // usa uma imagem genérica de QR Code, conforme solicitado.
    document.getElementById("pix-qr-code-img").src = "img/qr_code.png"; 
    
    // exibe o modal adicionando a classe 'ativo'.
    document.getElementById("modalPixPagamento").classList.add("ativo");
    
    //lLimpa o carrinho após "finalizar" a compra (simulado).
    clearCart(); 

    // fecha o carrinho lateral, se a função 'toggleCarrinho' estiver definida.
    if (typeof toggleCarrinho === 'function') {
        toggleCarrinho(); 
    }
}

/**
 * 
 */
function fecharModalPix() {
    document.getElementById("modalPixPagamento").classList.remove("ativo");
}

/**
 * 
 * função utilitária para obter os parâmetros da URL.
 * adicionada conforme seu código de referência.
 */
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || "");
    });
    return params;
}


/**
 *
 * função utilitária para obter os parâmetros da url.
 * adicionada conforme seu código de referência.
 */
function getQueryParams() {
    const params = {};
    window.location.search.substring(1).split("&").forEach(param => {
        const [key, value] = param.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || "");
    });
    return params;
}


        //  funções de utilitário e inicialização

        // pega os parâmetros da url (usado para filtros de categoria/pesquisa)
        function getQueryParams() {
            const params = {};
            window.location.search.substring(1).split("&").forEach(param => {
                const [key, value] = param.split("=");
                params[decodeURIComponent(key)] = decodeURIComponent(value || "");
            });
            return params;
        }

        // renderiza os produtos na página principal (filtrados e paginados)
        function renderProducts() {
            productListDiv.innerHTML = ''; // limpa o conteúdo existente

            let filteredProducts = products;

            if (currentCategory !== 'all') {
                filteredProducts = filteredProducts.filter(p => p.category === currentCategory);
            }

            if (currentSearchQuery) {
                const query = currentSearchQuery.toLowerCase();
                filteredProducts = filteredProducts.filter(p =>
                    p.title.toLowerCase().includes(query) ||
                    p.description.toLowerCase().includes(query)
                );
            }

            const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;
            const paginatedProducts = filteredProducts.slice(start, end);

            if (paginatedProducts.length === 0) {
                productListDiv.innerHTML = '<p style="text-align: center; width: 100%; padding: 50px;">Nenhum produto encontrado para a sua busca ou categoria.</p>';
            } else {
                paginatedProducts.forEach(product => {
                    const productCard = document.createElement("div");
                    productCard.classList.add("instrumento-card");

                    productCard.innerHTML = `
                        <div class="card-image-container">
                            <img src="${product.image}" alt="${product.title}" />
                        </div>
                        <h4>${product.title}</h4>
                        <div class="rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <p>${formatPrice(product.price)}</p>
                        <button class="btn-ver-detalhes" data-product-id="${product.id}">Ver Detalhes</button>
                    `;
                    productListDiv.appendChild(productCard);

                    const viewDetailsButton = productCard.querySelector('.btn-ver-detalhes');
                    if (viewDetailsButton) {
                        viewDetailsButton.addEventListener('click', () => {
                            showProductDetails(parseInt(viewDetailsButton.dataset.productId));
                        });
                    }

                    const cardElementsForDetails = productCard.querySelectorAll('img, h4');
                    cardElementsForDetails.forEach(el => {
                        el.addEventListener('click', () => showProductDetails(product.id));
                    });
                });
            }

            document.getElementById('page-info').textContent = `Página ${paginatedProducts.length > 0 ? currentPage : 0} de ${totalPages}`;
            document.getElementById('prev-page-btn').disabled = currentPage === 1 || paginatedProducts.length === 0;
            document.getElementById('next-page-btn').disabled = currentPage === totalPages || paginatedProducts.length === 0;

            const categoryTitle = document.getElementById('current-category-title');
            if (categoryTitle) {
                if (currentCategory === 'all') {
                    categoryTitle.textContent = currentSearchQuery ? `Resultados para "${currentSearchQuery}"` : 'Instrumentos';
                } else {
                    categoryTitle.textContent = currentCategory.charAt(0).toUpperCase() + currentCategory.slice(1);
                }
            }
        }

        // filtra os produtos com base na categoria ou busca
        function filterProducts() {
            currentPage = 1;
            renderProducts();
        }

        // configura o filtro de categorias
        function setupCategoryFilter() {
            const categoryFilter = document.getElementById('category-filter');
            
            const categories = ['all', ...new Set(products.map(p => p.category))];

            if (categoryFilter) {
                categoryFilter.innerHTML = '';

                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category;
                    option.textContent = category === 'all' ? 'Todas as Categorias' : category.charAt(0).toUpperCase() + category.slice(1);
                    categoryFilter.appendChild(option);
                });

                categoryFilter.value = currentCategory;
                categoryFilter.addEventListener('change', (event) => {
                    currentCategory = event.target.value;
                    currentSearchQuery = '';
                    if (searchInput) searchInput.value = '';
                    hideSuggestions();
                    filterProducts();
                });
            }
        }

        // configura a paginação
        function setupPagination() {
            document.getElementById('prev-page-btn').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderProducts();
                }
            });

            document.getElementById('next-page-btn').addEventListener('click', () => {
                let productsToCount = products;
                if (currentCategory !== 'all') {
                    productsToCount = productsToCount.filter(p => p.category === currentCategory);
                }
                if (currentSearchQuery) {
                    const query = currentSearchQuery.toLowerCase();
                    productsToCount = productsToCount.filter(p =>
                        p.title.toLowerCase().includes(query) ||
                        p.description.toLowerCase().includes(query)
                    );
                }
                const totalPages = Math.ceil(productsToCount.length / productsPerPage);

                if (currentPage < totalPages) {
                    currentPage++;
                    renderProducts();
                }
            });
        }

        let selectedProduct = null; // variável para armazenar o produto selecionado para o modal de detalhes

        // exibe o modal de detalhes do produto
        function showProductDetails(productId) {
         
            selectedProduct = products.find(p => p.id === productId);
            if (!selectedProduct) return;

            const modal = document.getElementById('modalDetalhesProduto');
            document.getElementById('modal-titulo').textContent = selectedProduct.title;
            document.getElementById('modal-preco').textContent = formatPrice(selectedProduct.price);
            document.getElementById('modal-descricao').textContent = selectedProduct.description;
            document.getElementById('modal-imagem-principal').src = selectedProduct.image;
            modal.dataset.productId = selectedProduct.id; // armazena o id no dataset do modal

            const thumbnailsContainer = document.getElementById('modal-thumbnails');
            thumbnailsContainer.innerHTML = '';
            if (selectedProduct.thumbnails && selectedProduct.thumbnails.length > 0) {
                selectedProduct.thumbnails.forEach(thumbnail => {
                    const img = document.createElement('img');
                    img.src = thumbnail;
                    img.alt = selectedProduct.title;
                    img.classList.add('thumbnail-image');
                    img.onclick = () => document.getElementById('modal-imagem-principal').src = thumbnail;
                    thumbnailsContainer.appendChild(img);
                });
            } else {
                
                const img = document.createElement('img');
                img.src = selectedProduct.image;
                img.alt = selectedProduct.title;
                img.classList.add('thumbnail-image');
                img.onclick = () => document.getElementById('modal-imagem-principal').src = selectedProduct.image;
                thumbnailsContainer.appendChild(img);
            }

            modal.style.display = 'flex'; // exibe o modal
        }

        // fecha o modal de detalhes do produto
        function fecharModalDetalhes() {
            document.getElementById('modalDetalhesProduto').style.display = 'none';
            selectedProduct = null; // limpa o produto selecionado
        }

        // exibe as sugestões de busca
        function showSuggestions(query) {
            if (!searchInput || !searchSuggestions) return;
            searchSuggestions.innerHTML = '';
            if (!query) {
                hideSuggestions();
                return;
            }

            const lowerQuery = query.toLowerCase();
            const filteredSuggestions = searchSuggestionsList.filter(s => s.includes(lowerQuery));

            if (filteredSuggestions.length > 0) {
                filteredSuggestions.forEach(s => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.classList.add('suggestion-item');
                    suggestionItem.textContent = s.charAt(0).toUpperCase() + s.slice(1);
                    suggestionItem.addEventListener('click', () => {
                        searchInput.value = s.charAt(0).toUpperCase() + s.slice(1);
                        applySearchFilter(s);
                        hideSuggestions();
                    });
                    searchSuggestions.appendChild(suggestionItem);
                });
                searchSuggestions.style.display = 'block';
            } else {
                hideSuggestions();
            }
        }

        // esconde as sugestões de busca
        function hideSuggestions() {
            if (searchSuggestions) searchSuggestions.style.display = 'none';
        }

        // aplica o filtro de busca ou categoria
        function applySearchFilter(query) {
            const normalizedQuery = query.toLowerCase();
            const isCategory = allCategories.includes(normalizedQuery);

            if (isCategory) {
                currentCategory = normalizedQuery;
                currentSearchQuery = '';
            } else {
                currentCategory = 'all';
                currentSearchQuery = query;
            }
            currentPage = 1;
            setupCategoryFilter(); // atualiza o seletor de categoria
            renderProducts();
        }

        // event Listeners para a barra de busca
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                showSuggestions(searchInput.value.trim());
            });

            searchInput.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    applySearchFilter(searchInput.value.trim());
                    hideSuggestions();
                }
            });

            document.addEventListener('click', (event) => {
                if (searchInput && searchSuggestions && !searchInput.contains(event.target) && !searchSuggestions.contains(event.target)) {
                    hideSuggestions();
                }
            });
        }

        // inicialização quando o DOM estiver completamente carregado
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
            calculateCartTotal(); // calcula o total inicial do carrinho

            const params = getQueryParams();
            if (params.categoria) {
                const categoryFromURL = decodeURIComponent(params.categoria).toLowerCase();
                if (allCategories.includes(categoryFromURL)) {
                    currentCategory = categoryFromURL;
                    if (searchInput) {
                        searchInput.value = categoryFromURL.charAt(0).toUpperCase() + categoryFromURL.slice(1);
                    }
                }
            } else if (params.pesquisa) {
                currentSearchQuery = decodeURIComponent(params.pesquisa);
                if (searchInput) {
                        searchInput.value = currentSearchQuery;
                }
            }

            setupCategoryFilter();
            setupPagination();
            renderProducts();
        });

        // catálogo dos instrumentos + carrinho + modal de produtos e modal do pix + filtragem por categoria papaizinho

        // Função para logout
        async function logout() {
            if (confirm('Tem certeza que deseja sair?')) {
                try {
                    const response = await fetch('../APP/controller/LogoutController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'acao=logout'
                    });
                    
                    const data = await response.json();
                    
                    if (data.sucesso) {
                        alert('Logout realizado com sucesso!');
                        window.location.href = 'index.php';
                    } else {
                        alert('Erro ao fazer logout: ' + data.mensagem);
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro de comunicação com o servidor');
                }
            }
        }


</script>

     <footer>
        <span class="footer-title">MusicWave</span>
        <ul class="socials">
            <li><a href="#"><i class="bi bi-whatsapp"></i></a></li>
            <li><a href=""><i class="bi bi-envelope-fill"></i></a></li>
            <li><a href="#"><i class="bi bi-linkedin"></i></a></li>
            <li><a href="https://www.instagram.com/elliscarv/"><i class="bi bi-instagram"></i></a></li>
        </ul>
        <div class="info">
            <ul>
                <li class="footer-list_header">Oferece</li>
                <li><a href="#">Produtos</a></li>
                <li><a href="#">Serviços</a></li>
                <li><a href="#">Categorias</a></li>
                <li><a href="#">Contato</a></li>
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


</body>
</html>
   

</body>
</html>