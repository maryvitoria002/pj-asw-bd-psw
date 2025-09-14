# 📋 SISTEMA ADMINISTRATIVO - DOCUMENTAÇÃO COMPLETA

## 🎯 VISÃO GERAL
Sistema completo de administração para gerenciar produtos e usuários do MusicWave com interface moderna e funcionalidades CRUD completas.

---

## 📁 ESTRUTURA DE ARQUIVOS

### 🎨 FRONTEND (Interface do Usuário)
```
admin/
├── dashboard.php           → Interface principal do admin (HTML + Bootstrap)
├── login-admin.php         → Página de login do administrador
├── admin-styles.css        → Estilos personalizados (paleta dourada)
└── admin-script.js         → Lógica JavaScript e interações
```

### ⚙️ BACKEND (Lógica do Servidor)
```
APP/controller/
├── AdminController.php        → CRUD de produtos e usuários
├── ImageUploadController.php  → Upload e gerenciamento de imagens
├── LoginController.php        → Autenticação de administradores
└── LogoutController.php       → Logout e limpeza de sessão
```

### 🗃️ BANCO DE DADOS
```
APP/BD/
├── Conexao.php             → Conexão com MySQL
└── script.sql              → Estrutura das tabelas
```

---

## 🔧 FUNCIONALIDADES CRUD

### 📦 PRODUTOS
| Operação | Onde Está | Arquivo Principal | Método/Função |
|----------|-----------|-------------------|---------------|
| **CREATE** | `AdminController.php` | Linha ~50 | `adicionarProduto()` |
| **READ** | `AdminController.php` | Linha ~150 | `listarProdutos()` |
| **UPDATE** | `AdminController.php` | Linha ~100 | `editarProduto()` |
| **DELETE** | `AdminController.php` | Linha ~200 | `deletarProduto()` |

### 👥 USUÁRIOS
| Operação | Onde Está | Arquivo Principal | Método/Função |
|----------|-----------|-------------------|---------------|
| **CREATE** | `AdminController.php` | Linha ~250 | `adicionarUsuario()` |
| **READ** | `AdminController.php` | Linha ~350 | `listarUsuarios()` |
| **UPDATE** | `AdminController.php` | Linha ~300 | `editarUsuario()` |
| **DELETE** | `AdminController.php` | Linha ~400 | `deletarUsuario()` |

### 🖼️ IMAGENS
| Operação | Onde Está | Arquivo Principal | Método/Função |
|----------|-----------|-------------------|---------------|
| **UPLOAD** | `ImageUploadController.php` | Linha ~20 | `uploadImage()` |
| **DELETE** | `ImageUploadController.php` | Linha ~150 | `deleteImage()` |
| **OPTIMIZE** | `ImageUploadController.php` | Linha ~100 | `optimizeImage()` |

---

## 🚀 COMO USAR

### 1. Acesso ao Sistema
- URL: `http://localhost/pj-asw-bd-psw/admin/login-admin.php`
- Credenciais: Definidas na tabela `administrador`

### 2. Navegação
- **Dashboard**: Visão geral com estatísticas
- **Produtos**: Gerenciar catálogo de instrumentos
- **Usuários**: Gerenciar clientes cadastrados

### 3. Operações Básicas
- **Adicionar**: Botão "+" ou "Adicionar Novo"
- **Editar**: Clique no ícone de lápis
- **Excluir**: Clique no ícone de lixeira
- **Visualizar**: Dados exibidos em tabelas responsivas

---

## 🎨 INTERFACE
- **Design**: Bootstrap 5 + paleta dourada (#f7bd6d, #fdfaf5)
- **Responsivo**: Funciona em desktop, tablet e mobile
- **Modais**: Formulários em pop-ups para melhor UX
- **Alertas**: Feedback visual para todas as ações

---

## 🔒 SEGURANÇA
- Sessões PHP para controle de acesso
- Validação de dados no frontend e backend
- Upload seguro de imagens com validação de tipo
- Proteção contra SQL injection (prepared statements)

---

## 📱 RESPONSIVIDADE
- Sidebar colapsável em telas pequenas
- Tabelas com scroll horizontal
- Modais adaptáveis
- Botões touch-friendly
