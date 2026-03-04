# 🎯 D&Z Admin - Sistema Completo de Gestão E-commerce

**Painel administrativo moderno com CMS integrado para gerenciamento completo de e-commerce de produtos de beleza profissional.**

---

## 📋 **Índice**

1. [Sobre o Projeto](#-sobre-o-projeto)
2. [Tecnologias Utilizadas](#-tecnologias-utilizadas)
3. [Estrutura do Projeto](#-estrutura-do-projeto)
4. [Instalação Rápida](#-instalação-rápida)
5. [Módulo CMS](#-módulo-cms)
6. [Gestão de Pedidos](#-gestão-de-pedidos)
7. [Sistema de Chat com IA](#-sistema-de-chat-com-ia)
8. [Área do Cliente](#-área-do-cliente)
9. [Configurações](#-configurações)
10. [Segurança](#-segurança)

---

## 🚀 **Sobre o Projeto**

O **D&Z Admin** é um sistema completo de administração desenvolvido para e-commerce de produtos profissionais de beleza (unhas, cílios) com:

- ✅ **Painel Admin Completo**: Produtos, pedidos, vendedores, métricas
- ✅ **CMS Integrado**: Gerenciamento de conteúdo do site público
- ✅ **Chat com IA**: Sistema de atendimento automatizado (Groq API)
- ✅ **Sistema de Logs**: Auditoria completa de ações
- ✅ **Site Público**: Loja virtual integrada ao admin
- ✅ **Dashboard Analytics**: Gráficos e métricas em tempo real

---

## 💻 **Tecnologias Utilizadas**

### **Backend:**

- PHP 8.0+
- MySQL 8.0 (utf8mb4)
- XAMPP Local Server

### **Frontend:**

- HTML5 + CSS3 (Grid/Flexbox)
- JavaScript ES6+ (Vanilla)
- Chart.js
- Material Symbols Sharp

### **APIs:**

- Groq API (llama-3.3-70b-versatile) - Chat IA
- PHPMailer - Envio de e-mails

---

## 📁 **Estrutura do Projeto**

```
admin-teste/
├── 📂 admin/                      # Painel administrativo
│   ├── config/
│   │   └── base.php              # BASE_URL e caminhos globais
│   ├── src/
│   │   ├── css/                  # Estilos do dashboard
│   │   ├── js/                   # JavaScript
│   │   │   ├── dashboard.js      # Funções principais
│   │   │   └── contador-auto.js  # Contador mensagens
│   │   └── php/
│   │       ├── sistema.php       # API principal
│   │       └── dashboard/        # Páginas admin
│   │           ├── index.php     # Dashboard
│   │           ├── products.php  # Produtos
│   │           ├── orders.php    # Pedidos
│   │           ├── menssage.php  # Chat
│   │           └── cms/          # Sistema CMS ⭐
│   │               ├── home.php       # Textos da home
│   │               ├── banners.php    # Banners carrossel
│   │               ├── featured.php   # Produtos destaque
│   │               ├── promos.php     # Promoções
│   │               ├── testimonials.php # Depoimentos
│   │               ├── metrics.php    # Métricas empresa
│   │               ├── cms_api.php    # API do CMS
│   │               └── setup_cms_tables.sql # SQL setup
│   └── PHP/                      # Core PHP
│       ├── conexao.php           # Conexão MySQL
│       ├── acoes.php             # CRUD usuários
│       └── ...
├── 📂 cliente/                    # Site público (loja)
│   ├── index.php                 # Home da loja
│   ├── cms_data_provider.php     # Provider CMS ⭐
│   ├── conexao.php               # Conexão cliente
│   └── pages/                    # Páginas cliente
│       ├── carrinho.php
│       ├── login.php
│       └── ...
├── 📂 uploads/                    # Uploads de arquivos
│   ├── banners/                  # Imagens de banners
│   └── produtos/                 # Imagens de produtos
├── 📂 config/                     # Configurações globais
│   └── config.php                # Credenciais banco
└── favicon.ico                    # Ícone do site
```

---

## 🛠 **Instalação Rápida**

### **Passo 1: Requisitos**

- XAMPP instalado
- PHP 7.4+ com extensões: mysqli, curl, gd
- MySQL 8.0+

### **Passo 2: Banco de Dados**

1. Acesse phpMyAdmin: `http://localhost/phpmyadmin`
2. Crie o banco: `teste_dz` (Cotejamento: `utf8mb4_unicode_ci`)
3. Execute os scripts SQL na ordem:
   - `admin/sql/criar_tabelas_dashboard.sql` (tabelas principais)
   - `admin/src/php/dashboard/cms/setup_cms_tables.sql` (CMS básico)
   - `admin/src/php/dashboard/cms/migration_cms_expansao.sql` (CMS expandido - Footer e Benefícios) ⭐

### **Passo 3: Configuração**

**Arquivo:** `admin/config/config.php`

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'teste_dz');

// API Groq (Chat IA)
define('GROQ_API_KEY', 'sua-chave-aqui');
```

**Arquivo:** `admin/config/base.php` (já configurado)

```php
<?php
define('BASE_URL', '/admin-teste/');  // Ajustar se necessário
define('API_SISTEMA_URL', BASE_URL . 'admin/src/php/sistema.php');
```

### **Passo 4: Acesso**

- **Admin:** `http://localhost/admin-teste/admin/PHP/login.php`
- **Site Público:** `http://localhost/admin-teste/cliente/`

**Credenciais padrão:** (criar no banco ou via cadastro)

---

## 🎨 **Módulo CMS**

### **O que é?**

Sistema de gerenciamento de conteúdo integrado ao painel admin para editar o site público sem alterar código.

### **Funcionalidades:**

#### 1️⃣ **Home - Textos Principais**

- Seção Hero (título, subtítulo, descrição, botão)
- Seção Lançamentos (título, subtítulo)

#### 2️⃣ **Banners do Carrossel**

- Upload de imagens (JPG, PNG, WEBP - máx 2MB)
- Título, subtítulo, descrição
- Botão de ação (texto + link)
- Ativar/Desativar
- Ordenação (↑↓)
- CRUD completo

#### 3️⃣ **Produtos em Destaque**

- Selecionar produtos da base existente
- Busca/filtro em tempo real
- Ordenação personalizada
- Limite: 4-8 produtos

#### 4️⃣ **Promoções**

- Blocos promocionais configuráveis

#### 5️⃣ **Depoimentos**

- CRUD de depoimentos de clientes

#### 6️⃣ **Métricas da Empresa**

- Números estatísticos (anos mercado, clientes, produtos, etc)

#### 7️⃣ **Links do Footer**

- ✅ CRUD completo de links do footer
- ✅ Organização em colunas (Produtos / Atendimento)
- ✅ Ativar/Desativar links individualmente
- ✅ Controlar ordem de exibição
- ✅ Edição de texto e URL
- ✅ Interface dedicada com modal
- ✅ Integração automática no site público

**Acesso:** `CMS → Links do Footer`

---

### **Tabelas do CMS:**

```sql
-- Tabelas principais do CMS
home_settings              -- Textos da home (singleton)
home_banners               -- Banners do carrossel
home_featured_products     -- Produtos em destaque
cms_home_beneficios        -- Benefícios da home
cms_footer                 -- Dados do footer (singleton)
cms_footer_links           -- Links do footer (produtos/atendimento)
```

---

### **Integração Site Público:**

**Arquivo:** `cliente/index.php`

```php
<?php
// Incluir provider CMS
require_once 'cms_data_provider.php';

// Carregar dados do CMS
$cms = new CMSProvider($conexao);
$cmsData = $cms->getAllData();

// Usar dados no HTML
$banners = $cmsData['banners'];
$settings = $cmsData['settings'];
$featuredProducts = $cmsData['featured_products'];
?>

<!-- Exemplo: Banners dinâmicos -->
<div class="carousel">
    <?php foreach ($banners as $banner): ?>
        <div class="banner-slide">
            <img src="<?= getBannerImageUrl($banner['image_path']) ?>"
                 alt="<?= htmlspecialchars($banner['title']) ?>">
            <h2><?= htmlspecialchars($banner['title']) ?></h2>
            <p><?= htmlspecialchars($banner['subtitle']) ?></p>
        </div>
    <?php endforeach; ?>
</div>
```

---

## 📦 **Gestão de Pedidos**

### **Visão Geral**

Sistema completo de gerenciamento de pedidos com filtros avançados, integração com Gestão de Fluxo e processamento de reembolsos.

### **Funcionalidades:**

#### 1️⃣ **Filtros e Navegação**

- ✅ Filtro por data (início e fim)
- ✅ Abas de navegação:
  - Todos os Pedidos
  - Aguardando Pagamento
  - Pagos
  - Enviados
  - Reembolsos
- ✅ Busca por Nome, CPF ou Nº do Pedido

#### 2️⃣ **Tabela Dinâmica**

- ✅ Listagem de pedidos com dados do banco
- ✅ Integração com Gestão de Fluxo (status e cores)
- ✅ Colunas: ID, Data, Cliente, Valor Total, Status (badge colorido), Ações
- ✅ Botão "Ver Detalhes" estilizado

#### 3️⃣ **Modal de Detalhes**

Ao clicar em "Ver Detalhes", exibe:

- **Dados do Cliente:** Nome, E-mail, Telefone (WhatsApp)
- **Endereço de Entrega:** Completo com CEP
- **Informações do Pedido:** Data, valor, status, observações
- **Itens do Pedido:** Lista detalhada (produtos, quantidades, valores)

#### 4️⃣ **Gestão de Reembolso**

- ✅ Aba específica para pedidos em reembolso
- ✅ Botão "Processar Reembolso" para pedidos elegíveis
- ✅ Atualização automática de status no banco

### **Estrutura de Dados:**

```sql
-- Tabelas principais
pedidos                     -- Dados dos pedidos
clientes                    -- Informações dos clientes
itens_pedido                -- Produtos do pedido
status_fluxo                -- Status e configurações (cores)
pedidos_historico_status    -- Histórico de mudanças
```

### **API Endpoints:**

```javascript
// POST orders.php
action = buscar_pedidos; // Lista com filtros
action = buscar_detalhes_pedido; // Detalhes completos
action = processar_reembolso; // Processa reembolso
```

### **Atualização do Schema:**

Execute uma vez: `admin/src/php/dashboard/update-orders-schema.php`

### **Personalização:**

- **Cores dos Status:** Gerenciadas pela Gestão de Fluxo
- **Campos Adicionais:** Adicione na tabela `pedidos` e atualize as queries

### **Segurança:**

- ✅ Verificação de sessão
- ✅ Prepared statements (SQL injection)
- ✅ Validação de entrada
- ✅ Logs de auditoria

---

## 🤖 **Sistema de Chat com IA**

### **Tecnologia:**

- **API:** Groq (llama-3.3-70b-versatile)
- **Personalidade:** DAIze - Consultora digital D&Z

### **Funcionalidades:**

- ✅ Atendimento automatizado 24/7
- ✅ Respostas sobre produtos (unhas, cílios)
- ✅ Escalonamento para humano quando necessário
- ✅ Histórico de conversas
- ✅ Interface moderna com status online/offline

### **Configuração:**

1. Obtenha API key em: https://console.groq.com
2. Configure em `admin/config/config.php`:

```php
define('GROQ_API_KEY', 'gsk_...sua_chave');
```

### **Endpoints da API:**

```javascript
// Cliente (site público)
POST /admin/src/php/sistema.php?api=1&endpoint=client&action=send_message

// Admin (painel)
GET /admin/src/php/sistema.php?api=1&endpoint=admin&action=get_stats
GET /admin/src/php/sistema.php?api=1&endpoint=admin&action=get_conversations
```

---

## 🛍️ **Área do Cliente**

### **Funcionalidades:**

- ✅ Vitrine de produtos com filtros
- ✅ Carrinho de compras
- ✅ Sistema de login/cadastro
- ✅ Minha conta
- ✅ Histórico de pedidos
- ✅ Chat com IA integrado
- ✅ Conteúdo dinâmico via CMS

### **Arquivos principais:**

```
cliente/
├── index.php              # Home da loja
├── conexao.php            # Conexão compartilhada
├── cms_data_provider.php  # Provider CMS
└── pages/
    ├── carrinho.php       # Carrinho
    ├── login.php          # Login
    ├── minha-conta.php    # Conta do cliente
    └── pedidos.php        # Histórico
```

---

## ⚙️ **Configurações**

### **BASE_URL Global:**

Todas as páginas admin usam caminhos absolutos definidos em `admin/config/base.php`:

```php
define('BASE_URL', '/admin-teste/');
define('UPLOADS_URL', BASE_URL . 'uploads/');
define('BANNERS_URL', UPLOADS_URL . 'banners/');
```

**JavaScript:**

```html
<script>
  window.BASE_URL = "<?php echo BASE_URL; ?>";
  window.API_SISTEMA_URL = "<?php echo API_SISTEMA_URL; ?>";
</script>
```

### **Upload de Imagens:**

**Configuração:** `admin/src/php/dashboard/cms/cms_api.php`

```php
// Pasta de upload (criada automaticamente)
$upload_dir = dirname(__DIR__, 5) . '/uploads/banners/';

// Permissões: 0755
// Tamanho máx: 2MB
// Formatos: JPG, PNG, WEBP
```

---

## 🔒 **Segurança**

### **Implementado:**

✅ **Prepared Statements** - Prevenção SQL Injection
✅ **XSS Protection** - `htmlspecialchars()` em outputs
✅ **Session Management** - Controle de sessões seguro
✅ **CSRF Protection** - Tokens em formulários críticos
✅ **File Upload Validation** - Verificação de tipo MIME
✅ **Path Sanitization** - Prevenção directory traversal
✅ **Password Hashing** - `password_hash()` bcrypt

### **Recomendações Produção:**

⚠️ **IMPORTANTE - Antes de publicar:**

1. Alterar credenciais do banco
2. Ativar HTTPS (certificado SSL)
3. Configurar `.htaccess` robusto:

```apache
# Bloquear acesso a arquivos sensíveis
<FilesMatch "^(config\.php|conexao\.php)$">
    Require all denied
</FilesMatch>

# Proteção contra listagem de diretórios
Options -Indexes
```

4. Remover arquivos de teste/debug
5. Ativar display_errors = Off no php.ini
6. Implementar rate limiting nas APIs
7. Configurar backup automático do banco

---

## 📊 **Sistema de Logs**

Todas as ações administrativas são registradas automaticamente:

**Tabela:** `admin_logs`

**Campos:**

- ID, admin_id, admin_nome
- acao (descrição da ação)
- ip_address
- timestamp

**Visualização:** `admin/src/php/dashboard/all-logs.php`

---

## 🚀 **Deploy / Mudança de Ambiente**

### **Local → Servidor:**

1. **Atualizar BASE_URL:**

```php
// admin/config/base.php
define('BASE_URL', '/');  // Se na raiz do domínio
// OU
define('BASE_URL', '/subpasta/');  // Se em subpasta
```

2. **Atualizar conexão:**

```php
// config/config.php
define('DB_HOST', 'seu-servidor-mysql');
define('DB_USER', 'usuario-producao');
define('DB_PASS', 'senha-forte');
define('DB_NAME', 'banco-producao');
```

3. **Ajustar permissões:**

```bash
chmod 755 uploads/
chmod 755 uploads/banners/
chmod 755 uploads/produtos/
```

4. **Testar:**

- ✅ Login admin
- ✅ Upload de imagens (CMS)
- ✅ Chat funcionando
- ✅ Site público carregando dados CMS

---

## 📝 **Notas Técnicas**

### **Encoding:**

- Banco: `utf8mb4_unicode_ci`
- Arquivos PHP: UTF-8 (sem BOM)
- Headers: `Content-Type: text/html; charset=UTF-8`

### **Compatibilidade:**

- PHP 7.4+
- MySQL 5.7+ (recomendado 8.0+)
- Navegadores modernos (Chrome, Firefox, Safari, Edge)

### **Performance:**

- Imagens otimizadas (WebP recomendado)
- Cache de dados CMS implementado
- Queries otimizadas com índices

---

## 🆘 **Troubleshooting**

### **Problema: Imagens não aparecem**

```bash
# Verificar permissões
ls -la uploads/banners/

# Corrigir
chmod 755 uploads/banners/
```

### **Problema: Erro 404 nas APIs**

```php
// Verificar BASE_URL em admin/config/base.php
echo BASE_URL;  // Deve corresponder ao caminho real
```

### **Problema: Chat IA não responde**

```php
// Verificar API key
var_dump(defined('GROQ_API_KEY'));  // Deve retornar true
```

### **Problema: Encoding errado (caracteres estranhos)**

```sql
-- Verificar tabelas
SHOW TABLE STATUS WHERE Name='home_settings';
-- Collation deve ser utf8mb4_unicode_ci

-- Corrigir se necessário
ALTER TABLE home_settings CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## 📞 **Suporte**

Para dúvidas ou problemas:

1. Verificar logs do Apache/PHP (`error.log`)
2. Console do navegador (F12)
3. Verificar permissões de arquivos/pastas
4. Consultar este README

---

## 📄 **Licença**

Sistema proprietário desenvolvido para D&Z.

---

## 📝 **Changelog**

### **Versão 2.1 (Março 2026)**

- ✅ Adicionado gerenciamento de Links do Footer (CMS)
- ✅ Nova página CRUD para links do footer
- ✅ API dedicada para operações do footer
- ✅ Integração automática no site público
- ✅ Documentação consolidada em README único

### **Versão 2.0 (Fevereiro 2026)**

- ✅ Sistema CMS completo
- ✅ Gestão de Pedidos com reembolso
- ✅ Chat com IA (Groq API)
- ✅ Dashboard analytics

---

**Desenvolvido com ❤️ para D&Z - Produtos Profissionais de Beleza**

**Versão Atual:** 2.1  
**Última Atualização:** 04 de Março de 2026
