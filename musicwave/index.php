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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="styles.css">
   <link rel="shortcut icon" href="img/mw..png" type="image/x-icon">
  <title>HOME</title>
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

<?php if (!$usuario_logado): ?>
    <!-- Usuário não logado -->
    <button class="bubbles">
        <span class="text"><a href="view/login-usuario.php" style="color: inherit; text-decoration: none;">Entrar</a></span>
    </button>
    <button class="bubbles" style="background: #b45f06;">
        <span class="text"><a href="view/cadastro-usuario.php" style="color: white; text-decoration: none;">Cadastrar</a></span>
    </button>
<?php endif; ?>
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

  <main>

    <!-- slideshow -->

    <div class="slideshow-wrapper">
  <div class="slideshow-container">
    <img src="img/1.png" class="slide active" />
    <img src="img/2.png" class="slide" />
    <img src="img/3.png" class="slide" />
    <img src="img/4.png" class="slide" />
    <img src="img/5.png" class="slide" />

    <!-- Setas de navegação -->
    <a class="prev">&#10094;</a>
    <a class="next">&#10095;</a>
  </div>
</div>
   
  <!-- slideshow -->


    <!-- jogos em destaque -->

     <section class="jogos-destacados"><br>
      <h2>Aqui terá cards promocionais...</h2> <br><br>
      <div class="cards">
        <div class="card">
          <img src="img/peter.png" alt="">
        </div>
        <div class="card">
          <img src="img/peter.png" alt="">
        </div>
        <div class="card">
          <img src="img/peter.png" alt="">
        </div>
        <div class="card">
          <img src="img/peter.png" alt="">
        </div>
      </div>
    </section>

     <!-- jogos em destaque -->


    <!-- instrumentos em destaque --> 

    <section class="jogos-destacados">
  <h2><i class="bi bi-music-note-beamed" style="font-size: 30px"></i> INSTRUMENTOS EM DESTAQUE</h2>
  <div class="small-container-instrumentos">
    <div class="row-instrumentoss"> 

        <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/guitarra1.png" alt="Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue">
            </div>
            <h4>Guitarra elétrica Strinberg STS Series STS100 Stratocaster Metallic Blue</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$757,00</p>
        </div>

        <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/ukulele2.png" alt="Ukulele Concert Bahardan">
            </div>
            <h4>Ukulele Concert Bahardan</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$2.308,90</p>
        </div>

        <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/bandolim3.png" alt="Bandolim Marquês Bnd-100 Nb Acústico">
            </div>
            <h4>Bandolim Marquês Bnd-100 Nb Acústico</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$975,00</p>
        </div>

        <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/viola4.png" alt="Viola De Arco Rolim Milor">
            </div>
            <h4>Viola De Arco Rolim Milor</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$2.687,90</p>
        </div>

        <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/banjo5.png" alt="Banjo Americano Wb50 - Strinberg">
            </div>
            <h4>Banjo Americano Wb50 - Strinberg</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$1.756,87</p>
        </div>

       <div class="instrumento-card-home">
            <div class="card-image-container-home">
                <img src="instrumentos_em_destaque/violin6.png" alt="Violino Tarttan Série 100 Preto Brilho 4/4">
            </div>
            <h4>Violino Tarttan Série 100 Preto Brilho 4/4</h4>
            <div class="rating">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
            </div>
            <p>R$697,00</p>
        </div>
        

    </div>
</div>
</section>


<!-- instrumentos em destaque -->        


<!-- seção de apresentar o afinador -->

<div class="afinador">
  <div class="small-container">
    <div class="row">
      <div class="col-2">
        <img src="img/mw_afinador.png" class="afinador-img" alt="Afinador MusicWave">
      </div>
      <div class="col-2">
        <p>Ferramenta exclusiva da MusicWave</p>
        <h1>Afinador On-line</h1>
        <p>Descubra a harmonia perfeita com o afinador online exclusivo da MusicWave! Ele é a ferramenta ideal para garantir que cada instrumento do nosso catálogo — seja um violão, ukulele, baixo ou cavaquinho — soe impecável. Afine seu instrumento de forma rápida e precisa, e mergulhe na música sem preocupações.</p> <br><br>
       
        <a href="#" class="btn-laranja" onclick="abrirAfinador()">Afine seu instrumento agora &#8594;</a>

      </div>
    </div>
  </div>
</div>

<!-- seção de apresentar o afinador -->


<!-- feedbacks -->
 <section class="opinioes">
  <div class="feedbacks">
     <h2><i class="bi bi-chat-dots" style="font-size: 30px"></i> DEIXE SEU FEEDBACK AO MERGULHAR NA MUSICWAVE!</h2><br>
     <section class="feedback-section">
  <form class="feedback-form">
    <label for="comentario">Conte-nos o que achou do nosso E-commerce:</label>
    <textarea id="comentario" name="comentario" rows="4" placeholder="Compartilhe sua experiência..."></textarea>
    <button type="submit">Enviar</button>
  </form>
</section>

    <div class="small-container">
      <div class="row">
        <div class="col-3">
          <i class="bi bi-quote"></i>
          <p>A MusicWave transformou minha experiência musical! O afinador é incrível e os jogos são super divertidos!</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
          <img src="img/panqueca.png" alt="sasa">
          <h3>Sabrina Santana</h3>
        </div>

        <div class="col-3">
          <i class="bi bi-quote"></i>
          <p>Adoro a variedade de instrumentos disponíveis. O site é fácil de navegar e sempre encontro o que preciso.</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
          <img src="img/panqueca.png" alt="andson">
          <h3>Vinícius Pires</h3>
        </div>

        <div class="col-3">
          <i class="bi bi-quote"></i>
          <p>Os jogos são uma ótima maneira de aprender música enquanto me divirto. Recomendo para todos!</p>
          <div class="rating">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
          </div>
          <img src="img/panqueca.png" alt="unnu">
          <h3>Unnu Lívio Panquecudo</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<br>
<!-- feedbacks -->


  </main>


 
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


       
<script>
    // --- Variáveis para a Busca na Barra de Navegação ---
    // Lista de categorias para o filtro de busca.
    const allCategories = ["violino", "guitarra", "violoncelo", "violao", "banjo", "baixo", "cavaquinho", "ukulele", "viola caipira", "viola de arco", "bandolim"];

    // Sugestões para o autocompletar da barra de busca.
    const searchSuggestionsList = [
        ...allCategories,
        "baixo",
            "bandolim",
            "banjo",
            "guitarra elétrica",
            "ukulele",   
            "viola caipira",
            "viola de arco",
             "violão",
            "violão nylon",
            "violino acústico",
            "violino",
            "violoncelo",
             "violoncelo vogga",
           
        ].map(s => s.toLowerCase());

    // --- Funções da Barra de Navegação e Busca ---

    /**
     * @function showSuggestions
     * Exibe as sugestões de busca com base na entrada do usuário.
     * @param {string} query O texto digitado na barra de busca.
     */
    function showSuggestions(query) {
        const searchInput = document.querySelector('header input[type="text"]');
        const searchSuggestions = document.getElementById('search-suggestions');
        
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
                    const categoryParam = allCategories.includes(s) ? `?categoria=${encodeURIComponent(s)}` : `?pesquisa=${encodeURIComponent(s)}`;
                    window.location.href = `loja.php${categoryParam}`; 
                });
                searchSuggestions.appendChild(suggestionItem);
            });
            searchSuggestions.style.display = 'block';
        } else {
            hideSuggestions();
        }
    }

    /**
     * @function hideSuggestions
     * Esconde a caixa de sugestões de busca.
     */
    function hideSuggestions() {
        const searchSuggestions = document.getElementById('search-suggestions');
        if (searchSuggestions) searchSuggestions.style.display = 'none';
    }

    // --- Event Listeners Globais para a Barra de Navegação ---
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('header input[type="text"]');
        const searchSuggestions = document.getElementById('search-suggestions');
        
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                showSuggestions(searchInput.value.trim());
            });

            searchInput.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    const query = searchInput.value.trim().toLowerCase();
                    const categoryParam = allCategories.includes(query) ? `?categoria=${encodeURIComponent(query)}` : `?pesquisa=${encodeURIComponent(query)}`;
                    window.location.href = `loja.php${categoryParam}`; 
                }
            });

            document.addEventListener('click', (event) => {
                if (searchInput && searchSuggestions && !searchInput.contains(event.target) && !searchSuggestions.contains(event.target)) {
                    hideSuggestions();
                }
            });
        }
    });
</script>


<script src="script.js"></script>


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

<script>
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
                    window.location.reload();
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

</body>
</html>