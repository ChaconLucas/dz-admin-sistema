<?php
// E-commerce D&Z - Homepage do Cliente
// Desenvolvido para público feminino jovem e jovem adulto
// Identidade visual premium com tons magenta, rosa claro e branco

// Configurações iniciais
session_start();

// Aqui virão as configurações de banco de dados futuramente
// include_once '../admin/config/config.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&Z - Beleza Premium para Você</title>
    
    <!-- CSS da Loja -->
    <link rel="stylesheet" href="loja.css">
    
    <!-- Meta tags para SEO -->
    <meta name="description" content="D&Z - E-commerce premium de beleza. Unhas profissionais, cílios e kits completos para elevar sua beleza ao próximo nível.">
    <meta name="keywords" content="unhas, cílios, beleza, kit beleza, D&Z, e-commerce premium">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    
    <!-- Cores customizadas para o tema D&Z -->
    <style>
        :root {
            --color-magenta: #E6007E;
            --color-magenta-dark: #C4006A;
            --color-rose-light: #FDF2F8;
        }
        
        /* Configurações globais premium */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px; /* Para navegação com header fixo */
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
            padding-top: 85px; /* Compensa a altura do header fixo */
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
        
        /* ===== NAVBAR PREMIUM D&Z ===== */
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
        
        .nav-loja a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--color-magenta) 0%, #ff1493 100%);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 1px;
        }
        
        .nav-loja a:hover {
            color: var(--color-magenta);
            background: rgba(230, 0, 126, 0.08);
            transform: translateY(-2px);
        }
        
        .nav-loja a:hover::before {
            width: 80%;
        }
        
        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
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
            animation: bounce 0.5s ease;
        }
        
        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        
        /* Banner Carrossel Moderno */
        .banner-carousel {
            position: relative;
            height: 500px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
        }
        
        .carousel-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        
        .carousel-slide {
            min-width: 100%;
            height: 100%;
            padding: 60px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
        }
        
        .carousel-content {
            flex: 1;
            max-width: 500px;
            z-index: 2;
        }
        
        .carousel-title {
            font-size: 2.8rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #1e293b;
            letter-spacing: -0.02em;
        }
        
        .carousel-subtitle {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .carousel-btn {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.25);
        }
        
        .carousel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.35);
        }
        
        .carousel-visual {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .carousel-image {
            width: 300px;
            height: 300px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .carousel-navigation {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }
        
        .carousel-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .carousel-dot.active {
            background: var(--color-magenta);
            transform: scale(1.2);
        }
        
        .carousel-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.3);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 5;
            opacity: 0.4;
            color: rgba(0, 0, 0, 0.6);
        }
        
        .carousel-arrows:hover {
            background: rgba(255, 255, 255, 0.9);
            color: var(--color-magenta);
            transform: translateY(-50%) scale(1.05);
            opacity: 1;
        }
        
        .carousel-prev {
            left: 20px;
        }
        
        .carousel-next {
            right: 20px;
        }
        
        /* Responsivo Banner Carrossel */
        @media (max-width: 768px) {
            .banner-carousel {
                height: 400px;
            }
            
            .carousel-slide {
                padding: 30px 20px;
                flex-direction: column;
                text-align: center;
            }
            
            .carousel-title {
                font-size: 2rem;
                line-height: 1.3;
            }
            
            .carousel-content {
                max-width: 100%;
                margin-bottom: 30px;
            }
            
            .carousel-image {
                width: 200px;
                height: 200px;
            }
            
            .carousel-arrows {
                width: 35px;
                height: 35px;
                opacity: 0.3;
            }
            
            .carousel-arrows:hover {
                opacity: 0.8;
            }
            
            .carousel-prev {
                left: 10px;
            }
            
            .carousel-next {
                right: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .carousel-title {
                font-size: 1.6rem;
            }
            
            .carousel-subtitle {
                font-size: 1rem;
            }
            
            .carousel-btn {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }
        
        /* Seções de categorias */
        .categorias-dz {
            padding: 80px 0;
            background: #fff;
        }
        
        .container-dz {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #1a1a1a;
            letter-spacing: -0.025em;
            line-height: 1.15;
            position: relative;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d3748 50%, #1a1a1a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -16px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--color-magenta) 0%, var(--color-rosa-claro) 50%, var(--color-magenta) 100%);
            border-radius: 2px;
            box-shadow: 0 3px 12px rgba(230, 0, 126, 0.4);
        }
        
        .section-title p {
            font-size: 1.3rem;
            color: #5a5a5a;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
            font-weight: 400;
        }
        
        .categorias-grid-dz {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 32px;
        }
        
        .categoria-card-dz {
            background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
            padding: 48px 32px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.06),
                0 1px 2px rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .categoria-card-dz::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--color-magenta), rgba(230, 0, 126, 0.3));
            transform: translateX(-100%);
            transition: transform 0.4s ease;
        }
        
        .categoria-card-dz:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(230, 0, 126, 0.08);
            border-color: rgba(230, 0, 126, 0.1);
        }
        
        .categoria-card-dz:hover::before {
            transform: translateX(0);
        }
        
        .categoria-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: var(--color-magenta);
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .categoria-icon.pink { 
            background: linear-gradient(135deg, #fce7f3 0%, #f9c2d4 100%);
            box-shadow: inset 0 2px 4px rgba(230, 0, 126, 0.1);
        }
        .categoria-icon.purple { 
            background: linear-gradient(135deg, #f3e8ff 0%, #ddd6fe 100%);
            box-shadow: inset 0 2px 4px rgba(139, 92, 246, 0.1);
        }
        .categoria-icon.yellow { 
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            box-shadow: inset 0 2px 4px rgba(251, 191, 36, 0.1);
        }
        .categoria-icon.green { 
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            box-shadow: inset 0 2px 4px rgba(34, 197, 94, 0.1);
        }
        
        .categoria-card-dz:hover .categoria-icon {
            transform: scale(1.05);
        }
        
        .categoria-card-dz h3 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a1a;
            letter-spacing: -0.01em;
        }
        
        .categoria-card-dz p {
            color: #5a5a5a;
            font-size: 0.95rem;
            line-height: 1.5;
            font-weight: 400;
        }
        
        /* Produtos Carrossel */
        .produtos-carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .carousel-btn {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(230, 0, 126, 0.3);
            z-index: 2;
            flex-shrink: 0;
        }
        
        .carousel-btn:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(230, 0, 126, 0.4);
        }
        
        .carousel-btn:active {
            transform: scale(0.95);
        }
        
        .carousel-btn span {
            font-size: 1.5rem;
        }
        .produtos-dz {
            padding: 70px 0;
            background: #f9fafb;
        }
        
        .produtos-grid-dz {
            display: flex;
            overflow: hidden;
            gap: 20px;
            scroll-behavior: smooth;
            flex: 1;
            padding: 10px 0;
            transition: transform 0.3s ease;
        }
        
        /* Scrollbar customizada para produtos */
        .produtos-grid-dz::-webkit-scrollbar {
            height: 8px;
        }
        
        .produtos-grid-dz::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        
        .produtos-grid-dz::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            border-radius: 4px;
        }
        
        .produtos-grid-dz::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
        }
        
        .produto-card-dz {
            background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
            border-radius: 16px;
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.05),
                0 1px 2px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            flex: 0 0 220px;
            min-width: 220px;
            height: 380px;
            display: flex;
            flex-direction: column;
        }
        
        .produto-card-dz:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 8px 16px rgba(230, 0, 126, 0.06);
        }
        
        .produto-img {
            background: linear-gradient(145deg, #fafafa 0%, #f5f5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: #999;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            height: 200px;
            flex-shrink: 0;
        }
        
        .produto-info-dz {
            padding: 20px 16px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .produto-info-dz h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a1a;
            line-height: 1.3;
            letter-spacing: -0.01em;
            flex-grow: 1;
        }
        
        .produto-price {
            margin-bottom: 16px;
            display: flex;
            align-items: baseline;
            gap: 8px;
        }
        
        .price-current {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--color-magenta);
            letter-spacing: -0.02em;
        }
        
        .price-old {
            font-size: 1rem;
            color: #999;
            text-decoration: line-through;
            font-weight: 500;
        }
        
        .discount-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 
                0 6px 16px rgba(239, 68, 68, 0.35),
                inset 0 1px 1px rgba(255, 255, 255, 0.2);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            animation: badgePulse 3s ease-in-out infinite;
            transform: rotate(-12deg);
        }
        
        @keyframes badgePulse {
            0%, 100% { 
                transform: rotate(-12deg) scale(1); 
                box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.2);
            }
            50% { 
                transform: rotate(-12deg) scale(1.08); 
                box-shadow: 0 8px 20px rgba(239, 68, 68, 0.45), inset 0 1px 1px rgba(255, 255, 255, 0.2);
            }
        }
        
        .btn-add-cart {
            width: 100%;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 10px 12px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-add-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-add-cart:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(230, 0, 126, 0.3);
        }
        
        .btn-add-cart:hover::before {
            left: 100%;
        }
        
        /* Banner */
        .banner-dz {
            padding: 100px 0;
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .banner-dz::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(230, 0, 126, 0.05) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .banner-dz h2 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #1a1a1a;
            position: relative;
            z-index: 1;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        
        .banner-dz .magenta {
            background: linear-gradient(135deg, var(--color-magenta) 0%, #ff1493 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }
        
        .banner-dz p {
            font-size: 1.4rem;
            color: #4a4a4a;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }
        
        /* Newsletter */
        .newsletter-dz {
            padding: 80px 0;
            text-align: center;
            background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.04);
        }
        
        .newsletter-form {
            max-width: 450px;
            margin: 0 auto;
            display: flex;
            gap: 16px;
            margin-top: 36px;
            background: linear-gradient(145deg, #f8f9fa 0%, #f1f3f4 100%);
            padding: 8px;
            border-radius: 60px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 16px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            background: transparent;
            color: #333;
            font-weight: 500;
        }
        
        .newsletter-form input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .newsletter-form button {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.3px;
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.25);
        }
        
        .newsletter-form button:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(230, 0, 126, 0.35);
        }
        
        /* Footer */
        .footer-dz {
            background: linear-gradient(180deg, #ffffff 0%, #fafafa 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            padding: 80px 0 40px;
            position: relative;
        }
        
        .footer-dz::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--color-magenta) 50%, transparent 100%);
            opacity: 0.3;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 50px;
        }
        
        .footer-section h5 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 24px;
            color: #1a1a1a;
            letter-spacing: -0.01em;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 12px;
        }
        
        .footer-section a {
            color: #5a5a5a;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .footer-section a:hover {
            color: var(--color-magenta);
            transform: translateX(2px);
        }
        
        .social-links {
            display: flex;
            gap: 20px;
            margin-top: 24px;
        }
        
        .social-links a {
            color: #999;
            font-size: 1.8rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(145deg, #ffffff 0%, #f5f5f5 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .social-links a:hover {
            color: var(--color-magenta);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        
        .footer-copyright {
            text-align: center;
            padding-top: 40px;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            color: #7a7a7a;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        /* Animações Premium */
        .fade-in-up {
            opacity: 0;
            transform: translateY(50px) scale(0.98);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        
        /* Adiciona micro-interação aos elementos com hover */
        .fade-in-up.visible:hover {
            transform: translateY(-2px) scale(1.01);
        }
        
        /* Delay escalonado para animações */
        .fade-in-up:nth-child(1) { transition-delay: 0.1s; }
        .fade-in-up:nth-child(2) { transition-delay: 0.2s; }
        .fade-in-up:nth-child(3) { transition-delay: 0.3s; }
        .fade-in-up:nth-child(4) { transition-delay: 0.4s; }
        .fade-in-up:nth-child(5) { transition-delay: 0.5s; }
        
        /* ===== NOVOS ELEMENTOS E-COMMERCE ===== */
        
        /* Badges de benefícios minimalistas */
        .benefit-badge {
            transition: all 0.3s ease;
            border-radius: 12px;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.06);
            padding: 24px 20px;
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 140px;
        }
        
        .benefit-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--color-magenta);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .benefit-badge:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-color: rgba(230, 0, 126, 0.1);
        }
        
        .benefit-badge:hover::before {
            opacity: 1;
        }
        
        .benefit-icon {
            width: 48px;
            height: 48px;
            background: #f8fafc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }
        
        .benefit-badge:hover .benefit-icon {
            background: var(--color-rose-light);
            transform: scale(1.1);
        }
        
        .benefit-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a202c;
            letter-spacing: -0.01em;
        }
        
        .benefit-description {
            color: #64748b;
            font-size: 0.875rem;
            line-height: 1.5;
            margin: 0;
        }
        
        /* Grid responsivo para benefícios */
        .benefits-grid {
            display: grid !important;
        }
        
        @media (max-width: 1024px) {
            .benefits-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 18px !important;
            }
        }
        
        @media (max-width: 640px) {
            .benefits-grid {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
        }
        
        /* Badge "Novo" para produtos */
        .badge-novo {
            position: absolute;
            top: 16px;
            left: 16px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            z-index: 3;
            animation: pulseGlow 3s ease-in-out infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% { 
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
                transform: scale(1); 
            }
            50% { 
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
                transform: scale(1.05); 
            }
        }
        
        /* CTAs melhorados */
        .btn-cta-primary {
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 12px 24px rgba(230, 0, 126, 0.35);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            min-width: 200px;
        }
        
        .btn-cta-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }
        
        .btn-cta-primary:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 20px 40px rgba(230, 0, 126, 0.45);
        }
        
        .btn-cta-primary:hover::before {
            left: 100%;
        }
        
        /* Badges de segurança */
        .security-badges {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            padding: 20px;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            margin: 30px 0;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .security-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #2d3748;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease;
        }
        
        .security-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .security-badge-icon {
            width: 16px;
            height: 16px;
            color: #10b981;
        }
        
        /* Contador em tempo real */
        .live-counter {
            display: inline-flex;
            align-items: center;
            background: rgba(239, 68, 68, 0.1);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #ef4444;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }
        
        .live-counter::before {
            content: '🔥';
            margin-right: 5px;
        }
        
        /* Selo de qualidade */
        .quality-seal {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
            z-index: 4;
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Melhorias nos cards de produto */
        .produto-card-dz {
            background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%);
            border-radius: 20px;
            box-shadow: 
                0 4px 16px rgba(0, 0, 0, 0.05),
                0 1px 2px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            flex: 0 0 220px;
            min-width: 220px;
            height: 420px; /* Aumentado para acomodar avaliações */
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .produto-card-dz::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(230, 0, 126, 0.03) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }
        
        .produto-card-dz:hover::before {
            opacity: 1;
        }
        
        .produto-card-dz:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 10px 20px rgba(230, 0, 126, 0.08);
        }
        
        /* Botão de favorito */
        .btn-favorite {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 5;
            backdrop-filter: blur(10px);
            color: #666;
        }
        
        .btn-favorite:hover {
            background: rgba(255, 255, 255, 1);
            color: #ef4444;
            transform: scale(1.1);
        }
        
        .btn-favorite.favorited {
            background: #ef4444;
            color: white;
        }
        
        /* Chat Button */
        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 9999;
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            color: white;
            font-size: 1.8rem;
        }
        
        .chat-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 12px 35px rgba(230, 0, 126, 0.6);
            background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark));
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
            background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark));
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
        
        /* Online Status Indicator */
        .online-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            opacity: 1 !important;
            margin-top: 4px;
        }
        
        .online-indicator {
            width: 8px;
            height: 8px;
            background: #00ff88;
            border-radius: 50%;
            /* Completamente estático - sem qualquer efeito */
        }
        
        .online-status span {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            /* Texto estático - sem animação */
            animation: none !important;
            transition: none !important;
            opacity: 1 !important;
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
            position: relative;
        }
        
        .chat-message.bot {
            background: linear-gradient(135deg, var(--color-rose-light), #fdf2f8);
            margin-right: 40px;
            color: #2d3748;
        }
        
        .chat-message.user {
            background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark));
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
            border-color: var(--color-magenta);
            background: white;
        }
        
        .chat-send {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark));
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
            background: linear-gradient(135deg, var(--color-magenta-dark), #a0005a);
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
        
        /* Responsividade do Chat */
        @media (max-width: 768px) {
            .chat-modal {
                width: calc(100vw - 20px);
                right: 10px;
                left: 10px;
                bottom: 100px;
                height: 450px;
            }
            
            .chat-button {
                bottom: 20px;
                right: 20px;
                width: 55px;
                height: 55px;
            }
        }
        
        .chat-button::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            /* Sem animação - totalmente estático */
        }
        
        /* Chat Tooltip */
        .chat-tooltip {
            position: absolute;
            left: -200px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 12px 16px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3748;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            white-space: nowrap;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .chat-tooltip::after {
            content: '';
            position: absolute;
            right: -8px;
            top: 50%;
            transform: translateY(-50%);
            border: 8px solid transparent;
            border-left-color: white;
        }
        
        .chat-button:hover .chat-tooltip {
            opacity: 1;
            visibility: visible;
        }
        
        /* Quick view button */
        .btn-quick-view {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(50px);
            background: rgba(255, 255, 255, 0.95);
            color: var(--color-magenta);
            border: 2px solid var(--color-magenta);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
            backdrop-filter: blur(10px);
            z-index: 6;
        }
        
        .produto-card-dz:hover .btn-quick-view {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        
        .btn-quick-view:hover {
            background: var(--color-magenta);
            color: white;
            transform: translateX(-50%) translateY(-2px);
        }
        
        /* Responsivo */
        @media (max-width: 968px) {
            .container-header {
                padding: 0 20px;
                gap: 24px;
            }
            
            .nav-loja ul {
                gap: 20px;
            }
            
            .nav-loja a {
                font-size: 0.9rem;
                padding: 10px 12px;
            }
        }
        
        @media (max-width: 768px) {
            .header-loja {
                padding: 8px 0;
            }
            
            .container-header {
                padding: 0 16px;
                gap: 16px;
            }
            
            .logo-dz-oficial {
                height: 35px;
            }
            
            .header-loja.scrolled .logo-dz-oficial {
                height: 30px;
            }
            
            .logo-dz-fallback {
                font-size: 2rem;
            }
            
            .logo-dz-fallback::before {
                width: 16px;
                height: 16px;
            }
            
            .nav-loja {
                display: none !important; /* Força esconder navegação principal */
            }
            
            /* Menu Hambúrguer Premium */
            .mobile-menu-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                border: none;
                background: rgba(230, 0, 126, 0.1);
                border-radius: 22px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .mobile-menu-toggle:hover {
                background: var(--color-magenta);
            }
            
            /* Menu Hambúrguer Premium */
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 44px;
                height: 44px;
                border: none;
                background: rgba(230, 0, 126, 0.1);
                border-radius: 22px;
                cursor: pointer;
                transition: all 0.3s ease;
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
                transform: translateX(100%); /* Força o menu para fora da tela */
                opacity: 0;
                visibility: hidden;
                pointer-events: none; /* Impede interações quando escondido */
            }
            
            .mobile-menu.active {
                right: 0;
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
                pointer-events: all;
            }
            
            /* Mobile menu overlay - inicialmente escondido */
            .mobile-menu-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(10px);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: all 0.3s ease;
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
                opacity: 0; /* Inicialmente invisível */
                transform: translateX(30px);
            }
            
            .mobile-menu.active a {
                opacity: 1;
                transform: translateX(0);
            }
            
            /* Delays para animação escalonada */
            .mobile-menu.active li:nth-child(1) a { transition-delay: 0.1s; }
            .mobile-menu.active li:nth-child(2) a { transition-delay: 0.15s; }
            .mobile-menu.active li:nth-child(3) a { transition-delay: 0.2s; }
            .mobile-menu.active li:nth-child(4) a { transition-delay: 0.25s; }
            
            .mobile-menu a:hover {
                background: rgba(230, 0, 126, 0.1);
                color: var(--color-magenta);
                transform: translateX(10px);
            }
            
            /* Mostrar botão mobile apenas em tablets/celulares - REMOVIDO DUPLICATA */
            
            .user-area {
                gap: 8px;
            }
            
            .btn-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .btn-cart {
                padding: 10px 16px;
                font-size: 0.85rem;
            }
            
            body {
                padding-top: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-content-dz {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
            }
            
            .categorias-grid-dz {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .produtos-carousel-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .carousel-btn {
                display: none;
            }
            
            .produtos-grid-dz {
                overflow-x: auto;
                padding: 10px 0 20px 0;
            }
            
            .produtos-grid-dz::-webkit-scrollbar {
                height: 8px;
            }
            
            .produto-card-dz {
                flex: 0 0 calc(50% - 10px);
                min-width: calc(50% - 10px);
                height: 350px;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        
        
        @media (max-width: 480px) {
            .categorias-grid-dz {
                grid-template-columns: 1fr;
            }
            
            .produtos-carousel-container {
                flex-direction: column;
            }
            
            .carousel-btn {
                display: none;
            }
            
            .produtos-grid-dz {
                flex-direction: column;
                align-items: center;
                overflow: visible;
            }
            
            .produto-card-dz {
                flex: 0 0 auto;
                min-width: 220px;
                width: 100%;
                max-width: 300px;
                height: 380px;
            }
        }
    </style>
</head>
<body>
    
    <!-- Loading da página -->
    
    <!-- ===== RESET MOBILE MENU FORCE ===== -->
    <style>
        /* FORÇA ESCONDER MENU MOBILE EM TODAS AS CONDIÇÕES */
        .mobile-menu,
        .mobile-menu-overlay {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            z-index: -1000 !important;
        }
        
        /* SÓ MOSTRA EM DISPOSITIVOS MÓVEIS */
        @media (max-width: 768px) {
            .mobile-menu,
            .mobile-menu-overlay {
                display: block !important;
                z-index: 1000 !important;
            }
            
            /* Mas ainda escondido até ser ativado */
            .mobile-menu:not(.active),
            .mobile-menu-overlay:not(.active) {
                visibility: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
            }
        }
    </style>
    
    <!-- ===== NAVBAR PREMIUM D&Z ===== -->
    <header class="header-loja" id="navbar">
        <div class="container-header">
            <!-- Logo D&Z Oficial -->
            <div class="logo-container">
                <img src="assets/images/Logodz.png" alt="D&Z" class="logo-dz-oficial">
                <span class="logo-text">D&Z</span>
            </div>
            
            <!-- Navegação -->
            <nav class="nav-loja">
                <ul>
                    <li><a href="#unhas">Unhas</a></li>
                    <li><a href="#cilios">Cílios</a></li>
                    <li><a href="#kits">Kits</a></li>
                    <li><a href="#novidades">Novidades</a></li>
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
                
                <button class="btn-icon" title="Pesquisar">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
                
                <button class="btn-icon" title="Minha Conta">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </button>
                
                <button class="btn-cart" title="Carrinho">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 6px;">
                        <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                    <span class="cart-count">0</span>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" onclick="closeMobileMenu()"></div>
    
    <!-- Mobile Menu -->
    <nav class="mobile-menu">
        <ul>
            <li><a href="#unhas" onclick="closeMobileMenu()">Unhas</a></li>
            <li><a href="#cilios" onclick="closeMobileMenu()">Cílios</a></li>
            <li><a href="#kits" onclick="closeMobileMenu()">Kits</a></li>
            <li><a href="#novidades" onclick="closeMobileMenu()">Novidades</a></li>
        </ul>
    </nav>

    <!-- ===== BANNER CARROSSEL ===== -->
    <section class="banner-carousel">
        <!-- Container do Carrossel -->
        <div class="carousel-container" id="carouselContainer">
            <!-- Slide 1 - Lançamento -->
            <div class="carousel-slide">
                <div class="carousel-content">
                    <h1 class="carousel-title">
                        Novidade <span style="color: var(--color-magenta);">D&Z</span><br>
                        Coleção Premium
                    </h1>
                    <p class="carousel-subtitle">
                        Descubra nossa nova linha de produtos profissionais para unhas e cílios. Qualidade superior para resultados incríveis.
                    </p>
                    <button class="carousel-btn">Ver Novidades</button>
                </div>
                <div class="carousel-visual">
                    <div class="carousel-image">
                        <div style="text-align: center; color: var(--color-magenta);">
                            <div style="font-size: 64px; margin-bottom: 12px;">💅</div>
                            <p style="font-weight: 600; margin: 0;">Nova Coleção</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 - Desconto -->
            <div class="carousel-slide">
                <div class="carousel-content">
                    <h1 class="carousel-title">
                        <span style="color: #ef4444;">50% OFF</span><br>
                        Em Kits Selecionados
                    </h1>
                    <p class="carousel-subtitle">
                        Aproveite nossa promoção especial! Kits completos com descontão de até 50% por tempo limitado.
                    </p>
                    <button class="carousel-btn" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);">Aproveitar Oferta</button>
                </div>
                <div class="carousel-visual">
                    <div class="carousel-image">
                        <div style="text-align: center; color: #ef4444;">
                            <div style="font-size: 64px; margin-bottom: 12px;">🎁</div>
                            <p style="font-weight: 600; margin: 0;">Super Oferta</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 - Cabeleireiros -->
            <div class="carousel-slide">
                <div class="carousel-content">
                    <h1 class="carousel-title">
                        Para <span style="color: #8b5cf6;">Profissionais</span><br>
                        Produtos Premium
                    </h1>
                    <p class="carousel-subtitle">
                        Linha exclusiva para salões e profissionais da beleza. Qualidade que seus clientes merecem.
                    </p>
                    <button class="carousel-btn" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">Linha Profissional</button>
                </div>
                <div class="carousel-visual">
                    <div class="carousel-image">
                        <div style="text-align: center; color: #8b5cf6;">
                            <div style="font-size: 64px; margin-bottom: 12px;">💄</div>
                            <p style="font-weight: 600; margin: 0;">Pro Line</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navegação -->
        <div class="carousel-navigation">
            <div class="carousel-dot active" onclick="goToSlide(0)"></div>
            <div class="carousel-dot" onclick="goToSlide(1)"></div>
            <div class="carousel-dot" onclick="goToSlide(2)"></div>
        </div>
        
        <!-- Setas de navegação -->
        <button class="carousel-arrows carousel-prev" onclick="previousSlide()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
        <button class="carousel-arrows carousel-next" onclick="nextSlide()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </section>

    <!-- ===== BENEFÍCIOS MINIMALISTAS ===== -->
    <section style="background: #fefefe; padding: 80px 0; border-top: 1px solid #f1f5f9;">
        <div class="container-dz">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1200px; margin: 0 auto;" class="benefits-grid">
                
                <!-- Entrega Grátis -->
                <div class="benefit-badge fade-in-up">
                    <div class="benefit-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: #10b981;">
                            <path d="M1 3h15l-1 9H4l-3 4v1a1 1 0 0 0 1 1h11M20 8v8" />
                            <path d="M7 15h6m4 0h1" />
                            <circle cx="7" cy="19" r="2" />
                            <circle cx="17" cy="19" r="2" />
                        </svg>
                    </div>
                    <h4 class="benefit-title">Entrega Grátis</h4>
                    <p class="benefit-description">Acima de R$ 99 para todo o Brasil</p>
                </div>

                <!-- Qualidade Premium -->
                <div class="benefit-badge fade-in-up">
                    <div class="benefit-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: var(--color-magenta);">
                            <path d="M9 12l2 2 4-4" />
                            <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />
                        </svg>
                    </div>
                    <h4 class="benefit-title">Qualidade Premium</h4>
                    <p class="benefit-description">Produtos testados e aprovados</p>
                </div>

                <!-- Troca Fácil -->
                <div class="benefit-badge fade-in-up">
                    <div class="benefit-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: #3b82f6;">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
                            <path d="M21 3v5h-5" />
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
                            <path d="M8 16H3v5" />
                        </svg>
                    </div>
                    <h4 class="benefit-title">Troca Fácil</h4>
                    <p class="benefit-description">7 dias para trocar ou devolver</p>
                </div>

                <!-- Suporte 24h -->
                <div class="benefit-badge fade-in-up">
                    <div class="benefit-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color: #f59e0b;">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10Z" />
                            <path d="M8 10h.01" />
                            <path d="M12 10h.01" />
                            <path d="M16 10h.01" />
                        </svg>
                    </div>
                    <h4 class="benefit-title">Suporte 24h</h4>
                    <p class="benefit-description">Atendimento especializado sempre</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CATEGORIAS ===== -->
    <section class="categorias-dz">
        <div class="container-dz">
            
            <!-- Título seção -->
            <div class="section-title fade-in-up">
                <h2>Nossas Categorias</h2>
                <p>Explore nossa coleção cuidadosamente selecionada de produtos premium</p>
            </div>
            
            <!-- Grid de categorias -->
            <div class="categorias-grid-dz">
                
                <!-- Unhas Profissionais -->
                <div class="categoria-card-dz fade-in-up">
                    <div class="categoria-icon pink">💅</div>
                    <h3>Unhas Profissionais</h3>
                    <p>Esmaltes e acessórios de qualidade premium</p>
                </div>
                
                <!-- Cílios -->
                <div class="categoria-card-dz fade-in-up">
                    <div class="categoria-icon purple">👁️</div>
                    <h3>Cílios</h3>
                    <p>Cílios postiços e produtos para alongamento</p>
                </div>
                
                <!-- Kits -->
                <div class="categoria-card-dz fade-in-up">
                    <div class="categoria-icon yellow">⭐</div>
                    <h3>Kits</h3>
                    <p>Kits completos para cuidado e beleza</p>
                </div>
                
                <!-- Novidades -->
                <div class="categoria-card-dz fade-in-up">
                    <div class="categoria-icon green">✨</div>
                    <h3>Novidades</h3>
                    <p>Últimos lançamentos e tendências</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUTOS EM DESTAQUE ===== -->
    <section class="produtos-dz">
        <div class="container-dz">
            
            <!-- Título seção -->
            <div class="section-title fade-in-up">
                <h2>Produtos em Destaque</h2>
                <p>Os favoritos das nossas clientes que transformam sua rotina de beleza</p>
            </div>
            
            <!-- Grid de produtos -->
            <div class="produtos-carousel-container">
                <button class="carousel-btn carousel-prev" id="prevBtn">
                    <span class="material-symbols-sharp">chevron_left</span>
                </button>
                
                <div class="produtos-grid-dz" id="produtosCarousel">
                
                <?php
                // Array de produtos mockados - futuramente virá do banco
                $produtos_destaque = [
                    [
                        'id' => 1,
                        'nome' => 'Kit Unhas Profissional',
                        'preco' => 89.90,
                        'preco_original' => 120.00,
                        'imagem' => '/assets/images/produtos/kit-unhas.jpg'
                    ],
                    [
                        'id' => 2,
                        'nome' => 'Cílios Premium Volume',
                        'preco' => 45.90,
                        'preco_original' => null,
                        'imagem' => '/assets/images/produtos/cilios-volume.jpg'
                    ],
                    [
                        'id' => 3,
                        'nome' => 'Esmalte Gel UV LED',
                        'preco' => 29.90,
                        'preco_original' => 39.90,
                        'imagem' => '/assets/images/produtos/esmalte-gel.jpg'
                    ],
                    [
                        'id' => 4,
                        'nome' => 'Kit Alongamento Cílios',
                        'preco' => 78.90,
                        'preco_original' => null,
                        'imagem' => '/assets/images/produtos/kit-alongamento.jpg'
                    ],
                    [
                        'id' => 5,
                        'nome' => 'Base Líquida Matte',
                        'preco' => 35.90,
                        'preco_original' => 49.90,
                        'imagem' => '/assets/images/produtos/base-matte.jpg'
                    ],
                    [
                        'id' => 6,
                        'nome' => 'Batom Cremoso HD',
                        'preco' => 19.90,
                        'preco_original' => null,
                        'imagem' => '/assets/images/produtos/batom-hd.jpg'
                    ]
                ];

                foreach ($produtos_destaque as $produto): 
                ?>
                
                <!-- Card de produto -->
                <div class="produto-card-dz fade-in-up">
                    <!-- Badge "Novo" para alguns produtos -->
                    <?php if (rand(1, 3) == 1): ?>
                    <div class="badge-novo">Novo</div>
                    <?php endif; ?>
                    
                    <!-- Botão favoritar -->
                    <button class="btn-favorite" onclick="toggleFavorite(this)" title="Adicionar aos favoritos">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                    
                    <div class="produto-img">
                        <div style="text-align: center; position: relative; z-index: 2;">
                            <div style="font-size: 60px; margin-bottom: 10px;">💎</div>
                            <p style="font-size: 0.75rem; opacity: 0.7;">Produto <?php echo $produto['id']; ?></p>
                        </div>
                        
                        <!-- Quick View Button -->
                        <button class="btn-quick-view" onclick="quickView(<?php echo $produto['id']; ?>)">👁️ Preview</button>
                        
                        <!-- Selo de qualidade para alguns produtos -->
                        <?php if (rand(1, 4) == 1): ?>
                        <div class="quality-seal" title="Produto Premium">⭐</div>
                        <?php endif; ?>
                        
                        <!-- Badge de desconto -->
                        <?php if ($produto['preco_original']): ?>
                        <div class="discount-badge">
                            <?php echo round((($produto['preco_original'] - $produto['preco']) / $produto['preco_original']) * 100); ?>% OFF
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="produto-info-dz">
                        <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                        
                        <!-- Avaliações -->
                        <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                            <div style="color: #fbbf24; display: flex; gap: 2px;">
                                <span style="font-size: 0.8rem;">⭐⭐⭐⭐⭐</span>
                            </div>
                            <span style="color: #6b7280; font-size: 0.75rem; font-weight: 600;">(<?php echo rand(15, 99); ?>)</span>
                        </div>

                        <div class="produto-price">
                            <span class="price-current">
                                R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                            </span>
                            <?php if ($produto['preco_original']): ?>
                            <span class="price-old">
                                R$ <?php echo number_format($produto['preco_original'], 2, ',', '.'); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <button class="btn-add-cart">
                            🛒 Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
                
                <?php endforeach; ?>
            </div>
            
            <button class="carousel-btn carousel-next" id="nextBtn">
                <span class="material-symbols-sharp">chevron_right</span>
            </button>
        </div>
            
            <!-- Botão ver mais -->
            <div style="text-align: center;" class="fade-in-up">
                <button class="btn btn-outline">
                    Ver Todos os Produtos
                </button>
            </div>
        </div>
    </section>

    <!-- ===== PRODUTOS MAIS VENDIDOS ===== -->
    <section style="padding: 80px 0; background: #fff;">
        <div class="container-dz">
            
            <!-- Título seção -->
            <div class="section-title fade-in-up">
                <h2>Mais Vendidos</h2>
                <p>Os produtos que nossas clientes mais amam e não conseguem viver sem</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-bottom: 50px;">
                
                <?php
                $produtos_mais_vendidos = [
                    [
                        'posicao' => 1,
                        'nome' => 'Kit Unhas Gold Premium',
                        'preco' => 129.90,
                        'preco_original' => 180.00,
                        'vendas' => 847
                    ],
                    [
                        'posicao' => 2,
                        'nome' => 'Cílios Mega Volume 3D',
                        'preco' => 65.90,
                        'preco_original' => null,
                        'vendas' => 623
                    ],
                    [
                        'posicao' => 3,
                        'nome' => 'Base Perfeita Multi-Tom',
                        'preco' => 49.90,
                        'preco_original' => 69.90,
                        'vendas' => 412
                    ]
                ];

                foreach ($produtos_mais_vendidos as $produto): 
                ?>
                
                <!-- Card Top Product -->
                <div class="fade-in-up" style="background: linear-gradient(145deg, #ffffff 0%, #fefefe 100%); border-radius: 20px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); overflow: hidden; position: relative; transition: all 0.3s ease; cursor: pointer;" 
                     onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 20px 40px rgba(0, 0, 0, 0.15)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 32px rgba(0, 0, 0, 0.08)'">
                    
                    <!-- Badge de posição -->
                    <div style="position: absolute; top: 20px; left: 20px; background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; padding: 8px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4); z-index: 2;">
                        #<?php echo $produto['posicao']; ?> Mais Vendido
                    </div>
                    
                    <?php if ($produto['preco_original']): ?>
                    <div style="position: absolute; top: 20px; right: 20px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 8px 16px; border-radius: 25px; font-size: 0.75rem; font-weight: 700; transform: rotate(-5deg); box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);">
                        <?php echo round((($produto['preco_original'] - $produto['preco']) / $produto['preco_original']) * 100); ?>% OFF
                    </div>
                    <?php endif; ?>
                    
                    <!-- Imagem -->
                    <div style="background: linear-gradient(145deg, #fafafa 0%, #f5f5f5 100%); height: 200px; display: flex; align-items: center; justify-content: center; color: var(--color-magenta); border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                        <div style="text-align: center;">
                            <div style="font-size: 70px; margin-bottom: 10px;">🏆</div>
                            <p style="font-size: 0.75rem; opacity: 0.7; margin: 0;"><?php echo $produto['vendas']; ?> vendas</p>
                        </div>
                    </div>
                    
                    <!-- Conteúdo -->
                    <div style="padding: 24px;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 12px; color: #1a1a1a; line-height: 1.3;"><?php echo $produto['nome']; ?></h3>
                        
                        <!-- Avaliações -->
                        <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
                            <div style="color: #fbbf24; display: flex; gap: 1px;">
                                <span style="font-size: 0.9rem;">⭐⭐⭐⭐⭐</span>
                            </div>
                            <span style="color: #6b7280; font-size: 0.8rem; font-weight: 600;">(<?php echo rand(150, 500); ?>)</span>
                        </div>
                        
                        <div style="margin-bottom: 20px; display: flex; align-items: baseline; gap: 10px;">
                            <span style="font-size: 1.4rem; font-weight: 700; color: var(--color-magenta);">
                                R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                            </span>
                            <?php if ($produto['preco_original']): ?>
                            <span style="font-size: 1rem; color: #999; text-decoration: line-through;">
                                R$ <?php echo number_format($produto['preco_original'], 2, ',', '.'); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <button style="width: 100%; background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark)); color: white; padding: 12px; border: none; border-radius: 12px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 6px 20px rgba(230, 0, 126, 0.3);" 
                                onmouseover="this.style.background='linear-gradient(135deg, var(--color-magenta-dark), #a0005a)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(230, 0, 126, 0.4)'"
                                onmouseout="this.style.background='linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark))'; this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 20px rgba(230, 0, 126, 0.3)'">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
                
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===== DEPOIMENTOS DE CLIENTES ===== -->
    <section style="padding: 80px 0; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);">
        <div class="container-dz">
            
            <!-- Título seção -->
            <div class="section-title fade-in-up">
                <h2>O que dizem nossas clientes</h2>
                <p>Milhares de mulheres já transformaram sua rotina de beleza conosco</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                
                <!-- Depoimento 1 -->
                <div class="fade-in-up" style="background: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.8);">
                    <div style="color: #fbbf24; margin-bottom: 15px; display: flex; gap: 2px;">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p style="color: #4b5563; line-height: 1.6; margin-bottom: 20px; font-style: italic;">"Simplesmente apaixonada pelos produtos! A qualidade é incrível e o atendimento é excepcional. Minha pele nunca esteve tão bonita!"</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem;">M</div>
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 600; color: #1a1a1a; margin-bottom: 2px;">Maria Silva</h4>
                            <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">Cliente verificada</p>
                        </div>
                    </div>
                </div>
                
                <!-- Depoimento 2 -->
                <div class="fade-in-up" style="background: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.8);">
                    <div style="color: #fbbf24; margin-bottom: 15px; display: flex; gap: 2px;">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p style="color: #4b5563; line-height: 1.6; margin-bottom: 20px; font-style: italic;">"O kit de unhas é perfeito! Resultado de salão em casa. Economizei muito e o resultado é profissional. Super recomendo!"</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem;">A</div>
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 600; color: #1a1a1a; margin-bottom: 2px;">Ana Costa</h4>
                            <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">Cliente verificada</p>
                        </div>
                    </div>
                </div>
                
                <!-- Depoimento 3 -->
                <div class="fade-in-up" style="background: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 16px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.06); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.8);">
                    <div style="color: #fbbf24; margin-bottom: 15px; display: flex; gap: 2px;">
                        <span>⭐⭐⭐⭐⭐</span>
                    </div>
                    <p style="color: #4b5563; line-height: 1.6; margin-bottom: 20px; font-style: italic;">"Entrega rápida e produtos originais! Já fiz várias compras e sempre fico satisfeita. Virei cliente fiel da D&Z!"</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.1rem;">C</div>
                        <div>
                            <h4 style="font-size: 0.9rem; font-weight: 600; color: #1a1a1a; margin-bottom: 2px;">Carla Mendes</h4>
                            <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">Cliente verificada</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Estatísticas -->
            <div style="margin-top: 60px; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center;">
                <div class="fade-in-up">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-magenta); margin-bottom: 8px;">98%</div>
                    <p style="color: #6b7280; font-weight: 600;">Clientes satisfeitas</p>
                </div>
                <div class="fade-in-up">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-magenta); margin-bottom: 8px;">50k+</div>
                    <p style="color: #6b7280; font-weight: 600;">Produtos vendidos</p>
                </div>
                <div class="fade-in-up">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-magenta); margin-bottom: 8px;">4.9</div>
                    <p style="color: #6b7280; font-weight: 600;">Avaliação média</p>
                </div>
                <div class="fade-in-up">
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--color-magenta); margin-bottom: 8px;">24h</div>
                    <p style="color: #6b7280; font-weight: 600;">Entrega rápida</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== BANNER PROMOCIONAL ===== -->
    <section class="banner-dz">
        <div class="container-dz fade-in-up" style="text-align: center;">
            <!-- Badge de oferta limitada -->
            <div style="display: inline-flex; align-items: center; background: rgba(255, 255, 255, 0.9); padding: 8px 20px; border-radius: 50px; margin-bottom: 20px; backdrop-filter: blur(10px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);">
                <span style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%; margin-right: 8px; animation: pulse 2s infinite;"></span>
                <span style="color: #ef4444; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Oferta Limitada</span>
            </div>
            
            <h2 style="margin-bottom: 20px;">
                Primeira compra com <span class="magenta">15% OFF</span>
                <br>
                <span style="font-size: 1.8rem; font-weight: 500;">Use o cupom: <strong style="background: linear-gradient(135deg, #fbbf24, #f59e0b); padding: 4px 12px; border-radius: 6px; color: white; font-size: 1.2rem; letter-spacing: 1px;">BEM-VINDA15</strong></span>
            </h2>
            <p style="margin-bottom: 30px; font-size: 1.2rem;">
                Válido apenas hoje! Não perca esta oportunidade de conhecer nossos produtos premium com desconto especial.
            </p>
            
            <!-- Timer countdown -->
            <div style="display: inline-flex; gap: 15px; margin-bottom: 30px; background: rgba(255, 255, 255, 0.95); padding: 20px 30px; border-radius: 15px; backdrop-filter: blur(10px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);">
                <div style="text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--color-magenta); line-height: 1;">23</div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">Horas</div>
                </div>
                <div style="color: var(--color-magenta); font-size: 1.8rem; font-weight: 700;">:</div>
                <div style="text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--color-magenta); line-height: 1;">45</div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">Minutos</div>
                </div>
                <div style="color: var(--color-magenta); font-size: 1.8rem; font-weight: 700;">:</div>
                <div style="text-align: center;">
                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--color-magenta); line-height: 1;">12</div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; letter-spacing: 1px;">Segundos</div>
                </div>
            </div>
            
            <br>
            <button class="btn-hero" style="position: relative; overflow: hidden; background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 12px 24px rgba(239, 68, 68, 0.4); font-size: 1.2rem; padding: 20px 40px;" 
                    onmouseover="this.style.background='linear-gradient(135deg, #dc2626, #b91c1c)'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 20px 40px rgba(239, 68, 68, 0.5)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 12px 24px rgba(239, 68, 68, 0.4)'">
                Aproveitar Desconto Agora!
            </button>
        </div>
    </section>
    
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>

    <!-- ===== NEWSLETTER ===== -->
    <section class="newsletter-dz">
        <div class="container-dz fade-in-up">
            <h3 style="font-size: 2rem; font-weight: bold; margin-bottom: 16px; color: #333;">
                Fique por dentro das novidades
            </h3>
            <p style="color: #666; margin-bottom: 8px;">
                Receba em primeira mão nossos lançamentos, dicas de beleza e ofertas exclusivas
            </p>
            
            <form class="newsletter-form">
                <input 
                    type="email" 
                    placeholder="Seu melhor e-mail" 
                    required
                >
                <button type="submit">
                    Inscrever-se
                </button>
            </form>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer-dz">
        <div class="container-dz">
            <div class="footer-grid">
                
                <!-- Logo e descrição -->
                <div class="footer-section fade-in-up">
                    <h4 style="font-size: 2rem; font-weight: bold; color: var(--color-magenta); margin-bottom: 16px;">D&Z</h4>
                    <p style="color: #666; margin-bottom: 16px;">
                        E-commerce premium de beleza para mulheres que sabem o que querem.
                    </p>
                    <!-- Redes sociais -->
                    <div class="social-links">
                        <a href="#">🐦</a>
                        <a href="#">📌</a>
                        <a href="#">📷</a>
                    </div>
                </div>
                
                <!-- Links produtos -->
                <div class="footer-section fade-in-up">
                    <h5>Produtos</h5>
                    <ul>
                        <li><a href="#">Unhas Profissionais</a></li>
                        <li><a href="#">Cílios Premium</a></li>
                        <li><a href="#">Kits Completos</a></li>
                        <li><a href="#">Novidades</a></li>
                    </ul>
                </div>
                
                <!-- Links institucional -->
                <div class="footer-section fade-in-up">
                    <h5>Institucional</h5>
                    <ul>
                        <li><a href="#">Sobre Nós</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos de Uso</a></li>
                        <li><a href="#">Trabalhe Conosco</a></li>
                    </ul>
                </div>
                
                <!-- Contato -->
                <div class="footer-section fade-in-up">
                    <h5>Contato</h5>
                    <ul>
                        <li style="color: #666;">contato@dzecommerce.com.br</li>
                        <li style="color: #666;">(11) 9999-9999</li>
                        <li style="color: #666;">Segunda à Sexta, 9h às 18h</li>
                    </ul>
                </div>
            </div>
            
            <!-- Badges de segurança -->
            <div class="security-badges fade-in-up">
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Compra Segura
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                    SSL 256-bit
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Site Verificado
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM10 14a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                    Produtos Originais
                </div>
            </div>
            
            <!-- Badges de segurança -->
            <div class="security-badges fade-in-up">
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Compra Segura
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                    SSL 256-bit
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Site Verificado
                </div>
                <div class="security-badge">
                    <svg class="security-badge-icon" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM10 14a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                    Produtos Originais
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="footer-copyright">
                <p>
                    © 2026 D&Z E-commerce. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- ===== JAVASCRIPT ===== -->
    <script>
        // ===== ANIMAÇÕES DE SCROLL (IntersectionObserver) =====
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Menu Mobile
        function toggleMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            hamburger.classList.toggle('open');
            overlay.classList.toggle('active');
            menu.classList.toggle('active');
        }
        
        function closeMobileMenu() {
            const hamburger = document.querySelector('.hamburger');
            const overlay = document.querySelector('.mobile-menu-overlay');
            const menu = document.querySelector('.mobile-menu');
            
            hamburger.classList.remove('open');
            overlay.classList.remove('active');
            menu.classList.remove('active');
        }
        
        /* ===== MENU MOBILE PREMIUM =====*/
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

        // ===== NAVBAR INTERATIVA =====
        // Efeito de scroll na navbar
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Navegação suave
        document.querySelectorAll('.nav-loja a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                if (targetId.startsWith('#')) {
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop - 100;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
        
        // ===== FAVORITOS =====
        function toggleFavorite(button) {
            button.classList.toggle('favorited');
            
            // Feedback visual
            const icon = button.querySelector('svg');
            if (button.classList.contains('favorited')) {
                icon.style.transform = 'scale(1.3)';
                setTimeout(() => {
                    icon.style.transform = 'scale(1)';
                }, 200);
                
                // Notificação
                showNotification('Adicionado aos favoritos! ❤️', 'success');
            } else {
                showNotification('Removido dos favoritos', 'info');
            }
        }
        
        // ===== QUICK VIEW =====
        function quickView(produtoId) {
            // Simulação de quick view
            showNotification('Quick View em desenvolvimento 👀', 'info');
            console.log('Quick view do produto:', produtoId);
            
            // Aqui seria aberto um modal com detalhes do produto
        }
        
        // ===== SISTEMA DE NOTIFICAÇÕES MELHORADO =====
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            
            const colors = {
                success: 'linear-gradient(135deg, #10b981, #059669)',
                info: 'linear-gradient(135deg, #3b82f6, #1e40af)',
                warning: 'linear-gradient(135deg, #f59e0b, #d97706)',
                error: 'linear-gradient(135deg, #ef4444, #dc2626)'
            };
            
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${colors[type]};
                color: white;
                padding: 16px 24px;
                border-radius: 12px;
                font-weight: 600;
                z-index: 10000;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
                transform: translateX(100%);
                transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                max-width: 300px;
                backdrop-filter: blur(10px);
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animar entrada
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remover após 4 segundos
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 400);
            }, 4000);
        }
        
        // ===== CONTADOR EM TEMPO REAL (DESABILITADO) =====
        // Função desabilitada para evitar popups intrusivos
        
        // Atualizar contador do carrinho 
        function updateCartCount(count) {
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = count;
                cartCount.style.animation = 'none';
                setTimeout(() => {
                    cartCount.style.animation = 'bounce 0.5s ease';
                }, 10);
            }
        }
        
        // Observar todos os elementos com classe fade-in-up
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.fade-in-up');
            animatedElements.forEach(function(element) {
                observer.observe(element);
            });
        });

        // ===== CARRINHO (FUNCIONALIDADE BÁSICA) =====
        let carrinhoItens = 0;

        function adicionarAoCarrinho(produtoNome) {
            carrinhoItens++;
            
            // Atualizar contador do carrinho usando a nova estrutura
            updateCartCount(carrinhoItens);
            
            // Feedback visual premium
            // Usar novo sistema de notificações
            showNotification(`🛒 ${produtoNome} adicionado ao carrinho!`, 'success');
            
            // Aqui seria implementada a lógica real do carrinho
            // Salvar no localStorage ou enviar para servidor
        }

        // Adicionar event listeners aos botões de adicionar ao carrinho
        document.addEventListener('DOMContentLoaded', function() {
            const botoes = document.querySelectorAll('.btn-add-cart');
            
            botoes.forEach(function(botao) {
                botao.addEventListener('click', function() {
                    // Pegar dados do produto do elemento pai
                    const cardProduto = this.closest('.produto-card-dz');
                    const nomeProduto = cardProduto ? cardProduto.querySelector('h3').textContent : 'Produto';
                    
                    // Animação no botão
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                    
                    adicionarAoCarrinho(nomeProduto.trim());
                });
            });
        });

        // ===== NEWSLETTER FORM =====
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForm = document.querySelector('.newsletter-form');
            
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const email = this.querySelector('input[type="email"]').value;
                    
                    if (email) {
                        // Simulação de carregamento
                        const button = this.querySelector('button');
                        const originalText = button.textContent;
                        button.textContent = 'Inscrevendo...';
                        button.disabled = true;
                        
                        setTimeout(() => {
                            showNotification('Inscrição realizada com sucesso! 🎉 Você receberá 15% de desconto no primeiro pedido.', 'success');
                            this.querySelector('input[type="email"]').value = '';
                            button.textContent = originalText;
                            button.disabled = false;
                        }, 1500);
                    }
                });
            }
        });

        // ===== CHAT SYSTEM INTERNO =====
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
                <!-- Header -->
                <div class="chat-header">
                    <div>
                        <h3>D&Z Atendimento</h3>
                        <div class="online-status"><div class="online-indicator"></div><span>Online agora</span></div>
                    </div>
                    <button class="chat-close" onclick="toggleChatModal()">×</button>
                </div>
                
                <!-- Messages -->
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
                
                <!-- Input -->
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
            
            // Enter para enviar mensagem
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
                // Focar no input
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
            
            // Adicionar mensagem do usuário
            addMessage(message, 'user');
            input.value = '';
            
            // Simular resposta do bot
            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    respondToMessage(message);
                }, Math.random() * 2000 + 1000); // 1-3 segundos
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
            // Respostas baseadas em palavras-chave
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
            
            // Respostas padrão
            return [
                'Que interessante! Posso te ajudar com informações sobre nossos produtos. O que gostaria de saber? 😊',
                'Claro! Estou aqui para esclarecer suas dúvidas. Tem alguma pergunta sobre nossos produtos? ✨',
                'Entendi! Nossos produtos de beleza são incríveis. Quer saber mais sobre alguma categoria específica? 💄',
                'Perfeito! Como posso tornar sua experiência ainda melhor? Tenho informações sobre produtos, entrega e mais! 🚀'
            ];
        }
        
        // ===== SMOOTH SCROLL PARA LINKS INTERNOS =====
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href^="#"]');
            
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    
                    if (target) {
                        const headerOffset = 80;
                        const elementPosition = target.offsetTop;
                        const offsetPosition = elementPosition - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });

        // ===== CONSOLE LOG PARA DEBUG =====
        console.log('D&Z E-commerce carregado com sucesso!');
        console.log('Design premium para mulheres que sabem o que querem');
        console.log('Navbar elementos:', {
            hamburger: document.querySelector('.hamburger'),
            overlay: document.querySelector('.mobile-menu-overlay'),
            menu: document.querySelector('.mobile-menu')
        });
        
        // ===== CARROSSEL BANNER =====
        let currentSlide = 0;
        const totalSlides = 3;
        
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            const container = document.getElementById('carouselContainer');
            const dots = document.querySelectorAll('.carousel-dot');
            
            container.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }
        
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            goToSlide(currentSlide);
        }
        
        function previousSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            goToSlide(currentSlide);
        }
        
        // Auto slide a cada 6 segundos
        setInterval(() => {
            nextSlide();
        }, 6000);
    </script>

    <!-- Carrossel de Produtos -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('produtosCarousel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            if (!carousel || !prevBtn || !nextBtn) return;
            
            let currentIndex = 0;
            const cardWidth = 240; // 220px + 20px gap
            const visibleCards = Math.floor(carousel.parentElement.clientWidth / cardWidth);
            const totalCards = carousel.children.length;
            const maxIndex = Math.max(0, totalCards - visibleCards);
            
            function updateCarousel() {
                const translateX = -currentIndex * cardWidth;
                carousel.style.transform = `translateX(${translateX}px)`;
                
                // Atualizar estados dos botões
                prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
                nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
                prevBtn.style.cursor = currentIndex === 0 ? 'not-allowed' : 'pointer';
                nextBtn.style.cursor = currentIndex >= maxIndex ? 'not-allowed' : 'pointer';
            }
            
            prevBtn.addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateCarousel();
                }
            });
            
            nextBtn.addEventListener('click', function() {
                if (currentIndex < maxIndex) {
                    currentIndex++;
                    updateCarousel();
                }
            });
            
            // Touch/Swipe para mobile
            let startX = 0;
            let isDragging = false;
            
            carousel.addEventListener('touchstart', function(e) {
                startX = e.touches[0].clientX;
                isDragging = true;
            });
            
            carousel.addEventListener('touchend', function(e) {
                if (!isDragging) return;
                
                const endX = e.changedTouches[0].clientX;
                const diff = startX - endX;
                
                if (Math.abs(diff) > 50) {
                    if (diff > 0 && currentIndex < maxIndex) {
                        currentIndex++;
                    } else if (diff < 0 && currentIndex > 0) {
                        currentIndex--;
                    }
                    updateCarousel();
                }
                
                isDragging = false;
            });
            
            // Atualizar no resize
            window.addEventListener('resize', function() {
                const newVisibleCards = Math.floor(carousel.parentElement.clientWidth / cardWidth);
                const newMaxIndex = Math.max(0, totalCards - newVisibleCards);
                
                if (currentIndex > newMaxIndex) {
                    currentIndex = newMaxIndex;
                }
                updateCarousel();
            });
            
            // Inicializar
            updateCarousel();
        });
    </script>

    <!-- Verificação de carregamento -->
    <script>
        // Verifica se o DOM foi carregado completamente
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM carregado com sucesso');
            
            // Verificar se todos os elementos importantes existem
            const navbar = document.getElementById('navbar');
            const mobileButton = document.querySelector('.mobile-menu-toggle');
            
            if (!navbar) console.warn('Navbar não encontrada');
            if (!mobileButton) console.warn('Botão mobile não encontrado');
            
            console.log('Página D&Z carregada completamente');
        });
    </script>

    <!-- Scripts Finais de E-commerce Profissional -->
    <script>
        // ===== FUNCIONALIDADES EXTRAS E-COMMERCE =====
        
        // Função de estoque removida para evitar mensagens intrusivas
        
        // ===== LAZY LOADING SIMULATION =====
        function simulateLazyLoading() {
            const productPlaceholders = document.querySelectorAll('.produto-img');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !entry.target.classList.contains('loaded')) {
                        // Simular carregamento de imagem
                        setTimeout(() => {
                            entry.target.classList.add('loaded');
                            const placeholder = entry.target.querySelector('div');
                            if (placeholder) {
                                placeholder.style.background = 'linear-gradient(145deg, #f0f0f0 0%, #e0e0e0 100%)';
                            }
                        }, Math.random() * 500 + 200);
                    }
                });
            });
            
            productPlaceholders.forEach(placeholder => {
                observer.observe(placeholder);
            });
        }
        
        // ===== POP-UP DE DESCONTO (PRIMEIRA VISITA) =====
        function showWelcomeDiscount() {
            // Verificar se já mostrou o pop-up E se o usuário não está navegando pela primeira vez
            if (!localStorage.getItem('dz_welcome_shown') && !sessionStorage.getItem('dz_just_arrived')) {
                // Marcar que o usuário acabou de chegar (evita popup imediato)
                sessionStorage.setItem('dz_just_arrived', 'true');
                
                setTimeout(() => {
                    // Verificar novamente se não foi fechado enquanto esperava
                    if (!localStorage.getItem('dz_welcome_shown')) {
                        const popup = document.createElement('div');
                        popup.style.cssText = `
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: rgba(0, 0, 0, 0.7);
                            z-index: 10000;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            backdrop-filter: blur(5px);
                        `;
                        
                        popup.innerHTML = `
                            <div style="
                                background: white;
                                padding: 40px;
                                border-radius: 20px;
                                text-align: center;
                                max-width: 400px;
                                margin: 20px;
                                position: relative;
                                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
                            ">
                                <button onclick="this.parentElement.parentElement.remove(); localStorage.setItem('dz_welcome_shown', 'true')" 
                                        style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #666;">×</button>
                                
                                <div style="font-size: 3rem; margin-bottom: 20px;">🎉</div>
                                <h3 style="color: var(--color-magenta); margin-bottom: 15px; font-size: 1.5rem;">Bem-vinda à D&Z!</h3>
                                <p style="margin-bottom: 20px; color: #666;">
                                    Ganhe <strong style="color: var(--color-magenta);">15% de desconto</strong> na sua primeira compra!
                                </p>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                                    <strong style="color: var(--color-magenta); font-size: 1.2rem;">BEM-VINDA15</strong>
                                </div>
                                <button onclick="this.parentElement.parentElement.remove(); localStorage.setItem('dz_welcome_shown', 'true'); showNotification('Cupom copiado! Cole no checkout para ganhar 15% OFF 🎉', 'success')" 
                                        style="background: linear-gradient(135deg, var(--color-magenta), var(--color-magenta-dark)); color: white; padding: 12px 30px; border: none; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                                    Aproveitar Desconto
                                </button>
                            </div>
                        `;
                        
                        document.body.appendChild(popup);
                    }
                }, 8000); // Aumentar para 8 segundos
            }
        }
        
        // ===== INICIALIZAÇÃO =====
        document.addEventListener('DOMContentLoaded', function() {
            // Criar botão de chat
            createChatButton();
            
            // Simular lazy loading
            simulateLazyLoading();
            
            // Mostrar pop-up de boas-vindas (apenas uma vez, após 10 segundos)
            setTimeout(() => {
                if (!localStorage.getItem('dz_welcome_shown')) {
                    showWelcomeDiscount();
                }
            }, 10000);
            
            console.log('🎉 D&Z E-commerce Premium carregado!');
            console.log('✨ Funcionalidades: Chat, Scroll, Lazy Loading');
        });
        
        // ===== LOG FINAL =====
        console.log('%c🛍️ D&Z E-commerce', 'color: #E6007E; font-size: 20px; font-weight: bold;');
        console.log('%cE-commerce premium para mulheres que sabem o que querem!', 'color: #666; font-size: 12px;');
    </script>

    <!-- Scripts adicionais que serão implementados futuramente -->
    <!-- <script src="loja.js"></script> -->
</body>
</html>
