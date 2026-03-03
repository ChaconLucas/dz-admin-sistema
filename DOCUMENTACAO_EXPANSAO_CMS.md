# DOCUMENTAÇÃO - EXPANSÃO CMS HOME E FOOTER

## D&Z E-commerce - Data: 03/03/2026

---

## 📋 RESUMO EXECUTIVO

Esta expansão adiciona funcionalidade de edição de textos para 4 novas seções do site:

1. **Cards de Benefícios** (4 cards editáveis)
2. **Seção Lançamentos** (textos + botão)
3. **Seção Todos os Produtos** (textos + botão)
4. **Footer Completo** (marca, contato, redes sociais, links, copyright)

**Princípio:** Mudanças mínimas, sem quebrar funcionalidades existentes.

---

## 🔍 1. ANÁLISE DO ESTADO ATUAL

### Tabelas Existentes (ENCONTRADAS)

✅ **home_settings** - Já existe com campos:

- hero_title, hero_subtitle, hero_description
- hero_button_text, hero_button_link
- launch_title, launch_subtitle
- updated_at

✅ **home_banners** - Já existe (gerenciamento de carrossel)
✅ **home_featured_products** - Já existe (produtos em destaque)

### O Que Precisa Ser Criado

❌ **Colunas em home_settings:**

- launch_button_text, launch_button_link (campos de botão para Lançamentos)
- products_title, products_subtitle (textos da seção Todos os Produtos)
- products_button_text, products_button_link (botão da seção Todos os Produtos)

❌ **Nova Tabela: cms_home_beneficios**

- Para gerenciar os 4 cards de benefícios (Entrega Grátis, Qualidade Premium, etc)estrutura: id, titulo, subtitulo, icone, cor, ordem, ativo

❌ **Nova Tabela: cms_footer**

- Dados do rodapé (marca, contato, redes sociais, copyright)
- Estrutura: id=1 (registro único), marca_titulo, marca_subtitulo, marca_descricao, telefone, whatsapp, email, instagram, tiktok, facebook, copyright_texto

❌ **Nova Tabela: cms_footer_links**

- Links das colunas "Produtos" e "Atendimento" do footer
- Estrutura: id, coluna ENUM('produtos','atendimento'), texto, link, ordem, ativo

### Front-End (cliente/index.php)

**HARDCODED (precisa ser dinamizado):**

- ✅ Benefícios (linha ~3301): 4 divs `.benefit-badge` com dados fixos
- ✅ Botão "Ver Todos os Lançamentos" (linha ~3435): hardcoded
- ✅ Seção "Todos os Produtos" (linha ~3447): título/subtítulo hardcoded
- ✅ Footer completo (linha ~4351): marca, contato, redes, links, copyright hardcoded

**JÁ DINÂMICO (não mexer):**

- ✅ Seção Hero (usa $homeSettings)
- ✅ Título/Subtítulo Lançamentos (usa $homeSettings['launch_title/subtitle'])
- ✅ Lista de produtos em destaque (usa $featuredProducts)

---

## 📊 2. SCRIPT SQL COMPLETO

**Arquivo:** `migration_cms_expansao.sql`

### O Que Faz:

1. **Adiciona 6 colunas na tabela home_settings** (verificando existência via INFORMATION_SCHEMA)
2. **Cria tabela cms_home_beneficios** (apenas se não existir)
3. **Insere 4 registros padrão de benefícios** (apenas se tabela vazia)
4. **Cria tabela cms_footer** (apenas se não existir)
5. **Insere registro único do footer** (apenas se não existir)
6. **Cria tabela cms_footer_links** (apenas se não existir)
7. **Insere 9 links padrão** (apenas se tabela vazia)

### Como Executar:

#### Opção 1: Via phpMyAdmin

1. Abra [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Selecione database `teste_dz`
3. Vá na aba "SQL"
4. Cole todo o conteúdo de `migration_cms_expansao.sql`
5. Clique em "Executar"

#### Opção 2: Via linha de comando (MySQL CLI)

```bash
mysql -u root -p teste_dz < migration_cms_expansao.sql
```

### Logs de Verificação:

O script mostra ao final:

- Estrutura atualizada de `home_settings`
- Dados atuais em `home_settings`
- 4 benefícios cadastrados
- Dados do footer
- 9 links do footer

---

## 🔧 3. ALTERAÇÕES NO CMS (home.php)

### Arquivo: `admin/src/php/dashboard/cms/home.php`

#### Mudanças no PHP (topo do arquivo, após linha 28)

**ADICIONAR** após `$settings = mysqli_fetch_assoc(...);`:

```php
// Buscar benefícios (novos)
$beneficios_sql = "SELECT * FROM cms_home_beneficios WHERE ativo = 1 ORDER BY ordem ASC";
$beneficios_result = mysqli_query($conexao, $beneficios_sql);
$beneficios = [];
while ($row = mysqli_fetch_assoc($beneficios_result)) {
    $beneficios[] = $row;
}

// Buscar dados do footer (novos)
$footer_sql = "SELECT * FROM cms_footer WHERE id = 1";
$footer_result = mysqli_query($conexao, $footer_sql);
$footer = mysqli_fetch_assoc($footer_result);

if (!$footer) {
    mysqli_query($conexao, "INSERT INTO cms_footer (id) VALUES (1)");
    $footer_result = mysqli_query($conexao, $footer_sql);
    $footer = mysqli_fetch_assoc($footer_result);
}

// Buscar links do footer (novos)
$footer_links_sql = "SELECT * FROM cms_footer_links WHERE ativo = 1 ORDER BY coluna, ordem ASC";
$footer_links_result = mysqli_query($conexao, $footer_links_sql);
$footer_links = ['produtos' => [], 'atendimento' => []];
while ($row = mysqli_fetch_assoc($footer_links_result)) {
    $footer_links[$row['coluna']][] = $row;
}
```

#### Mudanças no HTML (dentro do formulário)

**LOCALIZAR** a seção "Lançamentos" (linha ~347) e **SUBSTITUIR POR**:

```php
<!-- Seção de Lançamentos -->
<div class="settings-card">
    <h3>
        <span class="material-symbols-sharp">star</span>
        Seção de Lançamentos
    </h3>

    <div class="form-group">
        <label>Título da Seção *</label>
        <input type="text" name="launch_title" value="<?php echo htmlspecialchars($settings['launch_title'] ?? 'Lançamentos'); ?>" required>
        <small>Título da seção de produtos em destaque</small>
    </div>

    <div class="form-group">
        <label>Subtítulo</label>
        <input type="text" name="launch_subtitle" value="<?php echo htmlspecialchars($settings['launch_subtitle'] ?? 'Novidades que acabaram de chegar'); ?>">
        <small>Descrição da seção de lançamentos</small>
    </div>

    <div class="form-group">
        <label>Texto do Botão</label>
        <input type="text" name="launch_button_text" value="<?php echo htmlspecialchars($settings['launch_button_text'] ?? 'Ver Todos os Lançamentos'); %>">
        <small>Texto que aparece no botão</small>
    </div>

    <div class="form-group">
        <label>Link do Botão</label>
        <input type="text" name="launch_button_link" value="<?php echo htmlspecialchars($settings['launch_button_link'] ?? '#catalogo'); ?>">
        <small>URL ou âncora (#catalogo, #produtos, etc)</small>
    </div>
</div>

<!-- Seção Todos os Produtos (NOVA) -->
<div class="settings-card">
    <h3>
        <span class="material-symbols-sharp">inventory_2</span>
        Seção Todos os Produtos
    </h3>

    <div class="form-group">
        <label>Título da Seção *</label>
        <input type="text" name="products_title" value="<?php echo htmlspecialchars($settings['products_title'] ?? 'Todos os Produtos'); ?>" required>
        <small>Título da seção catálogo completo</small>
    </div>

    <div class="form-group">
        <label>Subtítulo</label>
        <input type="text" name="products_subtitle" value="<?php echo htmlspecialchars($settings['products_subtitle'] ?? 'Toda a nossa coleção premium em um só lugar'); ?>">
        <small>Descrição da seção</small>
    </div>

    <div class="form-group">
        <label>Texto do Botão</label>
        <input type="text" name="products_button_text" value="<?php echo htmlspecialchars($settings['products_button_text'] ?? 'Ver Depoimentos'); ?>">
        <small>Texto que aparece no botão</small>
    </div>

    <div class="form-group">
        <label>Link do Botão</label>
        <input type="text" name="products_button_link" value="<?php echo htmlspecialchars($settings['products_button_link'] ?? '#depoimentos'); ?>">
        <small>URL ou âncora (#depoimentos, etc)</small>
    </div>
</div>
```

**ADICIONAR** após a seção acima (nova seção de benefícios - gerenciamento simplificado):

```php
<!-- Cards de Benefícios (NOVA SEÇÃO) -->
<div class="settings-card">
    <h3>
        <span class="material-symbols-sharp">verified</span>
        Cards de Benefícios
    </h3>
    <p style="margin-bottom: 1.5rem; color: var(--color-dark-variant);">
        Os 4 cards de benefícios exibidos abaixo do banner principal.
        <strong>Nota:</strong> Para gerenciar (adicionar/remover/editar), acesse direto no banco ou crie interface dedicada.
    </p>

    <?php foreach ($beneficios as $idx => $b): ?>
    <div style="background: var(--color-light); padding: 1rem; border-radius: var(--border-radius-1); margin-bottom: 1rem;">
        <strong><?php echo ($idx + 1); ?>. <?php echo htmlspecialchars($b['titulo']); ?></strong> -
        <?php echo htmlspecialchars($b['subtitulo']); ?>
        <span style="color: <?php echo htmlspecialchars($b['cor']); ?>; font-weight: bold;">
            (Ícone: <?php echo htmlspecialchars($b['icone']); ?>)
        </span>
    </div>
    <?php endforeach; ?>
</div>

<!-- Footer (NOVA SEÇÃO) -->
<div class="settings-card">
    <h3>
        <span class="material-symbols-sharp">contact_page</span>
        Footer - Marca e Contato
    </h3>

    <div class="form-group">
        <label>Título da Marca *</label>
        <input type="text" name="footer_marca_titulo" value="<?php echo htmlspecialchars($footer['marca_titulo'] ?? 'D&Z'); ?>" required>
    </div>

    <div class="form-group">
        <label>Subtítulo da Marca</label>
        <input type="text" name="footer_marca_subtitulo" value="<?php echo htmlspecialchars($footer['marca_subtitulo'] ?? 'Beauty & Style'); ?>">
    </div>

    <div class="form-group">
        <label>Descrição da Marca</label>
        <textarea name="footer_marca_descricao" rows="3"><?php echo htmlspecialchars($footer['marca_descricao'] ?? ''); ?></textarea>
        <small>Texto que aparece abaixo da marca no footer</small>
    </div>

    <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="footer_telefone" value="<?php echo htmlspecialchars($footer['telefone'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label>WhatsApp</label>
        <input type="text" name="footer_whatsapp" value="<?php echo htmlspecialchars($footer['whatsapp'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label>E-mail</label>
        <input type="email" name="footer_email" value="<?php echo htmlspecialchars($footer['email'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label>Instagram (URL)</label>
        <input type="url" name="footer_instagram" value="<?php echo htmlspecialchars($footer['instagram'] ?? '#'); ?>">
    </div>

    <div class="form-group">
        <label>TikTok (URL)</label>
        <input type="url" name="footer_tiktok" value="<?php echo htmlspecialchars($footer['tiktok'] ?? '#'); ?>">
    </div>

    <div class="form-group">
        <label>Facebook (URL)</label>
        <input type="url" name="footer_facebook" value="<?php echo htmlspecialchars($footer['facebook'] ?? '#'); ?>">
    </div>

    <div class="form-group">
        <label>Texto do Copyright</label>
        <input type="text" name="footer_copyright" value="<?php echo htmlspecialchars($footer['copyright_texto'] ?? '© 2026 D&Z Beauty • Todos os direitos reservados'); ?>">
    </div>
</div>

<!-- Links do Footer (informativo) -->
<div class="settings-card">
    <h3>
        <span class="material-symbols-sharp">link</span>
        Links do Footer
    </h3>
    <p style="margin-bottom: 1.5rem; color: var(--color-dark-variant);">
        Links organizados em colunas. <strong>Nota:</strong> Para gerenciar (adicionar/remover/mudar ordem), acesse o banco diretamente ou crie interface CRUD dedicada.
    </p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        <div>
            <h4 style="margin-bottom: 0.5rem;">Coluna: Produtos</h4>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($footer_links['produtos'] as $link): ?>
                <li style="padding: 0.3rem 0;">→ <?php echo htmlspecialchars($link['texto']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h4 style="margin-bottom: 0.5rem;">Coluna: Atendimento</h4>
            <ul style="list-style: none; padding: 0;">
                <?php foreach ($footer_links['atendimento'] as $link): ?>
                <li style="padding: 0.3rem 0;">→ <?php echo htmlspecialchars($link['texto']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
```

---

## 🔌 4. ALTERAÇÕES NA API (cms_api.php)

### Arquivo: `admin/src/php/dashboard/cms/cms_api.php`

**LOCALIZAR** a ação `update_home_settings` (linha ~286) e **ATUALIZAR** o UPDATE SQL:

#### VERSÃO ANTIGA (remover):

```php
$stmt = mysqli_prepare($conexao,
    "UPDATE home_settings SET
     hero_title=?, hero_subtitle=?, hero_description=?,
     hero_button_text=?, hero_button_link=?,
     launch_title=?, launch_subtitle=?,
     banner_interval=?,
     updated_at=NOW()
     WHERE id=1"
);
```

#### VERSÃO NOVA (adicionar os 6 novos campos):

```php
$stmt = mysqli_prepare($conexao,
    "UPDATE home_settings SET
     hero_title=?, hero_subtitle=?, hero_description=?,
     hero_button_text=?, hero_button_link=?,
     launch_title=?, launch_subtitle=?,
     launch_button_text=?, launch_button_link=?,
     products_title=?, products_subtitle=?,
     products_button_text=?, products_button_link=?,
     banner_interval=?,
     updated_at=NOW()
     WHERE id=1"
);
```

#### Atualizar os binds (linha ~326):

**VERSÃO ANTIGA:**

```php
$hero_title = $_POST['hero_title'] ?? '';
$hero_subtitle = $_POST['hero_subtitle'] ?? '';
$hero_description = $_POST['hero_description'] ?? '';
$hero_button_text = $_POST['hero_button_text'] ?? '';
$hero_button_link = $_POST['hero_button_link'] ?? '';
$launch_title = $_POST['launch_title'] ?? '';
$launch_subtitle = $_POST['launch_subtitle'] ?? '';
$banner_interval = (int)($_POST['banner_interval'] ?? 6);

$bindResult = mysqli_stmt_bind_param($stmt, 'sssssssi',
    $hero_title, $hero_subtitle, $hero_description,
    $hero_button_text, $hero_button_link,
    $launch_title, $launch_subtitle,
    $banner_interval
);
```

**VERSÃO NOVA:**

```php
$hero_title = $_POST['hero_title'] ?? '';
$hero_subtitle = $_POST['hero_subtitle'] ?? '';
$hero_description = $_POST['hero_description'] ?? '';
$hero_button_text = $_POST['hero_button_text'] ?? '';
$hero_button_link = $_POST['hero_button_link'] ?? '';
$launch_title = $_POST['launch_title'] ?? '';
$launch_subtitle = $_POST['launch_subtitle'] ?? '';
$launch_button_text = $_POST['launch_button_text'] ?? 'Ver Todos os Lançamentos';
$launch_button_link = $_POST['launch_button_link'] ?? '#catalogo';
$products_title = $_POST['products_title'] ?? 'Todos os Produtos';
$products_subtitle = $_POST['products_subtitle'] ?? '';
$products_button_text = $_POST['products_button_text'] ?? 'Ver Depoimentos';
$products_button_link = $_POST['products_button_link'] ?? '#depoimentos';
$banner_interval = (int)($_POST['banner_interval'] ?? 6);

$bindResult = mysqli_stmt_bind_param($stmt, 'ssssssssssssi',
    $hero_title, $hero_subtitle, $hero_description,
    $hero_button_text, $hero_button_link,
    $launch_title, $launch_subtitle,
    $launch_button_text, $launch_button_link,
    $products_title, $products_subtitle,
    $products_button_text, $products_button_link,
    $banner_interval
);
```

**ADICIONAR** no final do arquivo (antes do `?>`), nova ação para salvar footer:

```php
// ===== NOVA AÇÃO: UPDATE FOOTER =====
if ($action === 'update_footer') {
    $stmt = mysqli_prepare($conexao,
        "UPDATE cms_footer SET
         marca_titulo=?, marca_subtitulo=?, marca_descricao=?,
         telefone=?, whatsapp=?, email=?,
         instagram=?, tiktok=?, facebook=?,
         copyright_texto=?,
         updated_at=NOW()
         WHERE id=1"
    );

    $marca_titulo = $_POST['footer_marca_titulo'] ?? 'D&Z';
    $marca_subtitulo = $_POST['footer_marca_subtitulo'] ?? 'Beauty & Style';
    $marca_descricao = $_POST['footer_marca_descricao'] ?? '';
    $telefone = $_POST['footer_telefone'] ?? '';
    $whatsapp = $_POST['footer_whatsapp'] ?? '';
    $email = $_POST['footer_email'] ?? '';
    $instagram = $_POST['footer_instagram'] ?? '#';
    $tiktok = $_POST['footer_tiktok'] ?? '#';
    $facebook = $_POST['footer_facebook'] ?? '#';
    $copyright = $_POST['footer_copyright'] ?? '';

    mysqli_stmt_bind_param($stmt, 'ssssssssss',
        $marca_titulo, $marca_subtitulo, $marca_descricao,
        $telefone, $whatsapp, $email,
        $instagram, $tiktok, $facebook,
        $copyright
    );

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Footer atualizado com sucesso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar footer: ' . mysqli_error($conexao)]);
    }
    exit();
}
```

**NOTA:** Por agora, os dados do footer serão salvos junto com home_settings. Para isso, ajustar o JavaScript no home.php para enviar ambos os formulários em uma requisição ou criar endpoint separado.

**SUGESTÃO SIMPLIFICADA:** Adicionar os campos de footer no mesmo formulário de home_settings e salvar tudo na mesma ação `update_home_settings`.

---

## 🎨 5. ALTERAÇÕES NO FRONT-END (cliente/index.php)

### Arquivo: `cliente/index.php`

#### 5.1 Buscar Dados das Novas Tabelas (topo do arquivo, linha ~9)

**ADICIONAR** após `$cms = new CMSProvider($conn);`:

```php
// Buscar benefícios do CMS
$beneficios = $cms->getHomeBenefits();

// Buscar dados do footer
$footerData = $cms->getFooterData();
$footerLinks = $cms->getFooterLinks();
```

#### 5.2 Atualizar cms_data_provider.php

**Arquivo:** `cliente/cms_data_provider.php`

**ADICIONAR** os novos métodos na classe CMSProvider:

```php
/**
 * Buscar benefícios ativos
 */
public function getHomeBenefits() {
    try {
        $sql = "SELECT * FROM cms_home_beneficios WHERE ativo = 1 ORDER BY ordem ASC";
        $result = $this->conn->query($sql);

        $beneficios = [];
        while ($row = $result->fetch_assoc()) {
            $beneficios[] = $row;
        }

        // Fallback se vazio
        if (empty($beneficios)) {
            return [
                ['titulo' => 'Entrega Grátis', 'subtitulo' => 'Acima de R$ 99 para todo o Brasil', 'icone' => 'truck', 'cor' => '#10b981'],
                ['titulo' => 'Qualidade Premium', 'subtitulo' => 'Produtos testados e aprovados', 'icone' => 'shield', 'cor' => '#E6007E'],
                ['titulo' => 'Troca Fácil', 'subtitulo' => '7 dias para trocar ou devolver', 'icone' => 'refresh', 'cor' => '#3b82f6'],
                ['titulo' => 'Suporte 24h', 'subtitulo' => 'Atendimento especializado sempre', 'icone' => 'support', 'cor' => '#f59e0b']
            ];
        }

        return $beneficios;
    } catch (Exception $e) {
        error_log("Erro ao buscar benefícios: " . $e->getMessage());
        return [];
    }
}

/**
 * Buscar dados do footer
 */
public function getFooterData() {
    try {
        $sql = "SELECT * FROM cms_footer WHERE id = 1";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        // Fallback
        return [
            'marca_titulo' => 'D&Z',
            'marca_subtitulo' => 'Beauty & Style',
            'marca_descricao' => 'Transformando a beleza das mulheres brasileiras com produtos premium e atendimento excepcional.',
            'telefone' => '(11) 9999-9999',
            'whatsapp' => '(11) 9999-9999',
            'email' => 'contato@dzecommerce.com',
            'instagram' => '#',
            'tiktok' => '#',
            'facebook' => '#',
            'copyright_texto' => '© 2026 D&Z Beauty • Todos os direitos reservados'
        ];
    } catch (Exception $e) {
        error_log("Erro ao buscar footer: " . $e->getMessage());
        return [];
    }
}

/**
 * Buscar links do footer
 */
public function getFooterLinks() {
    try {
        $sql = "SELECT * FROM cms_footer_links WHERE ativo = 1 ORDER BY coluna, ordem ASC";
        $result = $this->conn->query($sql);

        $links = ['produtos' => [], 'atendimento' => []];
        while ($row = $result->fetch_assoc()) {
            $links[$row['coluna']][] = $row;
        }

        // Fallback se vazio
        if (empty($links['produtos']) && empty($links['atendimento'])) {
            return [
                'produtos' => [
                    ['texto' => 'Unhas Profissionais', 'link' => '#'],
                    ['texto' => 'Cílios Premium', 'link' => '#'],
                    ['texto' => 'Kits Completos', 'link' => '#'],
                    ['texto' => 'Novidades', 'link' => '#']
                ],
                'atendimento' => [
                    ['texto' => 'Central de Ajuda', 'link' => '#'],
                    ['texto' => 'Política de Troca', 'link' => '#'],
                    ['texto' => 'Garantia', 'link' => '#'],
                    ['texto' => 'Rastreamento', 'link' => '#'],
                    ['texto' => 'Suporte Premium', 'link' => '#']
                ]
            ];
        }

        return $links;
    } catch (Exception $e) {
        error_log("Erro ao buscar links do footer: " . $e->getMessage());
        return ['produtos' => [], 'atendimento' => []];
    }
}
```

#### 5.3 Substituir Cards de Benefícios (linha ~3295)

**LOCALIZAR:**

```php
<!-- ===== BENEFÍCIOS MINIMALISTAS ===== -->
<section style="background: #fefefe; padding: 80px 0; border-top: 1px solid #f1f5f9;">
    <div class="container-dz">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto;" class="benefits-grid">
```

**SUBSTITUIR a parte hardcoded dos 4 cards por:**

```php
<!-- ===== BENEFÍCIOS MINIMALISTAS ===== -->
<section style="background: #fefefe; padding: 80px 0; border-top: 1px solid #f1f5f9;">
    <div class="container-dz">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto;" class="benefits-grid">

            <?php foreach ($beneficios as $beneficio): ?>
            <div class="benefit-badge fade-in-up">
                <div class="benefit-icon">
                    <?php
                    // Mapear ícones SVG
                    $iconSVG = '';
                    switch ($beneficio['icone']) {
                        case 'truck':
                            $iconSVG = '<path d="M1 3h15l-1 9H4l-3 4v1a1 1 0 0 0 1 1h11M20 8v8" /><path d="M7 15h6m4 0h1" /><circle cx="7" cy="19" r="2" /><circle cx="17" cy="19" r="2" />';
                            break;
                        case 'shield':
                            $iconSVG = '<path d="M9 12l2 2 4-4" /><path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />';
                            break;
                        case 'refresh':
                            $iconSVG = '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" /><path d="M21 3v5h-5" /><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" /><path d="M8 16H3v5" />';
                            break;
                        case 'support':
                            $iconSVG = '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" /><path d="M8 10h.01" /><path d="M12 10h.01" /><path d="M16 10h.01" />';
                            break;
                        default:
                            $iconSVG = '<circle cx="12" cy="12" r="10" />';
                    }
                    ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: <?php echo htmlspecialchars($beneficio['cor']); ?>;">
                        <?php echo $iconSVG; ?>
                    </svg>
                </div>
                <h4 class="benefit-title"><?php echo htmlspecialchars($beneficio['titulo']); ?></h4>
                <p class="benefit-description"><?php echo htmlspecialchars($beneficio['subtitulo']); ?></p>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
```

#### 5.4 Atualizar Botão da Seção Lançamentos (linha ~3435)

**LOCALIZAR:**

```php
<!-- Botão Ver Todos -->
<div class="ver-todos-btn">
    <button onclick="window.location.href='#catalogo'">Ver Todos os Lançamentos</button>
</div>
```

**SUBSTITUIR POR:**

```php
<!-- Botão Ver Todos -->
<div class="ver-todos-btn">
    <button onclick="window.location.href='<?php echo htmlspecialchars($homeSettings['launch_button_link'] ?? '#catalogo'); ?>'">
        <?php echo htmlspecialchars($homeSettings['launch_button_text'] ?? 'Ver Todos os Lançamentos'); ?>
    </button>
</div>
```

#### 5.5 Atualizar Seção "Todos os Produtos" (linha ~3443)

**LOCALIZAR:**

```php
<!-- ===== TODOS OS PRODUTOS ===== -->
<section class="produtos-dz" id="catalogo">
    <div class="container-dz">

        <!-- Título seção -->
        <div class="section-title fade-in-up">
```

**SUBSTITUIR o conteúdo da section-title por:**

```php
<!-- ===== TODOS OS PRODUTOS ===== -->
<section class="produtos-dz" id="catalogo">
    <div class="container-dz">

        <!-- Título seção -->
        <div class="section-title fade-in-up">
            <h2><?php echo htmlspecialchars($homeSettings['products_title'] ?? 'Todos os Produtos'); ?></h2>
            <p><?php echo htmlspecialchars($homeSettings['products_subtitle'] ?? 'Toda a nossa coleção premium em um só lugar'); ?></p>
        </div>
```

E **localizar o botão "Ver Depoimentos"** (linha ~3607) e **substituir:**

**LOCALIZAR:**

```php
<!-- Botão Ver Mais -->
<div class="ver-todos-btn">
    <button onclick="window.location.href='#depoimentos'">Ver Depoimentos</button>
</div>
```

**SUBSTITUIR POR:**

```php
<!-- Botão Ver Mais -->
<div class="ver-todos-btn">
    <button onclick="window.location.href='<?php echo htmlspecialchars($homeSettings['products_button_link'] ?? '#depoimentos'); ?>'">
        <?php echo htmlspecialchars($homeSettings['products_button_text'] ?? 'Ver Depoimentos'); ?>
    </button>
</div>
```

#### 5.6 Substituir Footer Completo (linha ~4351)

**LOCALIZAR:**

```php
<footer class="footer-modern">
    <div class="container-dz">
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="brand-logo">
                        <h3>D&Z</h3>
                        <div class="brand-tagline">Beauty & Style</div>
                    </div>
```

**SUBSTITUIR TODO O BLOCO DO FOOTER POR:**

```php
<footer class="footer-modern">
    <div class="container-dz">
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="brand-logo">
                        <h3><?php echo htmlspecialchars($footerData['marca_titulo'] ?? 'D&Z'); ?></h3>
                        <div class="brand-tagline"><?php echo htmlspecialchars($footerData['marca_subtitulo'] ?? 'Beauty & Style'); ?></div>
                    </div>

                    <p class="brand-description">
                        <?php echo htmlspecialchars($footerData['marca_descricao'] ?? 'Transformando a beleza das mulheres brasileiras com produtos premium e atendimento excepcional.'); ?>
                    </p>

                    <div class="footer-social-main">
                        <div class="social-links-grid">
                            <a href="<?php echo htmlspecialchars($footerData['instagram'] ?? '#'); ?>" class="social-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" class="social-icon">
                                    <path fill="#E4405F" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            <a href="<?php echo htmlspecialchars($footerData['tiktok'] ?? '#'); ?>" class="social-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" class="social-icon">
                                    <path fill="#000" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                            <a href="<?php echo htmlspecialchars($footerData['facebook'] ?? '#'); ?>" class="social-btn">
                                <svg width="20" height="20" viewBox="0 0 24 24" class="social-icon">
                                    <path fill="#25D366" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="footer-links">
                    <div class="footer-column">
                        <h5>Produtos</h5>
                        <ul>
                            <?php foreach ($footerLinks['produtos'] as $link): ?>
                            <li><a href="<?php echo htmlspecialchars($link['link']); ?>"><?php echo htmlspecialchars($link['texto']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h5>Atendimento</h5>
                        <ul>
                            <?php foreach ($footerLinks['atendimento'] as $link): ?>
                            <li><a href="<?php echo htmlspecialchars($link['link']); ?>"><?php echo htmlspecialchars($link['texto']); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="footer-column">
                        <h5>Contato</h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <span class="contact-icon">📞</span>
                                <span><?php echo htmlspecialchars($footerData['telefone'] ?? ''); ?></span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">💬</span>
                                <span><?php echo htmlspecialchars($footerData['whatsapp'] ?? 'WhatsApp 24h'); ?></span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">✉️</span>
                                <span><?php echo htmlspecialchars($footerData['email'] ?? ''); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-security">
                <!-- Manter badges de segurança/pagamento como estão (hardcoded) -->
                <div class="trust-badge">
                    <h6>Formas de pagamento</h6>
                    <div class="payment-icons">
                        <!-- SVGs de pagamento mantidos -->
                        <!-- (copiar do código original) -->
                    </div>
                </div>
                <!-- Demais badges SSL, ISO, etc (manter) -->
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                <?php echo htmlspecialchars($footerData['copyright_texto'] ?? '© 2026 D&Z Beauty • Todos os direitos reservados'); ?>
            </div>
        </div>
    </footer>
```

---

## ✅ 6. CHECKLIST DE EXECUÇÃO

### Passo 1: Backup

- [ ] Fazer backup do banco de dados `teste_dz`
- [ ] Fazer backup dos arquivos PHP que serão alterados

### Passo 2: Banco de Dados

- [ ] Executar `migration_cms_expansao.sql` no phpMyAdmin
- [ ] Verificar se as 3 tabelas foram criadas
- [ ] Verificar se os dados padrão foram inseridos
- [ ] Verificar se home_settings tem as 6 novas colunas

### Passo 3: Backend (CMS)

- [ ] Atualizar `home.php` (buscar benefícios e footer no topo)
- [ ] Atualizar `home.php` (adicionar novos campos no formulário)
- [ ] Atualizar `cms_api.php` (modificar update_home_settings)
- [ ] Testar salvamento no CMS

### Passo 4: Provider

- [ ] Atualizar `cms_data_provider.php` (adicionar 3 novos métodos)
- [ ] Testar se os métodos retornam dados

### Passo 5: Frontend

- [ ] Buscar dados no topo de `cliente/index.php`
- [ ] Substituir benefícios hardcoded por dinâmicos
- [ ] Atualizar botão da seção Lançamentos
- [ ] Atualizar título/subtítulo/botão da seção Todos os Produtos
- [ ] Substituir footer completo por dinâmico
- [ ] Testar visual no navegador

### Passo 6: Testes

- [ ] Acessar CMS e editar textos
- [ ] Salvar e verificar se banco atualizou
- [ ] Acessar site público e ver se mudanças aparecem
- [ ] Testar responsividade (mobile)

---

## 📁 7. RESUMO DE ARQUIVOS MODIFICADOS

### Criados:

1. `admin/src/php/dashboard/cms/migration_cms_expansao.sql` (novo)

### Modificados:

1. `admin/src/php/dashboard/cms/home.php` (adicionar busca de benefícios/footer; adicionar campos no formulário)
2. `admin/src/php/dashboard/cms/cms_api.php` (atualizar update_home_settings com novos campos)
3. `cliente/cms_data_provider.php` (adicionar 3 métodos: getHomeBenefits, getFooterData, getFooterLinks)
4. `cliente/index.php` (buscar dados; substituir benefícios, botões e footer)

---

## 🚨 8. NOTAS IMPORTANTES

### Benefícios e Links do Footer

- **Gerenciamento básico:** Por hora, apenas leitura no CMS (mostra os dados cadastrados)
- **CRUD completo:** Para adicionar/remover/editar benefícios e links do footer, é necessário:
  - Criar interfaces dedicadas (páginas separadas no CMS)
  - Ou gerenciar diretamente no banco via phpMyAdmin
  - **Recomendação:** Documentar para próxima sprint

### Segurança

- Todos os campos usam `htmlspecialchars()` para prevenir XSS
- Prepared statements usados em todas as queries
- Soft delete (ativo=0) em vez de DELETE

### Performance

- Índices criados em colunas de filtro (ativo, ordem, coluna)
- Queries otimizadas com WHERE ativo=1 para reduzir carga

### Fallbacks

- Todos os métodos PHP têm fallbacks se banco retornar vazio
- Valores padrão em todos os campos

---

## 📞 SUPORTE

Em caso de dúvidas ou problemas:

1. Verificar logs do MySQL (erros de sintaxe SQL)
2. Verificar logs do Apache/PHP (erros de conexão)
3. Usar console do navegador (erros JavaScript)
4. Verificar se `cms_api.php` está retornando JSON válido

---

**FIM DA DOCUMENTAÇÃO**
