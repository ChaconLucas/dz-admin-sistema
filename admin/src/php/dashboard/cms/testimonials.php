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

/*
TODO - IMPLEMENTAR:
- Tabela: cms_testimonials (id, nome_cliente, cargo, empresa, depoimento, avatar, avaliacao, ativo, ordem, created_at, updated_at)
- CRUD completo de depoimentos:
  * Nome do cliente
  * Cargo/função (opcional)
  * Empresa (opcional)
  * Texto do depoimento
  * Upload de foto/avatar
  * Avaliação (1-5 estrelas)
  * Ordenação
  * Ativar/desativar
- Preview da seção de depoimentos
- Validação de texto (limite de caracteres)
*/
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS - Depoimentos | D&Z Admin</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>admin/favicon.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="../../../css/dashboard.css">
    <link rel="stylesheet" href="../../../css/dashboard-sections.css">
    <link rel="stylesheet" href="../../../css/dashboard-cards.css">
    <style>
        /* Override mínimo: mudar cor do item CMS de verde para rosa + aplicar layout padrão */
        aside .sidebar .menu-item-container a.menu-item-with-submenu.active {
            background: rgba(255, 0, 212, 0.1) !important;
            color: #ff00d4 !important;
            margin-left: 1.5rem !important;
            margin-right: 0.5rem !important;
            border-left: 5px solid #ff00d4 !important;
            border-radius: 0 8px 8px 0 !important;
        }
        
        aside .sidebar .menu-item-container a.menu-item-with-submenu.active span,
        aside .sidebar .menu-item-container a.menu-item-with-submenu.active h3 {
            color: #ff00d4 !important;
            font-weight: 600 !important;
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
                    <a href="home.php">
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
                    <a href="testimonials.php" class="active">
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
            <h1>CMS > Depoimentos de Clientes</h1>

            <div class="insights">
                <div class="sales" style="cursor: default;">
                    <span class="material-symbols-sharp">format_quote</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Depoimentos Ativos</h3>
                            <h1>0</h1>
                        </div>
                    </div>
                </div>
                <div class="expenses" style="cursor: default;">
                    <span class="material-symbols-sharp">sentiment_satisfied</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Cadastrados</h3>
                            <h1>0</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Principal -->
            <div class="recent-orders" style="margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h2>Gerenciar Depoimentos</h2>
                    <button class="btn" style="padding: 0.8rem 1.5rem; background: var(--color-primary); color: white; border: none; border-radius: var(--border-radius-1); cursor: not-allowed; opacity: 0.6;">
                        <span class="material-symbols-sharp" style="vertical-align: middle;">add</span>
                        Novo Depoimento
                    </button>
                </div>
                <div style="padding: 2rem; background: var(--color-white); border-radius: var(--border-radius-2);">
                    <div style="text-align: center; padding: 3rem 2rem; color: var(--color-dark-variant);">
                        <span class="material-symbols-sharp" style="font-size: 4rem; color: var(--color-primary); display: block; margin-bottom: 1rem;">reviews</span>
                        <h3 style="margin-bottom: 0.8rem;">Funcionalidade em Desenvolvimento</h3>
                        <p style="line-height: 1.6; max-width: 600px; margin: 0 auto;">
                            Aqui você poderá adicionar e gerenciar depoimentos de clientes satisfeitos:
                        </p>
                        <ul style="text-align: left; max-width: 600px; margin: 1.5rem auto; line-height: 2;">
                            <li>Adicionar nome do cliente</li>
                            <li>Cargo e empresa (opcional)</li>
                            <li>Texto do depoimento</li>
                            <li>Upload de foto/avatar do cliente</li>
                            <li>Avaliação (1 a 5 estrelas)</li>
                            <li>Reordenar e ativar/desativar depoimentos</li>
                        </ul>
                        <div style="margin-top: 2rem;">
                            <a href="../index.php" class="btn" style="display: inline-block; padding: 1rem 2rem; background: var(--color-primary); color: white; text-decoration: none; border-radius: var(--border-radius-1);">
                                <span class="material-symbols-sharp" style="vertical-align: middle;">arrow_back</span>
                                Voltar ao Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
</body>
</html>
