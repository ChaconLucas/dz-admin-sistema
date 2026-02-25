<?php
session_start();
require_once '../config.php';

// Verificar se está logado
if (!isset($_SESSION['cliente'])) {
    header('Location: login.php');
    exit;
}

$nomeUsuario = htmlspecialchars($_SESSION['cliente']['nome']);
$emailUsuario = htmlspecialchars($_SESSION['cliente']['email']);
$clienteId = $_SESSION['cliente']['id'];
$usuarioLogado = true;

$sucesso = '';
$erro = '';

// Processar atualização de dados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_dados'])) {
    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $whatsapp = trim($_POST['whatsapp']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $cep = trim($_POST['cep']);
    $rua = trim($_POST['rua']);
    $numero = trim($_POST['numero']);
    $complemento = trim($_POST['complemento']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $uf = trim($_POST['uf']);
    
    // Validações básicas
    if (empty($nome)) {
        $erro = "O nome é obrigatório.";
    } elseif (empty($telefone)) {
        $erro = "O telefone é obrigatório.";
    } else {
        try {
            $stmt = $pdo->prepare("
                UPDATE clientes 
                SET nome = ?, telefone = ?, whatsapp = ?, data_nascimento = ?, 
                    cep = ?, rua = ?, numero = ?, complemento = ?, bairro = ?, cidade = ?, uf = ?,
                    data_ultima_atualizacao = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $nome, $telefone, $whatsapp, $data_nascimento ?: null, 
                $cep, $rua, $numero, $complemento, $bairro, $cidade, $uf, 
                $clienteId
            ]);
            
            // Atualizar session
            $_SESSION['cliente']['nome'] = $nome;
            $nomeUsuario = htmlspecialchars($nome);
            
            $sucesso = "Dados atualizados com sucesso!";
        } catch (PDOException $e) {
            error_log("Erro ao atualizar cliente: " . $e->getMessage());
            $erro = "Erro ao atualizar dados. Tente novamente.";
        }
    }
}

// Processar alteração de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alterar_senha'])) {
    $senha_atual = $_POST['senha_atual'];
    $senha_nova = $_POST['senha_nova'];
    $senha_confirmar = $_POST['senha_confirmar'];
    
    if (empty($senha_atual) || empty($senha_nova) || empty($senha_confirmar)) {
        $erro = "Todos os campos de senha são obrigatórios.";
    } elseif ($senha_nova !== $senha_confirmar) {
        $erro = "A nova senha e a confirmação não coincidem.";
    } elseif (strlen($senha_nova) < 6) {
        $erro = "A nova senha deve ter pelo menos 6 caracteres.";
    } else {
        try {
            // Verificar senha atual
            $stmt = $pdo->prepare("SELECT senha FROM clientes WHERE id = ?");
            $stmt->execute([$clienteId]);
            $cliente_senha = $stmt->fetch();
            
            if ($cliente_senha && password_verify($senha_atual, $cliente_senha['senha'])) {
                // Atualizar senha
                $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE clientes SET senha = ? WHERE id = ?");
                $stmt->execute([$senha_hash, $clienteId]);
                
                $sucesso = "Senha alterada com sucesso!";
            } else {
                $erro = "Senha atual incorreta.";
            }
        } catch (PDOException $e) {
            error_log("Erro ao alterar senha: " . $e->getMessage());
            $erro = "Erro ao alterar senha. Tente novamente.";
        }
    }
}

// Buscar dados do cliente
try {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = ? LIMIT 1");
    $stmt->execute([$clienteId]);
    $cliente = $stmt->fetch();
    
    if (!$cliente) {
        session_destroy();
        header('Location: login.php');
        exit;
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar cliente: " . $e->getMessage());
    $erro = "Erro ao carregar dados.";
}

$pageTitle = 'Minha Conta - D&Z';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../css/loja.css">
    <style>
        :root {
            --color-magenta: #E6007E;
            --color-magenta-dark: #C4006A;
            --color-rose-light: #FDF2F8;
        }
        
        /* Configurações globais premium */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
        
        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #ffffff;
            color: #333333;
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 85px;
            margin: 0;
        }
        
        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-header h1 {
            color: var(--color-magenta);
            font-size: 2.5rem;
            margin-bottom: 8px;
        }
        
        .account-grid {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .account-content {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .account-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .info-item {
            padding: 16px;
            background: #f8f9fa;
            border-radius: 12px;
        }
        
        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-weight: 600;
            color: #333;
        }
        
        /* Estilos de Formulário */
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
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--color-magenta);
            box-shadow: 0 0 0 3px rgba(230, 0, 126, 0.1);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-row-3 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(230, 0, 126, 0.4);
        }
        
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }
        
        .section-title {
            color: var(--color-magenta);
            font-size: 1.5rem;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(230, 0, 126, 0.1);
        }
        
        .section-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 40px 0;
        }
        
        .info-box {
            background: var(--color-rose-light);
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--color-magenta);
        }
        
        .info-box p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        /* RESPONSIVIDADE - Estilos específicos da página */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            
            .account-grid {
                max-width: 100%;
            }
            
            .account-info {
                grid-template-columns: 1fr;
            }
            
            .form-row,
            .form-row-3 {
                grid-template-columns: 1fr;
            }
            
            .account-content {
                padding: 20px;
            }
        }
        
        /* Reuse navbar styles from header.php */
        .header-loja {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(230, 0, 126, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 12px 0;
        }
        
        .header-loja a {
            text-decoration: none !important;
        }
        
        /* Esconder botão mobile por padrão */
        .mobile-menu-toggle {
            display: none !important;
        }
        
        /* Esconder menu mobile e overlay por padrão */
        .mobile-menu,
        .mobile-menu-overlay {
            display: none !important;
            position: fixed;
            z-index: -1;
        }
        
        /* Apenas em mobile, permitir que apareça */
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex !important;
            }
            
            .mobile-menu,
            .mobile-menu-overlay {
                display: block !important;
            }
            
            .logo-dz-oficial {
                height: 35px;
            }
            
            .logo-text {
                font-size: 1.4rem;
            }
            
            .header-loja.scrolled .logo-dz-oficial {
                height: 30px;
            }
            
            .header-loja.scrolled .logo-text {
                font-size: 1.2rem;
            }
        }
        
        .header-loja.scrolled {
            padding: 8px 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.12);
        }
        
        .container-header {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .logo-dz-oficial {
            height: 45px;
            width: auto;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(230, 0, 126, 0.2));
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--color-magenta);
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .header-loja.scrolled .logo-dz-oficial {
            height: 35px;
        }
        
        .header-loja.scrolled .logo-text {
            font-size: 1.5rem;
        }
        
        .logo-dz-fallback {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--color-magenta);
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            text-shadow: 0 2px 4px rgba(230, 0, 126, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logo-dz-fallback::before {
            content: '';
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, var(--color-magenta) 0%, var(--color-magenta-dark) 50%, transparent 70%);
            border-radius: 50%;
            box-shadow: 
                -8px -8px 0 -4px rgba(230, 0, 126, 0.6),
                8px -8px 0 -4px rgba(230, 0, 126, 0.6),
                -6px 6px 0 -4px rgba(230, 0, 126, 0.4),
                6px 6px 0 -4px rgba(230, 0, 126, 0.4);
        }
        
        .header-loja.scrolled .logo-dz-fallback {
            font-size: 2rem;
        }
        
        .nav-loja ul {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-loja a {
            color: #2d3748;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px 16px;
            border-radius: 25px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
        }
        
        .nav-loja a:hover {
            color: var(--color-magenta);
            background: rgba(230, 0, 126, 0.08);
            transform: translateY(-2px);
        }
        
        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        
        .search-panel {
            width: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .search-panel.active {
            width: 260px;
            opacity: 1;
            margin-left: 16px;
        }
        
        .search-panel input {
            width: 260px;
            padding: 10px 14px;
            border-radius: 20px;
            border: 1px solid rgba(230, 0, 126, 0.2);
            background: white;
            color: #1e293b;
            font-size: 0.9rem;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            outline: none;
        }
        
        .search-panel input:focus {
            border-color: var(--color-magenta);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.2);
        }
        
        .btn-icon {
            width: 44px;
            height: 44px;
            border-radius: 22px;
            border: none;
            background: rgba(230, 0, 126, 0.1);
            color: var(--color-magenta);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-icon:hover {
            background: var(--color-magenta);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        .btn-icon:hover::before {
            left: 100%;
        }
        
        .btn-cart {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 6px 20px rgba(230, 0, 126, 0.25);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }
        
        .btn-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(230, 0, 126, 0.4);
        }
        
        .btn-cart:hover::before {
            left: 100%;
        }
        
        .cart-count {
            background: white;
            color: var(--color-magenta);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
        }
        
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-btn {
            width: 44px;
            height: 44px;
            border-radius: 22px;
            border: none;
            background: rgba(230, 0, 126, 0.1);
            color: var(--color-magenta);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .user-dropdown-btn:hover {
            background: var(--color-magenta);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001;
        }
        
        .user-dropdown.active .user-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .user-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            right: 20px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
        }
        
        .user-greeting {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            color: var(--color-magenta);
        }
        
        .user-dropdown-menu a {
            display: block;
            padding: 12px 16px;
            color: #333;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }
        
        .user-dropdown-menu a:hover {
            background: rgba(230, 0, 126, 0.05);
            color: var(--color-magenta);
        }
        
        .user-dropdown-menu a:last-child {
            border-radius: 0 0 12px 12px;
            color: #ef4444;
        }
        
        .user-dropdown-menu a:last-child:hover {
            background: #fef2f2;
            color: #dc2626;
        }
        
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        
        /* Botões de Autenticação */
        .btn-auth {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
            display: inline-block;
        }
        
        .btn-login {
            background: transparent;
            color: var(--color-magenta);
            border: 2px solid var(--color-magenta);
        }
        
        .btn-login:hover {
            background: var(--color-magenta);
            color: white;
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            border: none;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.3);
        }
    </style>
    <script>
        // Menu Mobile
        function toggleMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            if (hamburger && overlay && menu) {
                hamburger.classList.toggle('open');
                overlay.classList.toggle('active');
                menu.classList.toggle('active');
                
                // Prevenir scroll do body quando menu está aberto
                document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
            }
        }
        
        function closeMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            if (hamburger && overlay && menu) {
                hamburger.classList.remove('open');
                overlay.classList.remove('active');
                menu.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
        
        // Toggle do Dropdown do Usuário
        function toggleUserDropdown() {
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('active');
            }
        }
        
        // Efeito de scroll na navbar
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
        
        // Toggle da Busca
        const searchToggle = document.getElementById('searchToggle');
        const searchPanel = document.getElementById('searchPanel');
        const searchInput = document.getElementById('searchInput');

        function closeSearchPanel() {
            if (!searchPanel || !searchToggle) return;
            searchPanel.classList.remove('active');
            searchToggle.setAttribute('aria-expanded', 'false');
        }

        if (searchToggle && searchPanel) {
            searchToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const isOpen = searchPanel.classList.toggle('active');
                searchToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                if (isOpen && searchInput) {
                    searchInput.focus();
                }
            });
        }

        document.addEventListener('click', (e) => {
            if (!searchPanel || !searchToggle) return;
            if (!searchPanel.classList.contains('active')) return;
            if (searchPanel.contains(e.target) || searchToggle.contains(e.target)) return;
            closeSearchPanel();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeSearchPanel();
            }
        });
        
        // Funcionalidade de Busca
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && this.value.trim()) {
                        window.location.href = '../index.php?search=' + encodeURIComponent(this.value.trim());
                    }
                });
            }
        });
        
        // Funções do Carrinho
        function getCart() {
            const cart = localStorage.getItem('dz_cart');
            return cart ? JSON.parse(cart) : [];
        }
        
        function updateCartBadge() {
            const cart = getCart();
            const totalItems = cart.reduce((total, item) => total + item.qty, 0);
            const badge = document.getElementById('cartBadge');
            
            if (badge) {
                badge.textContent = totalItems;
                badge.style.animation = 'none';
                setTimeout(() => {
                    badge.style.animation = 'bounce 0.5s ease';
                }, 10);
            }
        }
        
        // Máscaras de formatação para campos
        document.addEventListener('DOMContentLoaded', function() {
            // Atualizar badge do carrinho
            updateCartBadge();
            
            // Event listener para botão do carrinho
            const cartButton = document.getElementById('cartButton');
            if (cartButton) {
                cartButton.addEventListener('click', function() {
                    window.location.href = 'carrinho.php';
                });
            }
            
            // Event listener para logo (voltar para index)
            const logoContainer = document.querySelector('.logo-container');
            if (logoContainer) {
                logoContainer.addEventListener('click', function() {
                    window.location.href = '../index.php';
                });
                logoContainer.style.cursor = 'pointer';
            }
            
            // Máscara para telefone
            const telefoneInput = document.getElementById('telefone');
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length <= 11) {
                        value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                        value = value.replace(/(\d)(\d{4})$/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }
            
            // Máscara para WhatsApp (mesma do telefone)
            const whatsappInput = document.getElementById('whatsapp');
            if (whatsappInput) {
                whatsappInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length <= 11) {
                        value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                        value = value.replace(/(\d)(\d{4})$/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }
            
            // Máscara para CEP
            const cepInput = document.getElementById('cep');
            if (cepInput) {
                cepInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    value = value.replace(/^(\d{5})(\d)/, '$1-$2');
                    e.target.value = value;
                });
            }
            
            // Máscara para CPF/CNPJ
            const cpfCnpjInput = document.getElementById('cpf_cnpj');
            if (cpfCnpjInput) {
                cpfCnpjInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    
                    if (value.length <= 11) {
                        // CPF: 000.000.000-00
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    } else {
                        // CNPJ: 00.000.000/0000-00
                        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
                        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
                        value = value.replace(/(\d{4})(\d)/, '$1-$2');
                    }
                    
                    e.target.value = value;
                });
            }
        });
    </script>
</head>
<body>
    <header class="header-loja" id="navbar">
        <div class="container-header">
            <!-- Logo D&Z Oficial -->
            <div class="logo-container">
                <img src="../assets/images/Logodz.png" alt="D&Z" class="logo-dz-oficial">
                <span class="logo-text">D&Z</span>
            </div>
            
            <!-- Navegação -->
            <nav class="nav-loja">
                <ul>
                    <li><a href="../index.php#unhas">Unhas</a></li>
                    <li><a href="../index.php#cilios">Cílios</a></li>
                    <li><a href="../index.php#kits">Kits</a></li>
                    <li><a href="../index.php#novidades">Novidades</a></li>
                </ul>
            </nav>
            
            <!-- Área do usuário -->
            <div class="user-area">
                <!-- Menu Mobile Toggle (apenas para mobile) -->
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <div class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>

                <div class="search-panel" id="searchPanel">
                    <input type="search" id="searchInput" placeholder="Buscar produtos" aria-label="Buscar produtos">
                </div>
                
                <button class="btn-icon btn-search" id="searchToggle" title="Pesquisar" aria-expanded="false" aria-controls="searchPanel">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
                
                <?php if (!$usuarioLogado): ?>
                    <!-- Botões de Login e Cadastro (usuário NÃO logado) -->
                    <a href="login.php" class="btn-auth btn-login">Entrar</a>
                    <a href="register.php" class="btn-auth btn-register">Cadastrar</a>
                <?php else: ?>
                    <!-- Dropdown do usuário logado -->
                    <div class="user-dropdown">
                        <button class="user-dropdown-btn" onclick="toggleUserDropdown()">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </button>
                        <div class="user-dropdown-menu">
                            <div class="user-greeting">Olá, <?php echo $nomeUsuario; ?></div>
                            <a href="minha-conta.php">Minha conta</a>
                            <a href="pedidos.php">Meus pedidos</a>
                            <a href="logout.php">Sair</a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <button class="btn-cart" id="cartButton" title="Carrinho">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 6px;">
                        <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <span class="cart-count" id="cartBadge">0</span>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" onclick="closeMobileMenu()"></div>
    
    <!-- Mobile Menu -->
    <nav class="mobile-menu">
        <ul>
            <li><a href="../index.php#unhas" onclick="closeMobileMenu()">Unhas</a></li>
            <li><a href="../index.php#cilios" onclick="closeMobileMenu()">Cílios</a></li>
            <li><a href="../index.php#kits" onclick="closeMobileMenu()">Kits</a></li>
            <li><a href="../index.php#novidades" onclick="closeMobileMenu()">Novidades</a></li>
        </ul>
    </nav>

    <div class="page-container">
        <div class="page-header">
            <h1>Minha Conta</h1>
            <p>Olá, <?php echo $nomeUsuario; ?>! Gerencie suas informações pessoais.</p>
        </div>
        
        <?php if ($sucesso): ?>
            <div class="alert alert-success">
                ✓ <?php echo $sucesso; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($erro): ?>
            <div class="alert alert-error">
                ✕ <?php echo $erro; ?>
            </div>
        <?php endif; ?>
        
        <div class="account-grid">
            <div class="account-content">
                <!-- Formulário de Dados Pessoais -->
                <h2 class="section-title">Informações Pessoais</h2>
                
                <form method="POST" action="minha-conta.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome Completo *</label>
                            <input 
                                type="text" 
                                id="nome" 
                                name="nome" 
                                value="<?php echo htmlspecialchars($cliente['nome']); ?>"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input 
                                type="email" 
                                id="email" 
                                value="<?php echo htmlspecialchars($cliente['email']); ?>"
                                disabled
                                style="background: #f3f4f6; cursor: not-allowed;"
                            >
                            <small style="color: #666; font-size: 0.85rem;">O e-mail não pode ser alterado</small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefone">Telefone *</label>
                            <input 
                                type="text" 
                                id="telefone" 
                                name="telefone" 
                                value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>"
                                placeholder="(00) 00000-0000"
                                required
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="whatsapp">WhatsApp</label>
                            <input 
                                type="text" 
                                id="whatsapp" 
                                name="whatsapp" 
                                value="<?php echo htmlspecialchars($cliente['whatsapp'] ?? ''); ?>"
                                placeholder="(00) 00000-0000"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cpf_cnpj">CPF/CNPJ</label>
                            <input 
                                type="text" 
                                id="cpf_cnpj" 
                                value="<?php echo htmlspecialchars($cliente['cpf_cnpj'] ?? ''); ?>"
                                disabled
                                style="background: #f3f4f6; cursor: not-allowed;"
                            >
                            <small style="color: #666; font-size: 0.85rem;">O CPF/CNPJ não pode ser alterado</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input 
                                type="date" 
                                id="data_nascimento" 
                                name="data_nascimento" 
                                value="<?php echo htmlspecialchars($cliente['data_nascimento'] ?? ''); ?>"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input 
                                type="text" 
                                id="cep" 
                                name="cep" 
                                value="<?php echo htmlspecialchars($cliente['cep'] ?? ''); ?>"
                                placeholder="00000-000"
                                maxlength="9"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input 
                                type="text" 
                                id="cidade" 
                                name="cidade" 
                                value="<?php echo htmlspecialchars($cliente['cidade'] ?? ''); ?>"
                                placeholder="Sua cidade"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rua">Rua/Avenida</label>
                            <input 
                                type="text" 
                                id="rua" 
                                name="rua" 
                                value="<?php echo htmlspecialchars($cliente['rua'] ?? ''); ?>"
                                placeholder="Nome da rua"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="numero">Número</label>
                            <input 
                                type="text" 
                                id="numero" 
                                name="numero" 
                                value="<?php echo htmlspecialchars($cliente['numero'] ?? ''); ?>"
                                placeholder="Nº"
                            >
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="complemento">Complemento</label>
                            <input 
                                type="text" 
                                id="complemento" 
                                name="complemento" 
                                value="<?php echo htmlspecialchars($cliente['complemento'] ?? ''); ?>"
                                placeholder="Apto, bloco, etc"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="bairro">Bairro</label>
                            <input 
                                type="text" 
                                id="bairro" 
                                name="bairro" 
                                value="<?php echo htmlspecialchars($cliente['bairro'] ?? ''); ?>"
                                placeholder="Seu bairro"
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="uf">Estado (UF)</label>
                        <select id="uf" name="uf">
                            <option value="">Selecione</option>
                            <?php
                            $estados = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                            $ufCliente = $cliente['uf'] ?? '';
                            foreach ($estados as $uf) {
                                $selected = ($ufCliente === $uf) ? 'selected' : '';
                                echo "<option value=\"$uf\" $selected>$uf</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="info-box">
                        <p><strong>Status da conta:</strong> <?php echo ucfirst($cliente['status']); ?> | <strong>Cadastro:</strong> <?php echo date('d/m/Y', strtotime($cliente['data_cadastro'])); ?></p>
                    </div>
                    
                    <button type="submit" name="atualizar_dados" class="btn-primary">
                        Salvar Alterações
                    </button>
                </form>
                
                <!-- Seção de Alteração de Senha -->
                <div class="section-divider"></div>
                
                <h2 class="section-title">Alterar Senha</h2>
                
                <form method="POST" action="minha-conta.php">
                    <div class="form-group">
                        <label for="senha_atual">Senha Atual *</label>
                        <input 
                            type="password" 
                            id="senha_atual" 
                            name="senha_atual" 
                            placeholder="Digite sua senha atual"
                        >
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="senha_nova">Nova Senha *</label>
                            <input 
                                type="password" 
                                id="senha_nova" 
                                name="senha_nova" 
                                placeholder="Mínimo 6 caracteres"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="senha_confirmar">Confirmar Nova Senha *</label>
                            <input 
                                type="password" 
                                id="senha_confirmar" 
                                name="senha_confirmar" 
                                placeholder="Digite novamente"
                            >
                        </div>
                    </div>
                    
                    <button type="submit" name="alterar_senha" class="btn-primary">
                        Alterar Senha
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
