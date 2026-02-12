# Área do Cliente - E-commerce

Esta pasta contém a área do cliente da loja virtual, separada do painel administrativo.

## Estrutura dos Arquivos

### Arquivos Principais

- `index.php` - Página principal da loja (vitrine de produtos)
- `config-cliente.php` - Configurações e caminhos para área do cliente
- `auth.php` - Sistema de autenticação (login/logout)
- `loja.css` - Estilos específicos da área do cliente
- `loja.js` - JavaScript para interações da loja

## Como Funciona

### Reutilização de Recursos do Admin

A área do cliente reutiliza os recursos do painel administrativo através de caminhos relativos:

```php
// Caminhos definidos em config-cliente.php
define('PATH_CONFIG', '../config/');     // Configurações do banco
define('PATH_PHP_ADMIN', '../PHP/');     // Scripts PHP do admin
define('PATH_ASSETS', '../assets/');     // Imagens e assets
define('PATH_SRC', '../src/');           // CSS/JS do admin (opcional)
```

### Conexão com Banco de Dados

```php
// Usa a mesma conexão do admin
$conexao = getConexaoBanco(); // Função em config-cliente.php
```

### Estrutura de CSS e JS

```html
<!-- CSS da loja (local) -->
<link rel="stylesheet" href="loja.css" />

<!-- CSS do admin (se necessário) -->
<link rel="stylesheet" href="../src/css/dashboard.css" />
```

## Funcionalidades Implementadas

### 1. Vitrine de Produtos

- Grid responsivo de produtos
- Busca por nome
- Filtro por categorias
- Design moderno com cards

### 2. Sistema de Login

- Modal de login
- Autenticação via banco de dados
- Sessão de usuário
- Logout

### 3. Carrinho de Compras (base)

- Função JavaScript preparada
- Estrutura para adicionar produtos

### 4. Design Responsivo

- Mobile-first
- Grid CSS moderno
- Animações suaves
- UX otimizada

## Configuração Necessária

### 1. Tabela de Clientes (SQL)

```sql
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2. Tabela de Produtos (se não existir)

```sql
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    categoria VARCHAR(100),
    descricao TEXT,
    ativo BOOLEAN DEFAULT TRUE
);
```

## Como Testar

1. **Acesse a loja**: `http://localhost/admin-teste/cliente/`

2. **Veja a vitrine**: A página principal mostra produtos do banco ou exemplos

3. **Teste o login**: Clique em "Entrar" para abrir o modal de login

4. **Responsividade**: Teste em diferentes tamanhos de tela

## Próximos Passos

### Funcionalidades a Implementar

- [ ] Cadastro de novos clientes
- [ ] Página de detalhes do produto
- [ ] Carrinho de compras completo
- [ ] Finalização de pedido
- [ ] Área do cliente logado
- [ ] Histórico de pedidos
- [ ] Sistema de pagamento

### Melhorias Sugeridas

- [ ] Cache de produtos
- [ ] Paginação da vitrine
- [ ] Filtros avançados
- [ ] Sistema de avaliações
- [ ] Wishlist
- [ ] Cupons de desconto

## Arquivos que NÃO foram Alterados

Esta implementação **NÃO modifica** nenhum arquivo do painel administrativo:

- ✅ `config/` - mantido intacto
- ✅ `PHP/` - mantido intacto
- ✅ `assets/` - mantido intacto
- ✅ Arquivos da raiz - mantidos intactos

Tudo funciona através de **referências relativas** que não interferem no admin.

## Personalizações

### Alterar Cores do Tema

Edite em `loja.css`:

```css
/* Cor principal da loja */
.btn-primary {
  background: #e74c3c;
} /* Vermelho atual */

/* Gradiente do hero */
.hero-section {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Adicionar Novas Seções

1. Edite `index.php`
2. Adicione CSS correspondente em `loja.css`
3. Adicione JavaScript se necessário em `loja.js`

### Integrar com Admin

```php
// Para usar funções do admin
include_once PATH_PHP_ADMIN . 'algum-arquivo.php';
```

## Suporte

Para dúvidas ou problemas:

1. Verifique se o XAMPP está rodando
2. Confirme a conexão com o banco em `config/config.php`
3. Verifique os logs de erro do PHP
4. Teste os caminhos relativos navegando pelos arquivos
