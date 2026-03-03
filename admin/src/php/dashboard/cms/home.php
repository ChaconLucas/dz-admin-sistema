<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: ../../../../PHP/login.php');
    exit();
}

require_once '../../../../config/base.php';
require_once '../../../../PHP/conexao.php';
require_once '../helper-contador.php';

// Garantir que $nao_lidas existe
if (!isset($nao_lidas)) {
    $nao_lidas = 0;
    try {
        $result = mysqli_query($conexao, "SELECT COUNT(*) as total FROM mensagens WHERE lida = FALSE AND remetente != 'admin'");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $nao_lidas = $row['total'];
        }
    } catch (Exception $e) {
        $nao_lidas = 0;
    }
}

// Buscar configurações atuais
$settings_sql = "SELECT * FROM home_settings WHERE id = 1";
$settings_result = mysqli_query($conexao, $settings_sql);
$settings = mysqli_fetch_assoc($settings_result);

// Se não existir, criar registro padrão
if (!$settings) {
    $insert_sql = "INSERT INTO home_settings (id) VALUES (1)";
    mysqli_query($conexao, $insert_sql);
    $settings_result = mysqli_query($conexao, $settings_sql);
    $settings = mysqli_fetch_assoc($settings_result);
}

// Buscar benefícios (TODOS, não só ativos - para poder reativar)
$beneficios_sql = "SELECT * FROM cms_home_beneficios ORDER BY ordem ASC, id ASC";
$beneficios_result = mysqli_query($conexao, $beneficios_sql);
$beneficios = [];
while ($row = mysqli_fetch_assoc($beneficios_result)) {
    $beneficios[] = $row;
}

// Buscar dados do footer
$footer_sql = "SELECT * FROM cms_footer WHERE id = 1";
$footer_result = mysqli_query($conexao, $footer_sql);
$footer = mysqli_fetch_assoc($footer_result);

if (!$footer) {
    mysqli_query($conexao, "INSERT INTO cms_footer (id) VALUES (1)");
    $footer_result = mysqli_query($conexao, $footer_sql);
    $footer = mysqli_fetch_assoc($footer_result);
}

// Buscar links do footer
$footer_links_sql = "SELECT * FROM cms_footer_links WHERE ativo = 1 ORDER BY coluna, ordem ASC";
$footer_links_result = mysqli_query($conexao, $footer_links_sql);
$footer_links = ['produtos' => [], 'atendimento' => []];
while ($row = mysqli_fetch_assoc($footer_links_result)) {
    $footer_links[$row['coluna']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS - Home (Textos) | D&Z Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="stylesheet" href="../../../css/dashboard-sections.css">
    <link rel="stylesheet" href="../../../css/dashboard-cards.css">
    <style>
        /* Espaçamento entre seções principais */
        main h1 {
            margin-bottom: 2rem;
        }
        
        main .insights {
            margin-bottom: 2.5rem;
        }
        
        main form {
            margin-bottom: 3rem;
        }
        
        .settings-card {
            background: var(--color-white);
            border-radius: var(--border-radius-2);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .settings-card h3 {
            margin-bottom: 1.5rem;
            color: var(--color-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-group {
            margin-bottom: 2rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--color-dark);
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid var(--color-light);
            border-radius: var(--border-radius-1);
            font-family: inherit;
            font-size: 0.95rem;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group small {
            display: block;
            margin-top: 0.3rem;
            color: var(--color-dark-variant);
        }
        .btn-save {
            background: var(--color-primary);
            color: white;
            padding: 1rem 2.5rem;
            border: none;
            border-radius: var(--border-radius-1);
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        .btn-save:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .success-msg {
            background: var(--color-success);
            color: white;
            padding: 1rem;
            border-radius: var(--border-radius-1);
            margin-bottom: 1.5rem;
            display: none;
        }
        .success-msg.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- SIDEBAR -->
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="../../../../assets/images/Logodz.png" alt="Logo">
                    <a href="../index.php"><h2 class="danger">D&Z</h2></a>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-symbols-sharp">close</span>
                </div>
            </div>

            <div class="sidebar">
                <a href="../index.php">
                    <span class="material-symbols-sharp">grid_view</span>
                    <h3>Painel</h3>
                </a>
                <a href="../customers.php">
                    <span class="material-symbols-sharp">group</span>
                    <h3>Clientes</h3>
                </a>
                <a href="../orders.php">
                    <span class="material-symbols-sharp">Orders</span>
                    <h3>Pedidos</h3>
                </a>
                <a href="../analytics.php">
                    <span class="material-symbols-sharp">Insights</span>
                    <h3>Gráficos</h3>
                </a>
                <a href="../menssage.php">
                    <span class="material-symbols-sharp">Mail</span>
                    <h3>Mensagens</h3>
                    <span class="message-count"><?php echo $nao_lidas; ?></span>
                </a>
                <a href="../products.php">
                    <span class="material-symbols-sharp">Inventory</span>
                    <h3>Produtos</h3>
                </a>
                <a href="../cupons.php">
                    <span class="material-symbols-sharp">sell</span>
                    <h3>Cupons</h3>
                </a>
                <a href="../gestao-fluxo.php">
                    <span class="material-symbols-sharp">account_tree</span>
                    <h3>Gestão de Fluxo</h3>
                </a>
                
                <div class="menu-item-container">
                  <a href="home.php" class="menu-item-with-submenu">
                      <span class="material-symbols-sharp">web</span>
                      <h3>CMS</h3>
                  </a>
                  
                  <div class="submenu">
                    <a href="home.php" class="active">
                      <span class="material-symbols-sharp">home</span>
                      <h3>Home (Textos)</h3>
                    </a>
                    <a href="banners.php">
                      <span class="material-symbols-sharp">view_carousel</span>
                      <h3>Banners</h3>
                    </a>
                    <a href="featured.php">
                      <span class="material-symbols-sharp">star</span>
                      <h3>Lançamentos</h3>
                    </a>
                    <a href="promos.php">
                      <span class="material-symbols-sharp">local_offer</span>
                      <h3>Promoções</h3>
                    </a>
                    <a href="testimonials.php">
                      <span class="material-symbols-sharp">format_quote</span>
                      <h3>Depoimentos</h3>
                    </a>
                    <a href="metrics.php">
                      <span class="material-symbols-sharp">speed</span>
                      <h3>Métricas</h3>
                    </a>
                  </div>
                </div>
                
                <div class="menu-item-container">
                  <a href="../geral.php" class="menu-item-with-submenu">
                      <span class="material-symbols-sharp">Settings</span>
                      <h3>Configurações</h3>
                  </a>
                  
                  <div class="submenu">
                    <a href="../geral.php">
                      <span class="material-symbols-sharp">tune</span>
                      <h3>Geral</h3>
                    </a>
                    <a href="../pagamentos.php">
                      <span class="material-symbols-sharp">payments</span>
                      <h3>Pagamentos</h3>
                    </a>
                    <a href="../frete.php">
                      <span class="material-symbols-sharp">local_shipping</span>
                      <h3>Frete</h3>
                    </a>
                    <a href="../automacao.php">
                      <span class="material-symbols-sharp">automation</span>
                      <h3>Automação</h3>
                    </a>
                    <a href="../metricas.php">
                      <span class="material-symbols-sharp">analytics</span>
                      <h3>Métricas</h3>
                    </a>
                    <a href="../settings.php">
                      <span class="material-symbols-sharp">group</span>
                      <h3>Usuários</h3>
                    </a>
                  </div>
                </div>
                
                <a href="../revendedores.php">
                    <span class="material-symbols-sharp">handshake</span>
                    <h3>Revendedores</h3>
                </a>
                <a href="../../../../PHP/logout.php">
                    <span class="material-symbols-sharp">Logout</span>
                    <h3>Sair</h3>
                </a>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main>
            <h1>CMS > Home (Textos e Configurações)</h1>

            <div class="insights">
                <div class="sales" style="cursor: default;">
                    <span class="material-symbols-sharp">edit_note</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Seção Hero</h3>
                            <small class="text-muted">Banner principal</small>
                        </div>
                    </div>
                </div>
                <div class="expenses" style="cursor: default;">
                    <span class="material-symbols-sharp">star</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Lançamentos</h3>
                            <small class="text-muted">Produtos em destaque</small>
                        </div>
                    </div>
                </div>
                <div class="income" style="cursor: default;">
                    <span class="material-symbols-sharp">update</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Última Atualização</h3>
                            <small class="text-muted"><?php echo $settings['updated_at'] ? date('d/m/Y H:i', strtotime($settings['updated_at'])) : 'Nunca'; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div id="successMsg" class="success-msg">Configurações salvas com sucesso!</div>

            <form id="homeSettingsForm">
                <!-- SEÇÃO HERO -->
                <div class="settings-card">
                    <h3>
                        <span class="material-symbols-sharp">sentiment_very_satisfied</span>
                        Seção Hero (Banner Principal)
                    </h3>
                    
                    <div class="form-group">
                        <label>Título Principal *</label>
                        <input type="text" name="hero_title" value="<?php echo htmlspecialchars($settings['hero_title'] ?? 'Bem-vindo à D&Z'); ?>" required>
                        <small>Título principal que aparece no topo da página</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Subtítulo</label>
                        <input type="text" name="hero_subtitle" value="<?php echo htmlspecialchars($settings['hero_subtitle'] ?? 'Moda e Estilo'); ?>">
                        <small>Texto secundário abaixo do título</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="hero_description"><?php echo htmlspecialchars($settings['hero_description'] ?? 'Descubra as últimas tendências em moda'); ?></textarea>
                        <small>Texto descritivo adicional</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Texto do Botão</label>
                        <input type="text" name="hero_button_text" value="<?php echo htmlspecialchars($settings['hero_button_text'] ?? 'Ver Produtos'); ?>">
                        <small>Texto exibido no botão de ação</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Link do Botão</label>
                        <input type="text" name="hero_button_link" value="<?php echo htmlspecialchars($settings['hero_button_link'] ?? '/produtos'); ?>">
                        <small>URL para onde o botão redireciona</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Intervalo do Carrossel (segundos)</label>
                        <input type="number" name="banner_interval" min="3" max="30" step="1" value="<?php echo htmlspecialchars($settings['banner_interval'] ?? '6'); ?>">
                        <small>Tempo em segundos entre cada troca de banner (3-30 segundos)</small>
                    </div>
                </div>

                <!-- SEÇÃO LANÇAMENTOS -->
                <div class="settings-card">
                    <h3>
                        <span class="material-symbols-sharp">new_releases</span>
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
                        <input type="text" name="launch_button_text" value="<?php echo htmlspecialchars($settings['launch_button_text'] ?? 'Ver Todos os Lançamentos'); ?>">
                        <small>Texto que aparece no botão</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Link do Botão</label>
                        <input type="text" name="launch_button_link" value="<?php echo htmlspecialchars($settings['launch_button_link'] ?? '#catalogo'); ?>">
                        <small>URL ou âncora (#catalogo, #produtos, etc)</small>
                    </div>
                </div>

                <!-- SEÇÃO TODOS OS PRODUTOS -->
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
                    
                    <button type="submit" class="btn-save">
                        <span class="material-symbols-sharp">save</span>
                        Salvar Configurações da Home
                    </button>
                </div>
            </form>

                <!-- CARDS DE BENEFÍCIOS -->
                <div class="settings-card">
                    <h3>
                        <span class="material-symbols-sharp">verified</span>
                        Cards de Benefícios
                    </h3>
                    <p style="margin-bottom: 1.5rem; color: var(--color-dark-variant);">
                        Os cards de benefícios exibidos abaixo do banner principal.
                    </p>
                    
                    <form id="formBeneficios" style="margin-bottom: 2rem;">
                        <div id="beneficios-container">
                            <?php foreach ($beneficios as $idx => $b): ?>
                            <div class="beneficio-item" style="background: var(--color-light); padding: 1.5rem; border-radius: var(--border-radius-1); margin-bottom: 1rem; position: relative;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <strong style="color: var(--color-dark);">Card #<?php echo $b['ordem']; ?></strong>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <label style="display: flex; align-items: center; gap: 0.3rem; margin: 0;">
                                            <input type="checkbox" name="beneficios[<?php echo $b['id']; ?>][ativo]" value="1" <?php echo $b['ativo'] ? 'checked' : ''; ?>>
                                            <span style="font-size: 0.875rem;">Ativo</span>
                                        </label>
                                        <input type="hidden" name="beneficios[<?php echo $b['id']; ?>][id]" value="<?php echo $b['id']; ?>">
                                    </div>
                                </div>
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                    <div class="form-group" style="margin: 0;">
                                        <label style="font-size: 0.875rem; margin-bottom: 0.3rem;">Título</label>
                                        <input type="text" name="beneficios[<?php echo $b['id']; ?>][titulo]" value="<?php echo htmlspecialchars($b['titulo']); ?>" required style="width: 100%;">
                                    </div>
                                    
                                    <div class="form-group" style="margin: 0;">
                                        <label style="font-size: 0.875rem; margin-bottom: 0.3rem;">Ícone (material-symbols-sharp)</label>
                                        <input type="text" name="beneficios[<?php echo $b['id']; ?>][icone]" value="<?php echo htmlspecialchars($b['icone']); ?>" required style="width: 100%;">
                                        <small>Ex: local_shipping, verified, sync, support_agent</small>
                                    </div>
                                </div>
                                
                                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1rem; margin-top: 1rem;">
                                    <div class="form-group" style="margin: 0;">
                                        <label style="font-size: 0.875rem; margin-bottom: 0.3rem;">Subtítulo/Descrição</label>
                                        <input type="text" name="beneficios[<?php echo $b['id']; ?>][subtitulo]" value="<?php echo htmlspecialchars($b['subtitulo']); ?>" required style="width: 100%;">
                                    </div>
                                    
                                    <div class="form-group" style="margin: 0;">
                                        <label style="font-size: 0.875rem; margin-bottom: 0.3rem;">Cor (hex)</label>
                                        <input type="color" name="beneficios[<?php echo $b['id']; ?>][cor]" value="<?php echo htmlspecialchars($b['cor']); ?>" style="width: 100%; height: 38px;">
                                    </div>
                                    
                                    <div class="form-group" style="margin: 0;">
                                        <label style="font-size: 0.875rem; margin-bottom: 0.3rem;">Ordem</label>
                                        <input type="number" name="beneficios[<?php echo $b['id']; ?>][ordem]" value="<?php echo $b['ordem']; ?>" min="1" required style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <button type="button" onclick="salvarBeneficios()" class="btn-primary" style="margin-top: 1rem;">
                            <span class="material-symbols-sharp">save</span>
                            Salvar Alterações nos Cards
                        </button>
                    </form>
                    
                    <!-- Adicionar Novo Card -->
                    <div style="background: #f0f9ff; border: 2px dashed #3b82f6; padding: 1.5rem; border-radius: var(--border-radius-1);">
                        <h4 style="margin-bottom: 1rem; color: #1e40af;">
                            <span class="material-symbols-sharp" style="vertical-align: middle;">add_circle</span>
                            Adicionar Novo Card de Benefício
                        </h4>
                        
                        <form id="formNovoBeneficio">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div class="form-group" style="margin: 0;">
                                    <label>Título *</label>
                                    <input type="text" name="novo_titulo" required placeholder="Ex: Entrega Grátis">
                                </div>
                                
                                <div class="form-group" style="margin: 0;">
                                    <label>Ícone (material-symbols-sharp) *</label>
                                    <input type="text" name="novo_icone" required placeholder="Ex: local_shipping">
                                    <small>Veja ícones em: <a href="https://fonts.google.com/icons" target="_blank">Google Icons</a></small>
                                </div>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div class="form-group" style="margin: 0;">
                                    <label>Subtítulo/Descrição *</label>
                                    <input type="text" name="novo_subtitulo" required placeholder="Ex: Acima de R$ 99">
                                </div>
                                
                                <div class="form-group" style="margin: 0;">
                                    <label>Cor (hex)</label>
                                    <input type="color" name="novo_cor" value="#E6007E" style="height: 38px;">
                                </div>
                                
                                <div class="form-group" style="margin: 0;">
                                    <label>Ordem</label>
                                    <input type="number" name="novo_ordem" value="<?php echo count($beneficios) + 1; ?>" min="1">
                                </div>
                            </div>
                            
                            <button type="button" onclick="adicionarBeneficio()" class="btn-primary">
                                <span class="material-symbols-sharp">add</span>
                                Adicionar Card
                            </button>
                        </form>
                    </div>
                </div>
                
                <script>
                function salvarBeneficios() {
                    console.log('🔵 Iniciando salvarBeneficios()');
                    const form = document.getElementById('formBeneficios');
                    const formData = new FormData(form);
                    formData.append('action', 'update_benefits');
                    
                    // Debug: mostrar dados enviados
                    console.log('📦 Dados do formulário:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                    
                    // Adicionar valores não-checkados como 0
                    const checkboxes = form.querySelectorAll('input[type="checkbox"][name*="[ativo]"]');
                    checkboxes.forEach(cb => {
                        if (!cb.checked) {
                            const name = cb.name;
                            formData.set(name, '0');
                            console.log('⬜ Checkbox desmarcado:', name, '→ 0');
                        }
                    });
                    
                    console.log('🌐 Enviando requisição para cms_api.php...');
                    
                    fetch('cms_api.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('📥 Resposta recebida. Status:', response.status);
                        if (!response.ok) {
                            throw new Error('HTTP ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Dados JSON:', data);
                        if (data.success) {
                            alert('✅ Cards salvos com sucesso!');
                            location.reload();
                        } else {
                            console.error('❌ Erro do servidor:', data);
                            alert('❌ Erro: ' + (data.message || 'Erro desconhecido'));
                        }
                    })
                    .catch(error => {
                        console.error('💥 Erro na requisição:', error);
                        alert('❌ Erro na comunicação: ' + error.message);
                    });
                }
                
                function adicionarBeneficio() {
                    console.log('🔵 Iniciando adicionarBeneficio()');
                    const form = document.getElementById('formNovoBeneficio');
                    const formData = new FormData(form);
                    formData.append('action', 'add_benefit');
                    
                    // Debug
                    console.log('📦 Dados do novo benefício:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                    
                    console.log('🌐 Enviando requisição para cms_api.php...');
                    
                    fetch('cms_api.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        console.log('📥 Resposta recebida. Status:', response.status);
                        if (!response.ok) {
                            throw new Error('HTTP ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('✅ Dados JSON:', data);
                        if (data.success) {
                            alert('✅ Novo card adicionado!');
                            location.reload();
                        } else {
                            console.error('❌ Erro do servidor:', data);
                            alert('❌ Erro: ' + (data.message || 'Erro desconhecido'));
                        }
                    })
                    .catch(error => {
                        console.error('💥 Erro na requisição:', error);
                        alert('❌ Erro na comunicação: ' + error.message);
                    });
                }
                </script>

                <!-- FOOTER - MARCA E CONTATO -->
                <form id="footerSettingsForm">
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
                        <input type="text" name="footer_email" value="<?php echo htmlspecialchars($footer['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Instagram (URL)</label>
                        <input type="text" name="footer_instagram" value="<?php echo htmlspecialchars($footer['instagram'] ?? '#'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>TikTok (URL)</label>
                        <input type="text" name="footer_tiktok" value="<?php echo htmlspecialchars($footer['tiktok'] ?? '#'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Facebook (URL)</label>
                        <input type="text" name="footer_facebook" value="<?php echo htmlspecialchars($footer['facebook'] ?? '#'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Texto do Copyright</label>
                        <input type="text" name="footer_copyright" value="<?php echo htmlspecialchars($footer['copyright_texto'] ?? '© 2026 D&Z Beauty • Todos os direitos reservados'); ?>">
                    </div>
                </div>

                <!-- LINKS DO FOOTER -->
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

                <div style="text-align: right; margin-top: 2rem;">
                    <button type="submit" class="btn-save">
                        <span class="material-symbols-sharp">save</span>
                        Salvar Configurações do Footer
                    </button>
                </div>
                </form>
        </main>

        <!-- RIGHT SECTION -->
        <div class="right">
            <div class="top">
                <button id="menu-btn">
                    <span class="material-symbols-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-symbols-sharp active">light_mode</span>
                    <span class="material-symbols-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Olá, <b><?php echo isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Admin'; ?></b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../../../../assets/images/Logodz.png" alt="Logo D&Z">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Garantir tema dark
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('darkTheme');
            if (savedTheme === 'true') {
                document.body.classList.add('dark-theme-variables');
                // Atualizar ícones do toggler
                const themeToggler = document.querySelector('.theme-toggler');
                themeToggler.querySelector('span:nth-child(1)').classList.remove('active');
                themeToggler.querySelector('span:nth-child(2)').classList.add('active');
            }
            
            // Theme toggler click handler
            const themeToggler = document.querySelector('.theme-toggler');
            themeToggler.addEventListener('click', () => {
                document.body.classList.toggle('dark-theme-variables');
                
                themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
                themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
                
                // Salvar preferência
                if (document.body.classList.contains('dark-theme-variables')) {
                    localStorage.setItem('darkTheme', 'true');
                } else {
                    localStorage.setItem('darkTheme', 'false');
                }
            });
        });

        // Salvar configurações (função genérica)
        async function salvarConfiguracoes(formElement) {
            const formData = new FormData(formElement);
            formData.append('action', 'update_home_settings');
            
            try {
                const response = await fetch('cms_api.php', {
                    method: 'POST',
                    body: formData
                });
                
                const text = await response.text();
                console.log('Resposta da API:', text);
                
                let result;
                try {
                    result = JSON.parse(text);
                } catch (parseError) {
                    console.error('Erro ao fazer parse do JSON:', parseError);
                    console.error('Resposta recebida:', text);
                    alert('Erro ao processar resposta do servidor. Verifique o console para detalhes.');
                    return;
                }
                
                if (result.success) {
                    const successMsg = document.getElementById('successMsg');
                    successMsg.classList.add('show');
                    setTimeout(() => {
                        successMsg.classList.remove('show');
                    }, 3000);
                    
                    // Atualizar timestamp
                    setTimeout(() => location.reload(), 1000);
                } else {
                    alert('Erro: ' + result.message);
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Erro ao salvar configurações');
            }
        }
        
        // Aplicar aos formulários
        document.getElementById('homeSettingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            salvarConfiguracoes(this);
        });
        
        document.getElementById('footerSettingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            salvarConfiguracoes(this);
        });
    </script>
</body>
</html>
