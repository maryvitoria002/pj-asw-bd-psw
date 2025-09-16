<?php
require_once '../APP/sessao.php';

// Redirecionar para login se não estiver logado
requererLogin('perfil.php');

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
  <title>Perfil - MusicWave</title>

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
        <a href="../admin/login-admin.php" title="Área Administrativa"><i class="bi bi-gear-fill" style="color: #f7bd6d; font-size: 30px"></i></a>
        <a href="#" onclick="logout()" title="Sair"><i class="bi bi-box-arrow-right" style="color: #d63384; font-size: 30px"></i></a>
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

 <!-- formuláriozinho -->

  <main>
  <section class="user-profile">
    <div class="profile-container">
      <div class="profile-header">
        <h2>👤 Meu Perfil</h2>
        <p>Olá, <?php echo htmlspecialchars(saudacaoUsuario()); ?>! Aqui estão suas informações:</p>
      </div>

      <div class="profile-content">
        <div class="profile-card">
          <div class="avatar-section">
            <div class="avatar-container">
              <img src="img/aaaaa.jpg" alt="Avatar" class="avatar" id="preview-avatar">
              <label for="foto-perfil" class="foto-label">📷 Alterar Foto</label>
              <input type="file" id="foto-perfil" accept="image/*" style="display: none;">
            </div>
          </div>

          <div class="profile-info">
            <div class="info-group">
              <label>📧 Email:</label>
              <span class="info-value"><?php echo htmlspecialchars($dados_usuario['email'] ?? 'Não informado'); ?></span>
            </div>

            <div class="info-group">
              <label>📱 CPF:</label>
              <span class="info-value"><?php echo htmlspecialchars($dados_usuario['cpf'] ?? 'Não informado'); ?></span>
            </div>

            <div class="info-group">
              <label>👤 Nome Completo:</label>
              <span class="info-value"><?php echo htmlspecialchars($dados_usuario['nome'] ?? 'Não informado'); ?></span>
            </div>

            <div class="info-group">
              <label>⏰ Status:</label>
              <span class="info-value status-online">🟢 Online</span>
            </div>
          </div>

          <div class="profile-actions">
            <button type="button" class="btn-edit" onclick="editarPerfil()">✏️ Editar Perfil</button>
            <button type="button" class="btn-history" onclick="verHistorico()">📋 Histórico de Compras</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

   <!-- formuláriozinho -->

   <!-- Modal de Edição de Perfil -->
   <div id="modalEditarPerfil" class="modal-editar-perfil">
       <div class="modal-content">
           <div class="modal-header">
               <h3>✏️ Editar Perfil</h3>
               <span class="modal-close" onclick="fecharModalEditar()">&times;</span>
           </div>
           <form id="formEditarPerfil">
               <div class="modal-body">
                   <div class="form-group">
                       <label for="edit-nome">👤 Nome Completo:</label>
                       <input type="text" id="edit-nome" name="nome" value="<?php echo htmlspecialchars($dados_usuario['nome'] ?? ''); ?>" required>
                   </div>
                   
                   <div class="form-group">
                       <label for="edit-email">📧 Email:</label>
                       <input type="email" id="edit-email" name="email" value="<?php echo htmlspecialchars($dados_usuario['email'] ?? ''); ?>" required>
                   </div>
                   
                   <div class="form-group">
                       <label for="edit-cpf">📱 CPF:</label>
                       <input type="text" id="edit-cpf" name="cpf" value="<?php echo htmlspecialchars($dados_usuario['cpf'] ?? ''); ?>" readonly>
                       <small>CPF não pode ser alterado</small>
                   </div>
                   
                   <div class="form-group">
                       <label for="edit-senha">🔒 Nova Senha (opcional):</label>
                       <input type="password" id="edit-senha" name="senha" placeholder="Deixe em branco para manter a atual">
                   </div>
                   
                   <div class="form-group">
                       <label for="edit-confirmar-senha">🔒 Confirmar Nova Senha:</label>
                       <input type="password" id="edit-confirmar-senha" name="confirmar_senha" placeholder="Confirme a nova senha">
                   </div>
               </div>
               
               <div class="modal-footer">
                   <button type="button" class="btn-cancel" onclick="fecharModalEditar()">Cancelar</button>
                   <button type="submit" class="btn-save">💾 Salvar Alterações</button>
               </div>
           </form>
       </div>
   </div>

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

    // Funções do perfil
    function editarPerfil() {
        alert('🚧 Funcionalidade em desenvolvimento!\nEm breve você poderá editar seu perfil.');
    }

    function verHistorico() {
        window.location.href = 'historico.php';
    }

    // Preview da foto de perfil
    document.getElementById('foto-perfil').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-avatar').src = e.target.result;
            };
            reader.readAsDataURL(file);
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

<style>
/* Modal de Edição de Perfil */
.modal-editar-perfil {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: #fdfaf5;
    margin: 5% auto;
    padding: 0;
    border: 2px solid #f7bd6d;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-header {
    background: linear-gradient(135deg, #f7bd6d, #d4910a);
    color: white;
    padding: 20px;
    border-radius: 13px 13px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
}

.modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-body {
    padding: 25px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 500;
    font-size: 0.95rem;
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #f7bd6d;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus {
    outline: none;
    border-color: #d4910a;
    box-shadow: 0 0 0 3px rgba(247, 189, 109, 0.2);
    background: #fdfaf5;
}

.form-group input[readonly] {
    background: #f8f9fa;
    color: #6c757d;
    cursor: not-allowed;
}

.form-group small {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 5px;
    display: block;
}

.modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #f7bd6d;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-cancel, .btn-save {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-1px);
}

.btn-save {
    background: linear-gradient(135deg, #f7bd6d, #d4910a);
    color: white;
}

.btn-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 15px rgba(247, 189, 109, 0.4);
}

/* Responsividade */
@media (max-width: 600px) {
    .modal-content {
        width: 95%;
        margin: 10% auto;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-footer {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-cancel, .btn-save {
        width: 100%;
    }
}
</style>

<script src="script.js"></script>
<script>
// Função para abrir o modal de edição
function editarPerfil() {
    document.getElementById('modalEditarPerfil').style.display = 'block';
}

// Função para fechar o modal
function fecharModalEditar() {
    document.getElementById('modalEditarPerfil').style.display = 'none';
    document.getElementById('formEditarPerfil').reset();
}

// Fechar modal clicando fora dele
window.onclick = function(event) {
    const modal = document.getElementById('modalEditarPerfil');
    if (event.target == modal) {
        fecharModalEditar();
    }
}

// Função para o histórico
function verHistorico() {
    window.location.href = 'historico.php';
}

// Envio do formulário de edição
document.getElementById('formEditarPerfil').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const senha = formData.get('senha');
    const confirmarSenha = formData.get('confirmar_senha');
    
    // Validar senhas se preenchidas
    if (senha && senha !== confirmarSenha) {
        alert('❌ As senhas não coincidem!');
        return;
    }
    
    // Se senha vazia, remover do envio
    if (!senha) {
        formData.delete('senha');
        formData.delete('confirmar_senha');
    }
    
    // Adicionar ação
    formData.append('acao', 'editar_perfil');
    
    try {
        const response = await fetch('../APP/controller/UsuarioController.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.sucesso) {
            alert('✅ Perfil atualizado com sucesso!');
            fecharModalEditar();
            location.reload(); // Recarregar para mostrar as mudanças
        } else {
            alert('❌ Erro ao atualizar perfil: ' + data.mensagem);
        }
    } catch (error) {
        console.error('Erro:', error);
        alert('❌ Erro de comunicação com o servidor!');
    }
});

// Máscara para CPF (se necessário)
document.getElementById('edit-cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d)/, '$1.$2');
    value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    e.target.value = value;
});
</script>

</body>
</html>
    


