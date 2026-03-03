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
        .settings-card {
            background: var(--color-white);
            border-radius: var(--border-radius-2);
            padding: 2rem;
            margin-bottom: 1.5rem;
        }
        .settings-card h3 {
            margin-bottom: 1.5rem;
            color: var(--color-dark);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
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
            margin-bottom: 1rem;
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
                  <a href="home.php" class="menu-item-with-submenu panel active">
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
            
            <div class="date">
                <span class="material-symbols-sharp">today</span>
                <p id="current-date"><?php echo date('d/m/Y'); ?></p>
            </div>

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
                </div>

                <div style="text-align: right; margin-top: 2rem;">
                    <button type="submit" class="btn-save">
                        <span class="material-symbols-sharp">save</span>
                        Salvar Configurações
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

    <!-- Configuração Global de Caminhos -->
    <script>
        window.BASE_URL = '<?php echo BASE_URL; ?>';
        window.API_CONTADOR_URL = '<?php echo API_CONTADOR_URL; ?>';
    </script>
    
    <script src="../../../js/dashboard.js"></script>
    <script src="../../../js/contador-auto.js"></script>
    <script>
        // Garantir tema dark
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('darkTheme');
            if (savedTheme === 'true') {
                document.body.classList.add('dark-theme-variables');
            }
        });

        // Salvar configurações
        document.getElementById('homeSettingsForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'update_home_settings');
            
            try {
                const response = await fetch('cms_api.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                
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
        });
    </script>
</body>
</html>
