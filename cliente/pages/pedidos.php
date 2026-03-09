<?php
// FORÇAR SEM CACHE
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

session_start();
require_once '../config.php';

// Verificar se está logado
if (!isset($_SESSION['cliente'])) {
    header('Location: login.php');
    exit;
}

$nomeUsuario = htmlspecialchars($_SESSION['cliente']['nome']);
$clienteId = $_SESSION['cliente']['id'];
$usuarioLogado = true;
$pageTitle = 'Meus Pedidos - D&Z';

// Buscar pedidos do cliente
$pedidos = [];
try {
    $stmt = $pdo->prepare("SELECT p.id, p.valor_total, p.status, p.data_pedido, p.observacoes, p.forma_pagamento, p.parcelas FROM pedidos p WHERE p.cliente_id = ? ORDER BY p.data_pedido DESC");
    
    if (!$stmt) {
        die("ERRO: prepare() falhou");
    }
    
    $resultado = $stmt->execute([$clienteId]);
    
    if (!$resultado) {
        die("ERRO: execute() falhou: " . print_r($stmt->errorInfo(), true));
    }
    
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Buscar itens de cada pedido
    foreach ($pedidos as $key => $pedido) {
        try {
            $stmtItens = $pdo->prepare("SELECT ip.quantidade, ip.preco_unitario, pr.nome, pr.imagem_principal as imagem, pr.categoria FROM itens_pedido ip LEFT JOIN produtos pr ON ip.produto_id = pr.id WHERE ip.pedido_id = ?");
            $stmtItens->execute([$pedido['id']]);
            $pedidos[$key]['itens'] = $stmtItens->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $eItens) {
            $pedidos[$key]['itens'] = [];
            error_log("Erro ao buscar itens: " . $eItens->getMessage());
        }
    }
} catch (PDOException $e) {
    error_log("Erro ao buscar pedidos: " . $e->getMessage());
    $pedidos = [];
}

// Função para traduzir status
function traduzirStatus($status) {
    return $status; // Já vem em português do banco
}

// Função para cor do status
function corStatus($status) {
    $cores = [
        'Pedido Recebido' => '#2196F3',
        'Pagamento Pendente' => '#FFC107',
        'Pedido Confirmado' => '#4CAF50',
        'Em Preparação' => '#9C27B0',
        'Enviado' => '#00BCD4',
        'Entregue' => '#4CAF50',
        'Estornado' => '#F44336',
        'Cancelado' => '#F44336'
    ];
    return $cores[$status] ?? '#757575';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Material Symbols (ícones) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <title><?php echo $pageTitle; ?></title>
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
        
        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f8f9fa;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
        }
        
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
        
        /* Ajustes responsivos para telas médias */
        @media (max-width: 968px) {
            header.header-loja .container-header,
            header.header-loja #navbar .container-header,
            .header-loja .container-header {
                padding: 0 8px !important;
                gap: 8px !important;
            }
            
            header.header-loja .nav-loja,
            .header-loja .nav-loja {
                margin: 0 10px 0 0 !important;
            }
            
            header.header-loja .nav-loja > ul,
            .header-loja .nav-loja > ul {
                gap: 13px !important;
            }
            
            .nav-loja a {
                font-size: 0.8rem !important;
                padding: 8px 10px !important;
            }
            
            header.header-loja .nav-right,
            .header-loja .nav-right {
                gap: 6px !important;
            }
            
            header.header-loja .search-panel.active,
            .header-loja .search-panel.active {
                min-width: 100px !important;
                max-width: 130px !important;
            }
            
            header.header-loja .search-panel input,
            .header-loja .search-panel input {
                min-width: 100px !important;
                max-width: 130px !important;
                font-size: 0.8rem !important;
                padding: 8px 10px !important;
            }
        }
        
        /* Apenas em mobile, permitir que apareça */
        @media (max-width: 768px) {
            .header-loja {
                padding: 8px 0 !important;
            }
            
            header.header-loja .container-header,
            header.header-loja #navbar .container-header,
            .header-loja .container-header {
                padding: 0 12px !important;
                gap: 6px !important;
                justify-content: space-between !important;
            }
            .mobile-menu-toggle {
                display: flex !important;
                width: 44px !important;
                height: 44px !important;
                align-items: center !important;
                justify-content: center !important;
                border: none;
                background: rgba(230, 0, 126, 0.1);
                border-radius: 22px;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                z-index: 10;
                pointer-events: auto;
            }
            
            .mobile-menu-toggle:hover {
                background: var(--color-magenta);
            }
            
            .hamburger {
                width: 20px;
                height: 20px;
                position: relative;
                transform: rotate(0deg);
                transition: 0.3s ease-in-out;
                cursor: pointer;
            }
            
            .hamburger span {
                display: block;
                position: absolute;
                height: 2px;
                width: 100%;
                background: var(--color-magenta);
                border-radius: 2px;
                opacity: 1;
                left: 0;
                transform: rotate(0deg);
                transition: 0.25s ease-in-out;
            }
            
            .mobile-menu-toggle:hover .hamburger span {
                background: white;
            }
            
            .hamburger span:nth-child(1) {
                top: 0px;
                transform-origin: left center;
            }
            
            .hamburger span:nth-child(2) {
                top: 9px;
                transform-origin: left center;
            }
            
            .hamburger span:nth-child(3) {
                top: 18px;
                transform-origin: left center;
            }
            
            .hamburger.open span:nth-child(1) {
                transform: rotate(45deg);
                top: -1px;
                left: 4px;
            }
            
            .hamburger.open span:nth-child(2) {
                width: 0%;
                opacity: 0;
            }
            
            .hamburger.open span:nth-child(3) {
                transform: rotate(-45deg);
                top: 17px;
                left: 4px;
            }
            
            .mobile-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100%;
                background: linear-gradient(135deg, #ffffff 0%, #fef7ff 100%);
                padding: 100px 30px 40px;
                z-index: 1001;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
                transform: translateX(100%);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
            
            .mobile-menu.active {
                right: 0;
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
                pointer-events: all;
            }
            
            .mobile-menu-overlay {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: all 0.3s ease;
            }
            
            .mobile-menu-overlay.active {
                opacity: 1;
                visibility: visible;
                pointer-events: all;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(10px);
                z-index: 999;
            }
            
            .mobile-menu ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .mobile-menu li {
                margin-bottom: 8px;
            }
            
            .mobile-menu a {
                display: block;
                padding: 16px 20px;
                color: #2d3748;
                text-decoration: none;
                font-weight: 600;
                font-size: 1.1rem;
                border-radius: 15px;
                transition: all 0.3s ease;
                opacity: 0;
                transform: translateX(30px);
            }
            
            .mobile-menu.active a {
                opacity: 1;
                transform: translateX(0);
            }
            
            .mobile-menu.active li:nth-child(1) a { transition-delay: 0.1s; }
            .mobile-menu.active li:nth-child(2) a { transition-delay: 0.15s; }
            .mobile-menu.active li:nth-child(3) a { transition-delay: 0.2s; }
            .mobile-menu.active li:nth-child(4) a { transition-delay: 0.25s; }
            
            .mobile-menu a:hover {
                background: rgba(230, 0, 126, 0.1);
                color: var(--color-magenta);
                transform: translateX(10px);
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
            
            .nav-loja {
                display: none !important;
            }
            
            .logo-dz-fallback {
                font-size: 2rem;
            }
            
            .logo-dz-fallback::before {
                width: 16px;
                height: 16px;
            }
            
            .user-area {
                gap: 8px;
            }
            
            .btn-icon {
                width: 40px;
                height: 40px;
            }
            
            .btn-cart span:not(.cart-count) {
                display: none;
            }
            
            body {
                padding-top: 70px;
            }
        }
        
        .header-loja.scrolled {
            padding: 8px 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.12);
        }
        
        /* ===== LAYOUT NAVBAR - ALTA ESPECIFICIDADE ===== */
        header.header-loja #navbar .container-header,
        header.header-loja .container-header,
        .header-loja .container-header {
            max-width: 1400px !important;
            margin: 0 auto !important;
            padding: 0 4px !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-wrap: nowrap !important;
        }
        
        header.header-loja .logo-container,
        .header-loja .logo-container {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            cursor: pointer !important;
            transition: transform 0.3s ease !important;
            flex-shrink: 0 !important;
            flex: 0 0 auto !important;
            min-width: 0 !important;
            margin-left: 0 !important;
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
        
        header.header-loja nav.nav-loja,
        .header-loja .nav-loja {
            flex: 1 1 auto !important;
            display: flex !important;
            justify-content: center !important;
            min-width: 0 !important;
            max-width: none !important;
            overflow: visible !important;
            margin: 0 16px 0 0 !important;
            flex-shrink: 0 !important;
        }
        
        header.header-loja nav.nav-loja > ul,
        .header-loja .nav-loja > ul {
            display: flex !important;
            align-items: center !important;
            gap: 18px !important;
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
        }
        
        header.header-loja .nav-loja > ul > li,
        .header-loja .nav-loja > ul > li {
            flex-shrink: 0 !important;
        }
        
        .nav-loja > ul > li {
            position: relative;
        }
        
        .nav-loja a {
            color: #2d3748;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.88rem;
            padding: 10px 13px;
            border-radius: 25px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .dropdown-icon {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }
        
        .has-dropdown:hover .dropdown-icon {
            transform: rotate(180deg);
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 220px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            padding: 12px 0;
            margin-top: 8px;
        }
        
        .has-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: block;
        }
        
        .dropdown-menu li {
            position: relative;
        }
        
        .dropdown-menu a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            color: #2d3748;
            border-radius: 0;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .dropdown-menu a:hover {
            background: rgba(230, 0, 126, 0.08);
            color: var(--color-magenta);
            transform: translateX(4px);
        }
        
        .submenu-arrow {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .submenu {
            position: absolute;
            left: 100%;
            top: 0;
            background: white;
            min-width: 200px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateX(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001;
            padding: 12px 0;
            margin-left: 4px;
        }
        
        .has-submenu:hover .submenu {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }
        
        .nav-loja a:hover {
            color: var(--color-magenta);
            background: rgba(230, 0, 126, 0.08);
            transform: translateY(-2px);
        }
        
        header.header-loja .nav-right,
        .header-loja .nav-right {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            flex-shrink: 1 !important;
            flex: 0 1 auto !important;
            margin-right: 0 !important;
        }
        
        header.header-loja .nav-right .user-area,
        .header-loja .user-area {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            flex-shrink: 0 !important;
            margin-right: 0 !important;
            position: relative;
            z-index: 5;
        }

        header.header-loja .nav-right .search-panel,
        .header-loja .search-panel {
            width: 0 !important;
            max-width: 0 !important;
            opacity: 0 !important;
            overflow: hidden !important;
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), 
                        opacity 0.5s ease-in-out,
                        max-width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
            display: flex !important;
            align-items: center !important;
            flex: 0 0 auto !important;
            will-change: width, opacity, max-width;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
        }

        header.header-loja .nav-right .search-panel.active,
        .header-loja .search-panel.active {
            width: auto !important;
            min-width: 160px !important;
            max-width: 220px !important;
            opacity: 1 !important;
            flex: 1 1 auto !important;
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1),
                        opacity 0.5s ease-in-out,
                        max-width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }

        header.header-loja .nav-right .search-panel input,
        .header-loja .search-panel input {
            width: 100% !important;
            min-width: 160px !important;
            max-width: 220px !important;
            padding: 10px 14px !important;
            border-radius: 20px !important;
            border: 1px solid rgba(230, 0, 126, 0.2) !important;
            background: white !important;
            color: #1e293b !important;
            font-size: 0.9rem !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08) !important;
            outline: none !important;
            transition: border-color 0.3s ease, box-shadow 0.3s ease !important;
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
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            z-index: 10;
            pointer-events: auto;
        }
        
        .btn-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .btn-icon:hover {
            background: var(--color-magenta);
            color: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        .btn-icon:active {
            transform: translateY(0) scale(0.98);
            transition: all 0.15s ease;
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
            overflow: visible;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            z-index: 1;
            pointer-events: auto;
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
            border-radius: 25px;
            z-index: 0;
        }

        .btn-cart > *:not(.cart-count) {
            position: relative;
            z-index: 1;
            pointer-events: none;
        }

        .btn-cart .cart-count {
            position: absolute !important;
            top: -6px !important;
            right: -6px !important;
            z-index: 10;
            pointer-events: none;
        }
        
        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        .btn-cart:active {
            transform: translateY(0);
        }
        
        .btn-cart:hover::before {
            left: 100%;
        }
        
        .cart-count {
            background: white;
            color: #E6007E;
            border-radius: 50%;
            width: 20px;height: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", system-ui, sans-serif;
            line-height: 1;
            padding: 0;
            text-align: center;
        }
        
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 2px 8px rgba(230, 0, 126, 0.4); }
            50% { box-shadow: 0 4px 16px rgba(230, 0, 126, 0.8); }
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
        
        /* Dropdown do usuário */
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
            font-size: 1.1rem;
            transition: all 0.3s;
            position: relative;
            z-index: 10;
            pointer-events: auto;
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
        
        .page-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .pedidos-lista {
            display: grid;
            gap: 24px;
        }
        
        .pedido-card {
            background: white;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border: 1px solid rgba(230, 0, 126, 0.05);
        }
        
        .pedido-card:hover {
            box-shadow: 0 8px 24px rgba(230, 0, 126, 0.15);
            transform: translateY(-4px);
            border-color: rgba(230, 0, 126, 0.2);
        }
        
        .pedido-info-compacta {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .pedido-numero {
            font-size: 1.05rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            min-width: 110px;
            letter-spacing: 0.3px;
        }
        
        .pedido-status {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            min-width: 130px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            letter-spacing: 0.3px;
        }
        
        .pedido-data {
            font-size: 0.9rem;
            color: #64748b;
            min-width: 100px;
            font-weight: 500;
        }
        
        .pedido-valor {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--color-magenta);
            min-width: 110px;
            text-align: right;
            letter-spacing: 0.3px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 16px;
        }
        
        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }
        
        .info-value {
            font-weight: 600;
            color: #1e293b;
            font-size: 1.05rem;
        }
        
        .pedido-itens {
            margin-top: 20px;
        }
        
        .itens-header {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(230, 0, 126, 0.1);
        }
        
        .item-produto {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: linear-gradient(135deg, rgba(230, 0, 126, 0.02) 0%, rgba(230, 0, 126, 0.05) 100%);
            border-radius: 12px;
            margin-bottom: 10px;
            border: 1px solid rgba(230, 0, 126, 0.1);
            transition: all 0.3s;
        }
        
        .item-produto:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.1);
            border-color: rgba(230, 0, 126, 0.2);
        }
        
        .item-imagem {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.3);
        }
        
        .item-info {
            flex: 1;
        }
        
        .item-nome {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
            font-size: 1rem;
        }
        
        .item-detalhes {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .item-preco {
            text-align: right;
            font-weight: 700;
            color: var(--color-magenta);
            font-size: 1.1rem;
        }
        
        .pedido-total {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #f0f0f0;
            text-align: right;
        }
        
        .total-label {
            font-size: 0.875rem;
            color: #666;
        }
        
        .total-valor {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-magenta);
            margin-top: 4px;
        }
        
        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 80px 40px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }
        
        .empty-icon {
            font-size: 5rem;
            margin-bottom: 24px;
            opacity: 0.7;
        }
        
        .empty-state h2 {
            color: #1e293b;
            font-size: 1.8rem;
            margin-bottom: 12px;
        }
        
        .empty-state p {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 32px;
        }
        
        .btn-primary {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(230, 0, 126, 0.25);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(230, 0, 126, 0.4);
        }
        
        .btn-ver-detalhes {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.25);
        }
        
        .btn-ver-detalhes:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(230, 0, 126, 0.4);
        }
        
        /* MODAL PREMIUM */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 10000;
            animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(4px);
        }
        
        .modal-overlay.ativo {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 20px;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(60px) scale(0.95);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }
        
        @keyframes bounce {
            0%, 100% { 
                transform: scale(1); 
            }
            50% { 
                transform: scale(1.2); 
            }
        }
        
        .modal-header {
            padding: 28px;
            border-bottom: 1px solid rgba(230, 0, 126, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, rgba(230, 0, 126, 0.03) 0%, rgba(230, 0, 126, 0.08) 100%);
        }
        
        .modal-titulo {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-fechar {
            background: rgba(230, 0, 126, 0.1);
            border: none;
            font-size: 1.5rem;
            color: var(--color-magenta);
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            font-weight: 300;
        }
        
        .btn-fechar:hover {
            background: var(--color-magenta);
            color: white;
            transform: rotate(90deg);
        }
        
        .modal-body {
            padding: 28px;
            background: white;
        }
        
        .info-item {
            margin-bottom: 16px;
        }
        
        .info-label {
            font-size: 0.875rem;
            color: #666;
            font-weight: 500;
            display: block;
            margin-bottom: 4px;
        }
        
        .info-value {
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }
        
        /* RESPONSIVIDADE - Estilos específicos da página */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            
            .page-container {
                padding: 24px 16px;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .page-header p {
                font-size: 1rem;
            }
            
            .pedido-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px;
            }
            
            .pedido-info-compacta {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                gap: 12px;
            }
            
            .pedido-numero,
            .pedido-status,
            .pedido-data,
            .pedido-valor {
                min-width: auto;
                text-align: left;
            }
            
            .btn-ver-detalhes {
                width: 100%;
                justify-content: center;
            }
            
            .modal-content {
                width: 95%;
                max-height: 85vh;
            }
            
            .modal-header {
                padding: 20px;
            }
            
            .modal-titulo {
                font-size: 1.3rem;
            }
            
            .modal-body {
                padding: 20px;
            }
            
            .item-produto {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            
            .item-preco {
                text-align: left;
            }
        }
        
        /* ===== CHAT STYLES ===== */
        
        /* Chat Button */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #E6007E, #b8005f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 8px 25px rgba(230, 0, 126, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            color: white;
            font-size: 1.8rem;
        }
        
        .chat-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(230, 0, 126, 0.6);
        }
        
        /* Chat Tooltip */
        .chat-tooltip {
            position: absolute;
            right: 70px;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .chat-button:hover .chat-tooltip {
            opacity: 1;
        }
        
        /* Chat Modal */
        .chat-modal {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            height: 500px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.95);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .chat-modal.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }
        
        /* Chat Header */
        .chat-header {
            background: linear-gradient(135deg, #E6007E, #b8005f);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .chat-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .chat-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .chat-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        /* Online Status */
        .online-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            margin-top: 4px;
        }
        
        .online-indicator {
            width: 8px;
            height: 8px;
            background: #00ff88;
            border-radius: 50%;
        }
        
        /* Chat Messages */
        .chat-messages {
            height: 320px;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
        }
        
        .chat-message {
            background: white;
            padding: 12px 16px;
            border-radius: 15px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .chat-message.bot {
            margin-right: 40px;
            color: #2d3748;
            background: linear-gradient(135deg, #f3e5f5, #fce4ec);
        }
        
        .chat-message.user {
            background: linear-gradient(135deg, #E6007E, #b8005f);
            color: white;
            margin-left: 40px;
            text-align: right;
        }
        
        .chat-message-time {
            font-size: 0.7rem;
            opacity: 0.7;
            margin-top: 5px;
        }
        
        /* Chat Input */
        .chat-input-container {
            padding: 15px 20px;
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 10px;
        }
        
        .chat-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 25px;
            font-size: 0.9rem;
            background: #f8f9fa;
            transition: all 0.2s ease;
        }
        
        .chat-input:focus {
            outline: none;
            border-color: #E6007E;
            background: white;
        }
        
        .chat-send {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #E6007E, #b8005f);
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .chat-send:hover {
            transform: scale(1.05);
        }
        
        /* Typing Indicator */
        .typing-indicator {
            display: none;
            padding: 12px 16px;
            background: white;
            border-radius: 15px;
            margin-bottom: 12px;
            margin-right: 40px;
        }
        
        .typing-dots {
            display: flex;
            gap: 4px;
        }
        
        .typing-dot {
            width: 8px;
            height: 8px;
            background: #666;
            border-radius: 50%;
            animation: typingAnimation 1.5s infinite;
        }
        
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.5; }
            30% { transform: translateY(-10px); opacity: 1; }
        }
    </style>
    <script>
        // Funções do Modal de Pedidos
        function abrirModal(pedidoId) {
            const modal = document.getElementById('modal-' + pedidoId);
            if (modal) {
                modal.classList.add('ativo');
                document.body.style.overflow = 'hidden';
            } else {
                console.error('Modal não encontrado: modal-' + pedidoId);
            }
        }
        
        function fecharModal(pedidoId) {
            const modal = document.getElementById('modal-' + pedidoId);
            if (modal) {
                modal.classList.remove('ativo');
                document.body.style.overflow = 'auto';
            }
        }
        
        // Fechar ao clicar fora do modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('ativo');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Prevenir que cliques no conteúdo do modal o fechem
        document.addEventListener('click', function(e) {
            if (e.target.closest('.modal-content')) {
                e.stopPropagation();
            }
        });
        
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
                        // Redirecionar para index.php com termo de busca
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
        
        // Atualizar badge do carrinho ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</head>
<body>
    <!-- ===== NAVBAR PREMIUM D&Z ===== -->
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
                    <li><a href="../produtos.php">TODOS</a></li>
                    
                    <li class="has-dropdown">
                        <a href="../produtos.php?menu=unhas">UNHAS <span class="dropdown-icon">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="../produtos.php?categoria=Esmaltes">Esmaltes</a></li>
                                <li><a href="../produtos.php?categoria=Géis">Géis</a></li>
                                <li><a href="../produtos.php?categoria=Preparadores">Preparadores</a></li>
                                <li><a href="../produtos.php?categoria=Molde">Molde</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="has-dropdown">
                        <a href="../produtos.php?menu=cilios">CÍLIOS <span class="dropdown-icon">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="../produtos.php?categoria=Cola">Cola</a></li>
                                <li><a href="../produtos.php?categoria=Removedor">Removedor</a></li>
                                <li><a href="../produtos.php?categoria=Fio a fio">Fio a fio</a></li>
                                <li><a href="../produtos.php?categoria=Postiço">Postiço</a></li>
                                <li><a href="../produtos.php?categoria=Tufo">Tufo</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="has-dropdown">
                        <a href="../produtos.php?menu=eletronicos">ELETRÔNICOS <span class="dropdown-icon">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="../produtos.php?categoria=Cabine">Cabine</a></li>
                                <li><a href="../produtos.php?categoria=Motor">Motor</a></li>
                                <li><a href="../produtos.php?categoria=Luminária">Luminária</a></li>
                                <li><a href="../produtos.php?categoria=Coletor">Coletor</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="has-dropdown">
                        <a href="../produtos.php?menu=ferramentas">FERRAMENTAS <span class="dropdown-icon">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="../produtos.php?categoria=Alicates">Alicates</a></li>
                                <li><a href="../produtos.php?categoria=Espátulas">Espátulas</a></li>
                                <li><a href="../produtos.php?categoria=Tesouras">Tesouras</a></li>
                                <li><a href="../produtos.php?categoria=Cortadores">Cortadores</a></li>
                                <li><a href="../produtos.php?categoria=Lixas">Lixas</a></li>
                                <li><a href="../produtos.php?categoria=Empurradores">Empurradores</a></li>
                                <li><a href="../produtos.php?categoria=Pincéis">Pincéis</a></li>
                                <li><a href="../produtos.php?categoria=Pinças">Pinças</a></li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="has-dropdown">
                        <a href="../produtos.php?menu=marcas">MARCAS <span class="dropdown-icon">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="../produtos.php?marca=D&Z">D&Z</a></li>
                                <li><a href="../produtos.php?marca=Sioux">Sioux</a></li>
                                <li><a href="../produtos.php?marca=Sunny's">Sunny's</a></li>
                                <li><a href="../produtos.php?marca=Crush">Crush</a></li>
                                <li><a href="../produtos.php?marca=XD">XD</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            
            <!-- Lado direito: Busca + Ícones -->
            <div class="nav-right">
                <div class="search-panel" id="searchPanel">
                    <input type="search" id="searchInput" placeholder="Buscar produtos" aria-label="Buscar produtos">
                </div>
                
                <!-- Área do usuário -->
                <div class="user-area">
                    <!-- Menu Mobile Toggle (apenas para mobile) -->
                    <button class="mobile-menu-toggle" onclick="toggleMobileMenu(event)">
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                    
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
                        <button class="user-dropdown-btn" onclick="toggleUserDropdown(event)">
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
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <span>Carrinho</span>
                    <span class="cart-count" id="cartBadge">0</span>
                </button>
            </div>
            <!-- Fim user-area -->
            </div>
            <!-- Fim nav-right -->
        </div>
        <!-- Fim container-header -->
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" onclick="closeMobileMenu(event)"></div>
    
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
            <h1>Meus Pedidos</h1>
            <p>Olá, <?php echo $nomeUsuario; ?>! Aqui estão todos os seus pedidos.</p>
        </div>
        
        <?php if (empty($pedidos)): ?>
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2>Você ainda não tem pedidos</h2>
                <p>Que tal começar a explorar nossos produtos?</p>
                <a href="../index.php" class="btn-primary">Começar a Comprar</a>
            </div>
        <?php else: ?>
            <div class="pedidos-lista">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="pedido-card">
                        <div class="pedido-info-compacta">
                            <span class="pedido-numero">Pedido #<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></span>
                            <span class="pedido-status" style="background-color: <?php echo corStatus($pedido['status']); ?>">
                                <?php echo traduzirStatus($pedido['status']); ?>
                            </span>
                            <span class="pedido-data"><?php echo date('d/m/Y', strtotime($pedido['data_pedido'])); ?></span>
                            <span class="pedido-valor">R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></span>
                        </div>
                        <button class="btn-ver-detalhes" onclick="event.stopPropagation(); abrirModal(<?php echo $pedido['id']; ?>)">
                            Ver Detalhes
                        </button>
                    </div>
                    
                    <!-- Modal do Pedido -->
                    <div class="modal-overlay" id="modal-<?php echo $pedido['id']; ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-titulo">Pedido #<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></h2>
                                <button class="btn-fechar" onclick="event.stopPropagation(); fecharModal(<?php echo $pedido['id']; ?>)">×</button>
                            </div>
                            <div class="modal-body">
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="pedido-status" style="background-color: <?php echo corStatus($pedido['status']); ?>">
                                        <?php echo traduzirStatus($pedido['status']); ?>
                                    </span>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Data do Pedido</span>
                                    <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></span>
                                </div>
                                
                                <div class="info-item">
                                    <span class="info-label">Valor Total</span>
                                    <span class="info-value" style="color: var(--color-magenta); font-size: 1.5rem;">
                                        R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($pedido['forma_pagamento'])): ?>
                                    <div class="info-item">
                                        <span class="info-label">Forma de Pagamento</span>
                                        <span class="info-value"><?php echo htmlspecialchars($pedido['forma_pagamento']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($pedido['parcelas']) && $pedido['parcelas'] > 1): ?>
                                    <div class="info-item">
                                        <span class="info-label">Parcelas</span>
                                        <span class="info-value"><?php echo $pedido['parcelas']; ?>x de R$ <?php echo number_format($pedido['valor_total'] / $pedido['parcelas'], 2, ',', '.'); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($pedido['observacoes'])): ?>
                                    <div class="info-item">
                                        <span class="info-label">Observações</span>
                                        <span class="info-value"><?php echo htmlspecialchars($pedido['observacoes']); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($pedido['itens'])): ?>
                                    <div style="margin-top: 24px;">
                                        <div class="itens-header">Produtos</div>
                                        <div class="pedido-itens">
                                            <?php foreach ($pedido['itens'] as $item): ?>
                                                <div class="item-produto">
                                                    <div class="item-imagem">
                                                        <?php if (!empty($item['imagem'])): ?>
                                                            <img src="../../admin/assets/images/produtos/<?php echo htmlspecialchars($item['imagem']); ?>" 
                                                                 alt="<?php echo htmlspecialchars($item['nome'] ?? 'Produto'); ?>"
                                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                                 onerror="this.parentElement.innerHTML='📦';">
                                                        <?php else: ?>
                                                            📦
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="item-info">
                                                        <div class="item-nome"><?php echo htmlspecialchars($item['nome'] ?? 'Produto'); ?></div>
                                                        <div class="item-detalhes">
                                                            Quantidade: <?php echo $item['quantidade']; ?>
                                                            <?php if (!empty($item['categoria'])): ?>
                                                                • Categoria: <?php echo htmlspecialchars($item['categoria']); ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="item-preco">
                                                        <div style="font-size: 0.875rem; color: #666; margin-bottom: 4px;">
                                                            R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?> un.
                                                        </div>
                                                        <div>
                                                            R$ <?php echo number_format($item['preco_unitario'] * $item['quantidade'], 2, ',', '.'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // ===== FUNÇÕES DA NAVBAR =====
        
        // Menu Mobile
        function closeMobileMenu(event) {
            if (event) {
                event.stopPropagation();
            }
            
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            if (hamburger) hamburger.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
            if (menu) menu.classList.remove('active');
            
            document.body.style.overflow = '';
        }
        
        function toggleMobileMenu(event) {
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }
            
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            hamburger.classList.toggle('open');
            overlay.classList.toggle('active');
            menu.classList.toggle('active');
            
            if (menu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
        
        // Dropdown do usuário
        function toggleUserDropdown(event) {
            if (event) {
                event.stopPropagation();
                event.preventDefault();
            }
            
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('active');
            }
        }
        
        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
        
        // Atualizar contador do carrinho
        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('dz_cart') || '[]');
            const totalItems = cart.reduce((sum, item) => {
                const itemQty = parseInt(item.qty) || 0;
                return sum + itemQty;
            }, 0);
            
            const cartBadge = document.getElementById('cartBadge') || document.querySelector('.cart-count');
            const cartButton = document.getElementById('cartButton');
            
            if (cartBadge) {
                cartBadge.textContent = totalItems;
                
                if (totalItems > 0) {
                    cartBadge.style.display = 'flex';
                    if (cartButton) {
                        cartButton.classList.add('has-items');
                    }
                } else {
                    cartBadge.style.display = 'none';
                    if (cartButton) {
                        cartButton.classList.remove('has-items');
                    }
                }
                
                cartBadge.style.animation = 'none';
                setTimeout(() => {
                    cartBadge.style.animation = 'bounce 0.5s ease';
                }, 10);
            }
        }
        
        // Função para busca
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
            
            const searchToggle = document.getElementById('searchToggle');
            const searchPanel = document.getElementById('searchPanel');
            
            if (searchToggle && searchPanel) {
                searchToggle.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    searchPanel.classList.toggle('active');
                    
                    if (searchPanel.classList.contains('active')) {
                        setTimeout(() => {
                            const searchInput = document.getElementById('searchInput');
                            if (searchInput) searchInput.focus();
                        }, 300);
                    }
                });
            }
            
            // Botão do carrinho
            const cartButton = document.getElementById('cartButton');
            if (cartButton) {
                cartButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    window.location.href = 'carrinho.php';
                });
            }
            
            // Logo - voltar para index
            const logoContainer = document.querySelector('.logo-container');
            if (logoContainer) {
                logoContainer.addEventListener('click', function() {
                    window.location.href = '../index.php';
                });
                logoContainer.style.cursor = 'pointer';
            }
        });
        
        // ===== FUNÇÕES DO CHAT =====
        
        function createChatButton() {
            const chatBtn = document.createElement('button');
            chatBtn.className = 'chat-button';
            chatBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2.5 21.5l4.5-.838A9.955 9.955 0 0 0 12 22Z"/>
                    <path d="M8 12h.01M12 12h.01M16 12h.01" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <div class="chat-tooltip">Fale conosco!</div>
            `;
            
            chatBtn.addEventListener('click', function() {
                toggleChatModal();
            });
            
            document.body.appendChild(chatBtn);
            createChatModal();
        }
        
        function createChatModal() {
            const chatModal = document.createElement('div');
            chatModal.className = 'chat-modal';
            chatModal.id = 'chatModal';
            
            chatModal.innerHTML = `
                <div class="chat-header">
                    <div>
                        <h3>D&Z Atendimento</h3>
                        <div class="online-status"><div class="online-indicator"></div><span>Online agora</span></div>
                    </div>
                    <button class="chat-close" onclick="toggleChatModal()">×</button>
                </div>
                
                <div class="chat-messages" id="chatMessages">
                    <div class="chat-message bot">
                        <div>Olá! 😊 Seja bem-vinda à D&Z! Como posso te ajudar hoje?</div>
                        <div class="chat-message-time">${getCurrentTime()}</div>
                    </div>
                    
                    <div class="typing-indicator" id="typingIndicator">
                        <div class="typing-dots">
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                            <div class="typing-dot"></div>
                        </div>
                    </div>
                </div>
                
                <div class="chat-input-container">
                    <input type="text" class="chat-input" id="chatInput" placeholder="Digite sua mensagem..." maxlength="500">
                    <button class="chat-send" onclick="sendMessage()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="m2 21 21-9L2 3v7l15 2-15 2v7z"/>
                        </svg>
                    </button>
                </div>
            `;
            
            document.body.appendChild(chatModal);
            
            const chatInput = chatModal.querySelector('#chatInput');
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
        }
        
        function toggleChatModal() {
            const modal = document.getElementById('chatModal');
            modal.classList.toggle('active');
            
            if (modal.classList.contains('active')) {
                setTimeout(() => {
                    const input = document.getElementById('chatInput');
                    input.focus();
                }, 300);
            }
        }
        
        function getCurrentTime() {
            const now = new Date();
            return `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')}`;
        }
        
        function sendMessage() {
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            
            if (message === '') return;
            
            addMessage(message, 'user');
            input.value = '';
            
            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    respondToMessage(message);
                }, Math.random() * 2000 + 1000);
            }, 500);
        }
        
        function addMessage(text, sender) {
            const messagesContainer = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `chat-message ${sender}`;
            
            messageDiv.innerHTML = `
                <div>${text}</div>
                <div class="chat-message-time">${getCurrentTime()}</div>
            `;
            
            messagesContainer.insertBefore(messageDiv, document.getElementById('typingIndicator'));
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        function showTyping() {
            const typingIndicator = document.getElementById('typingIndicator');
            typingIndicator.style.display = 'block';
            const messagesContainer = document.getElementById('chatMessages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        
        function hideTyping() {
            const typingIndicator = document.getElementById('typingIndicator');
            typingIndicator.style.display = 'none';
        }
        
        function respondToMessage(userMessage) {
            const responses = getResponseForMessage(userMessage.toLowerCase());
            const randomResponse = responses[Math.floor(Math.random() * responses.length)];
            addMessage(randomResponse, 'bot');
        }
        
        function getResponseForMessage(message) {
            if (message.includes('preço') || message.includes('valor') || message.includes('quanto custa')) {
                return [
                    'Nossos produtos têm preços a partir de R$ 19,90! 😊 Que tipo de produto você tem interesse?',
                    'Temos opções para todos os orçamentos! Kit completo por R$ 89,90 ou itens avulsos a partir de R$ 19,90. 💰'
                ];
            }
            
            if (message.includes('entrega') || message.includes('frete') || message.includes('envio')) {
                return [
                    'Entrega grátis para compras acima de R$ 99! 🚚 Entregamos em todo o Brasil em até 5 dias úteis.',
                    'Frete grátis acima de R$ 99,00! Para valores menores, o frete varia de R$ 15 a R$ 25. 🚚'
                ];
            }
            
            if (message.includes('unha') || message.includes('esmalte')) {
                return [
                    'Nossos produtos para unhas são incríveis! 💅 Temos esmaltes em gel, kits profissionais e acessórios.',
                    'Para unhas, recomendo nosso Kit Profissional por R$ 89,90 - vem com tudo que você precisa! ✨'
                ];
            }
            
            if (message.includes('cílios') || message.includes('cilios')) {
                return [
                    'Nossos cílios dão um volume incrível! 👀 Temos tanto para uso diário quanto para ocasiões especiais.',
                    'Cílios premium com efeito natural! O kit de alongamento é nosso best-seller 😍'
                ];
            }
            
            if (message.includes('desconto') || message.includes('promoção') || message.includes('cupom')) {
                return [
                    'Temos uma super promoção! Use o cupom BEM-VINDA15 e ganhe 15% OFF na primeira compra! 🎉',
                    'Primeira compra? Use BEM-VINDA15 e ganhe 15% de desconto! 😎'
                ];
            }
            
            if (message.includes('whatsapp') || message.includes('telefone') || message.includes('contato')) {
                return [
                    'Nosso WhatsApp é (11) 99999-9999! Mas aqui no chat também consigo te ajudar perfeitamente! 😊',
                    'Para contato direto: contato@dzecommerce.com.br ou (11) 99999-9999. Como posso te ajudar agora? 💬'
                ];
            }
            
            return [
                'Que interessante! Posso te ajudar com informações sobre nossos produtos. O que gostaria de saber? 😊',
                'Claro! Estou aqui para esclarecer suas dúvidas. Tem alguma pergunta sobre nossos produtos? ✨',
                'Entendi! Nossos produtos de beleza são incríveis. Quer saber mais sobre alguma categoria específica? 💄'
            ];
        }
        
        // Inicializar chat quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            createChatButton();
        });
    </script>
</body>
</html>
