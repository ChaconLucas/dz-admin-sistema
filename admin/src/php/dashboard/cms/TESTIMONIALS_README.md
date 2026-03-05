# Sistema de Depoimentos (Testimonials) - D&Z CMS

## 📋 Visão Geral

Sistema completo de gerenciamento de depoimentos de clientes exibidos na seção **"O que dizem nossas clientes"** da homepage.

## 🗄️ Banco de Dados

### Tabela: `cms_testimonials`

```sql
CREATE TABLE cms_testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    cargo_empresa VARCHAR(120) NULL,
    texto VARCHAR(600) NOT NULL,
    rating TINYINT NOT NULL DEFAULT 5,
    avatar_path VARCHAR(255) NULL,
    ordem INT DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Campos:**

- `nome`: Nome do cliente (máx 120 caracteres)
- `cargo_empresa`: Cargo/função opcional (ex: "Cliente verificada")
- `texto`: Depoimento completo (máx 600 caracteres)
- `rating`: Avaliação de 1 a 5 estrelas
- `avatar_path`: Caminho da foto do cliente (opcional)
- `ordem`: Ordem de exibição (ASC)
- `ativo`: 1 = exibido, 0 = oculto

## 🚀 Setup Inicial

1. **Criar a Tabela:**
   - Acesse: `admin/src/php/dashboard/cms/setup_testimonials.php`
   - Clique em "Executar Setup"
   - Insere 3 depoimentos de exemplo automaticamente

2. **Verificar Funcionalidade:**
   - Acesse: `CMS > Depoimentos de Clientes`
   - Você verá os 3 depoimentos de exemplo

## 🎯 Funcionalidades

### Admin (CMS)

#### 1. Dashboard de Depoimentos

**Local:** `admin/src/php/dashboard/cms/testimonials.php`

**Cards Informativos:**

- Depoimentos Ativos
- Total Cadastrados

#### 2. Criar Novo Depoimento

**Campos do Formulário:**

- Nome do Cliente (obrigatório, máx 120 chars)
- Cargo/Função (opcional, máx 120 chars)
- Texto do Depoimento (obrigatório, máx 600 chars)
- Avaliação (1 a 5 estrelas)
- Avatar (upload opcional JPG/PNG/WEBP)
- Ordem (número, padrão 0)
- Status Ativo (checkbox)

**Validações:**

- Nome obrigatório
- Texto obrigatório (máx 600 caracteres)
- Rating entre 1 e 5
- Upload: apenas JPG, PNG, WEBP
- Avatars salvos em: `uploads/testimonials/`

#### 3. Editar Depoimento

- Modal pré-preenchido com dados existentes
- Permite substituir avatar (upload novo)
- Atualiza timestamp automaticamente

#### 4. Ativar/Desativar

- Toggle rápido sem reload
- Depoimentos inativos não aparecem no site

#### 5. Excluir

- Confirmação antes de excluir
- Remove arquivo de avatar automaticamente
- Ação irreversível

#### 6. Listagem

**Colunas:**

- Cliente (avatar + nome + cargo)
- Depoimento (truncado em 100 chars)
- Avaliação (estrelas)
- Ordem
- Status (badge colorido)
- Ações (editar, toggle, excluir)

### API Endpoints

**Arquivo:** `admin/src/php/dashboard/cms/cms_api.php`

#### `list_testimonials`

```php
GET: cms_api.php?action=list_testimonials
Response: {
    success: true,
    items: [...],
    counts: { active: 2, total: 3 }
}
```

#### `add_testimonial`

```php
POST: cms_api.php
FormData:
  - action: "add_testimonial"
  - nome
  - cargo_empresa
  - texto
  - rating
  - ordem
  - ativo
  - avatar (file, opcional)
```

#### `update_testimonial`

```php
POST: cms_api.php
FormData:
  - action: "update_testimonial"
  - id
  - + campos de add_testimonial
```

#### `toggle_testimonial`

```php
POST: cms_api.php
FormData:
  - action: "toggle_testimonial"
  - id
```

#### `delete_testimonial`

```php
POST: cms_api.php
FormData:
  - action: "delete_testimonial"
  - id
```

### Cliente (Site Público)

#### Provedor de Dados

**Arquivo:** `cliente/cms_data_provider.php`

**Método:** `getTestimonials($limit = 3)`

```php
$cms = new CMSProvider($conn);
$testimonials = $cms->getTestimonials(3);
```

**SQL:**

```sql
SELECT nome, cargo_empresa, texto, rating, avatar_path
FROM cms_testimonials
WHERE ativo = 1
ORDER BY ordem ASC, id DESC
LIMIT 3
```

#### Renderização na Homepage

**Arquivo:** `cliente/index.php` (seção #depoimentos)

**Lógica:**

- Se `$testimonials` vazio → seção não exibida
- Loop PHP renderiza cada depoimento dinamicamente
- **Avatar:**
  - Se `avatar_path` existe → exibe imagem
  - Se vazio → círculo com inicial do nome
- **Cores dos avatares:** 5 gradientes alternados
- **Estrelas:** renderizadas dinamicamente conforme `rating`

**Estrutura HTML mantida:**

- Cards com glassmorphism
- Grid responsivo
- Animações fade-in-up
- Mesma identidade visual

## 📁 Estrutura de Arquivos

```
admin/src/php/dashboard/cms/
├── testimonials.php              # Página CRUD admin
├── cms_api.php                    # API endpoints (+ testimonials)
├── create_testimonials_table.sql # SQL da tabela
└── setup_testimonials.php         # Script de setup

uploads/
└── testimonials/                  # Avatars de clientes
    └── avatar_*.jpg/png/webp

cliente/
├── cms_data_provider.php          # Método getTestimonials()
└── index.php                      # Seção dinâmica renderizada
```

## 🎨 Recursos Visuais

### Admin

- **Modal:** Formulário flutuante estilo glassmorphism
- **Cards:** Estatísticas em tempo real
- **Tabela:** Listagem completa com badges de status
- **Preview:** Avatar exibido ao fazer upload
- **Contador:** Caracteres do texto (0/600)

### Cliente

- **Avatares:**
  - Com foto: imagem circular com borda magenta
  - Sem foto: círculo gradiente com inicial
- **Gradientes de Avatar:**
  1. Magenta (var(--color-magenta))
  2. Azul (#3b82f6 → #1e40af)
  3. Verde (#10b981 → #059669)
  4. Laranja (#f59e0b → #d97706)
  5. Roxo (#8b5cf6 → #6d28d9)
- **Estrelas:** ⭐ (repetidas conforme rating)
- **Cards:** Background branco translúcido com backdrop-filter

## 🔒 Segurança

- ✅ Prepared statements em todas as queries
- ✅ `htmlspecialchars()` em todas as saídas
- ✅ Validação de upload (extensões permitidas)
- ✅ Limite de caracteres (nome 120, texto 600)
- ✅ Try-catch para tabela não existente
- ✅ Confirmação antes de excluir
- ✅ Remoção de arquivo ao excluir/substituir avatar

## ⚙️ Configurações

### Avatars

- **Formatos:** JPG, JPEG, PNG, WEBP
- **Pasta:** `uploads/testimonials/`
- **Nomeação:** `avatar_{uniqid}.ext`
- **Opcional:** Se não enviar, exibe inicial

### Listagem

- **Ordem:** `ordem ASC, id DESC`
- **Limite Cliente:** 3 depoimentos ativos
- **Truncamento:** Texto em 100 chars na tabela admin

### Rating

- **Mínimo:** 1 estrela
- **Máximo:** 5 estrelas
- **Padrão:** 5 estrelas

## 📝 Exemplo de Uso

### No Admin

```php
1. Acessar: CMS > Depoimentos de Clientes
2. Clicar: "+ Novo Depoimento"
3. Preencher:
   - Nome: "Juliana Santos"
   - Cargo: "Cliente verificada"
   - Texto: "Produtos incríveis! Recomendo muito."
   - Rating: 5 estrelas
   - Avatar: (upload opcional)
   - Ordem: 1
   - ✓ Ativo
4. Salvar
```

### No Cliente

A seção será exibida automaticamente com:

- 3 depoimentos mais recentes ativos
- Ordenados por `ordem ASC`
- Estrelas dinâmicas
- Avatar ou inicial

## 🐛 Troubleshooting

**Problema:** Tabela não encontrada

- **Solução:** Execute `setup_testimonials.php`

**Problema:** Avatars não aparecem

- **Solução:** Verifique permissões da pasta `uploads/testimonials/` (755)

**Problema:** Nenhum depoimento no site

- **Solução:** Certifique-se que há depoimentos com `ativo = 1`

**Problema:** Upload falha

- **Solução:** Verifique `upload_max_filesize` no php.ini

## ✅ Checklist de Validação

- [x] Tabela cms_testimonials criada
- [x] 3 depoimentos de exemplo inseridos
- [x] API endpoints funcionando
- [x] CRUD completo no admin
- [x] Upload de avatar funcionando
- [x] Seção dinâmica no cliente renderizando
- [x] Avatars com inicial quando sem foto
- [x] Estrelas dinâmicas conforme rating
- [x] Validações de formulário
- [x] Error handling (try-catch)
- [x] Prepared statements
- [x] Confirmação antes de excluir
- [x] Remoção automática de arquivos

## 📚 Dependências

- PHP 7.4+
- MySQLi extension
- Tabela criada via setup script
- Pasta `uploads/testimonials/` com permissões de escrita

## 🎯 Padrão Mantido

Este sistema segue **exatamente** o mesmo padrão de:

- ✅ Métricas (cms_home_metrics)
- ✅ Promoções (cms_promotions)
- ✅ Banners (home_banners)
- ✅ Lançamentos (featured products)

**Consistência garantida em:**

- Estrutura de código
- Nomeação de funções
- Validações
- Error handling
- UI/UX do admin
- Integração com cliente
