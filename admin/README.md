# Sistema Administrativo - MusicWave 🎵

## Painel Completo de Administração

### Credenciais de Acesso
- **Usuário:** `admin`
- **Senha:** `password`

### Funcionalidades Implementadas

#### 🔐 **Autenticação Segura**
- Login protegido com hash de senha
- Controle de sessão administrativa
- Logout seguro
- Verificação de permissões

#### 📊 **Dashboard Inteligente**
- Estatísticas em tempo real
- Total de produtos cadastrados
- Número de usuários registrados
- Pedidos realizados
- Alertas de produtos com baixo estoque
- Ações rápidas para navegação

#### 🎁 **Gerenciamento de Produtos (CRUD Completo)**
- ✅ **Criar:** Adicionar novos produtos com todos os detalhes
- 👁️ **Visualizar:** Lista completa com imagens, preços e estoque
- ✏️ **Editar:** Modificar informações de produtos existentes
- 🗑️ **Remover:** Exclusão segura com confirmação
- 🖼️ **Imagens:** Suporte a URLs de imagens dos produtos
- 📈 **Estoque:** Controle visual com badges coloridos

#### 👥 **Gerenciamento de Usuários**
- Lista completa de usuários cadastrados
- Visualização de informações detalhadas (CPF, nome, email, telefone)
- Data de cadastro
- Remoção de usuários com confirmação
- Atualização automática de estatísticas

#### 🎨 **Interface Moderna**
- Design responsivo e profissional
- Sidebar retrátil com navegação intuitiva
- Gradientes e animações suaves
- Cards informativos com hover effects
- Modais elegantes para formulários
- Alertas flutuantes para feedback
- Tema roxo/azul consistente com a marca

#### 📱 **Responsividade**
- Totalmente adaptado para dispositivos móveis
- Sidebar colapsível em telas pequenas
- Layout flexível que se adapta a qualquer tela
- Tabelas responsivas com scroll horizontal

### Estrutura Técnica

#### 🗄️ **Banco de Dados**
```sql
-- Nova tabela Administrador
CREATE TABLE Administrador (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(100) NOT NULL, -- Hash bcrypt
    nome_completo VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    nivel_acesso ENUM('master', 'moderador') DEFAULT 'moderador',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_login TIMESTAMP NULL,
    ativo BOOLEAN DEFAULT TRUE
);
```

#### 🚀 **Backend (PHP)**
- **AdminController.php:** Controller principal com todas as operações
- Autenticação com `password_verify()`
- Sessões seguras com verificações
- API REST para comunicação assíncrona
- Tratamento de erros robusto
- Validações de entrada

#### 🎨 **Frontend**
- **admin-styles.css:** Design moderno e responsivo
- **admin-script.js:** JavaScript vanilla para interatividade
- Bootstrap 5 para componentes
- Bootstrap Icons para ícones
- Fetch API para requisições assíncronas
- Modals, alertas e animações

### Arquivos do Sistema

```
admin/
├── login-admin.php          # Página de login administrativa
├── dashboard.php            # Painel principal
├── admin-styles.css         # Estilos do painel admin
└── admin-script.js          # JavaScript do painel admin

APP/controller/
└── AdminController.php      # Controller backend

APP/BD/
└── script.sql              # Tabela Administrador + dados iniciais
```

### Funcionalidades por Seção

#### 🏠 **Dashboard**
- Cartões de estatísticas com ícones coloridos
- Botões de ação rápida
- Feed de atividades
- Visão geral do sistema

#### 📦 **Produtos**
- Tabela com imagens em miniatura
- Badges coloridos para estoque (verde: ok, amarelo: baixo, vermelho: crítico)
- Modal para adicionar/editar produtos
- Confirmação antes de remover
- Validação de formulários

#### 👥 **Usuários**
- Lista completa de clientes cadastrados
- Informações detalhadas de contato
- Data de cadastro formatada
- Remoção com confirmação

#### ⚙️ **Configurações**
- Informações da conta administrativa
- Configurações do sistema (futuras expansões)

### Segurança Implementada

- ✅ **Hashing de senhas** com bcrypt
- ✅ **Verificação de sessão** em todas as páginas
- ✅ **Sanitização de entrada** no backend
- ✅ **Validação de dados** no frontend e backend
- ✅ **Confirmações** para ações destrutivas
- ✅ **Logout seguro** com destruição de sessão

### Como Acessar

1. Navegue até: `http://localhost/pj-asw-bd-psw/admin/login-admin.php`
2. Digite as credenciais:
   - **Usuário:** admin
   - **Senha:** password
3. Clique em "Entrar no Sistema"
4. Você será redirecionado para o dashboard administrativo

### Próximas Funcionalidades

- 📊 Relatórios e gráficos
- 📧 Sistema de notificações
- 🔄 Backup e restauração
- 👨‍💼 Gestão de múltiplos administradores
- 📱 App mobile para administração

---

**Sistema desenvolvido com foco em usabilidade, segurança e performance! 🚀**
