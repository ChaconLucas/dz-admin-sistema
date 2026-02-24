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
        
        .container-dz {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1e293b;
            letter-spacing: -0.03em;
            line-height: 1.1;
            position: relative;
            background: linear-gradient(135deg, #1e293b 0%, var(--color-magenta) 50%, #1e293b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-shift 4s ease-in-out infinite;
        }
        
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .section-title h2::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -60px;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--color-magenta));
            transform: translateY(-50%);
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -60px;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, var(--color-magenta), transparent);
            transform: translateY(-50%);
        }
        
        .section-title p {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
            font-weight: 400;
        }
        
        /* Responsivo Titles */
        @media (max-width: 768px) {
            .section-title h2 {
                font-size: 2.5rem;
            }
            
            .section-title h2::before,
            .section-title h2::after {
                display: none;
            }
            
            .section-title p {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 480px) {
            .section-title h2 {
                font-size: 2rem;
                letter-spacing: -0.02em;
            }
            
            .section-title p {
                font-size: 1rem;
            }
        }
        .categorias-dz {
            padding: 100px 0;
            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);
        }
        
        /* Cards de Produtos - Lançamentos */
        .lancamentos-carousel-container {
            position: relative;
            margin-bottom: 40px;
        }
        
        .lancamentos-grid {
            display: flex;
            gap: 30px;
            overflow: hidden;
            scroll-behavior: smooth;
            margin-bottom: 40px;
        }
        
        .produto-card {
            flex: 0 0 280px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
        }
        
        .produto-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(230, 0, 126, 0.2);
        }
        
        .produto-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .produto-image::before {
            content: '';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 60px;
            height: 20px;
            background: #10b981;
            color: white;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .produto-image.novo::before { content: 'NOVO'; background: #10b981; }
        .produto-image.lancamento::before { content: 'LANÇAMENTO'; background: #f59e0b; }
        .produto-image.exclusivo::before { content: 'EXCLUSIVO'; background: #8b5cf6; }
        
        .produto-placeholder {
            font-size: 3rem;
            color: var(--color-magenta);
            opacity: 0.6;
        }
        
        .produto-content {
            padding: 20px;
        }
        
        .produto-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        
        .produto-description {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 15px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .produto-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-magenta);
            margin-bottom: 15px;
        }
        
        .produto-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .produto-btn:hover {
            background: linear-gradient(135deg, var(--color-magenta-dark) 0%, #a0005a 100%);
            transform: translateY(-1px);
        }
        
        .carousel-nav-arrows {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: 2px solid #f1f5f9;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 5;
            color: #64748b;
        }
        
        .carousel-nav-arrows:hover {
            background: var(--color-magenta);
            color: white;
            border-color: var(--color-magenta);
            transform: translateY(-50%) scale(1.1);
        }
        
        .carousel-nav-prev {
            left: -25px;
        }
        
        .carousel-nav-next {
            right: -25px;
        }
        
        .ver-todos-btn {
            text-align: center;
            margin-top: 30px;
        }
        
        .ver-todos-btn button {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        
        .ver-todos-btn button:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(71, 85, 105, 0.3);
        }
        
        /* Responsivo Cards Produtos */
        @media (max-width: 768px) {
            .lancamentos-grid {
                gap: 20px;
                padding: 0 20px;
            }
            
            .produto-card {
                flex: 0 0 250px;
            }
            
            .produto-image {
                height: 180px;
            }
            
            .produto-content {
                padding: 15px;
            }
            
            .produto-title {
                font-size: 1.1rem;
            }
            
            .produto-description {
                font-size: 0.85rem;
            }
            
            .produto-price {
                font-size: 1.3rem;
            }
            
            .carousel-nav-arrows {
                width: 40px;
                height: 40px;
            }
            
            .carousel-nav-prev {
                left: -10px;
            }
            
            .carousel-nav-next {
                right: -10px;
            }
        }
        
        @media (max-width: 480px) {
            .lancamentos-grid {
                gap: 15px;
                padding: 0 15px;
            }
            
            .produto-card {
                flex: 0 0 220px;
            }
            
            .produto-image {
                height: 160px;
            }
            
            .produto-placeholder {
                font-size: 2.5rem;
            }
            
            .produto-content {
                padding: 12px;
            }
            
            .produto-title {
                font-size: 1rem;
                margin-bottom: 6px;
            }
            
            .produto-description {
                font-size: 0.8rem;
                margin-bottom: 12px;
            }
            
            .produto-price {
                font-size: 1.2rem;
                margin-bottom: 12px;
            }
            
            .produto-btn {
                padding: 10px 0;
                font-size: 0.85rem;
            }
            
            .ver-todos-btn button {
                padding: 12px 24px;
                font-size: 0.9rem;
            }
        }
        
        /* Responsivo Categorias */
        @media (max-width: 768px) {
            .categorias-grid-dz {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .categoria-card-dz {
                padding: 30px 20px;
            }
            
            .categoria-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 15px;
            }
            
            .categoria-icon svg {
                width: 24px;
                height: 24px;
            }
            
            .categoria-card-dz h3 {
                font-size: 1.1rem;
            }
            
            .categoria-card-dz p {
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 480px) {
            .categorias-grid-dz {
                grid-template-columns: 1fr;
            }
        }
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

        
        /* Footer Modern */
        .footer-modern {
            background: linear-gradient(135deg, #fefefe 0%, #f8f9fa 100%);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 60px 0 0;  
            position: relative;
        }
        
        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, var(--color-magenta) 50%, transparent 100%);
            opacity: 0.4;
        }
        
        .footer-content {
            position: relative;
        }
        
        .footer-top {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 60px;
            margin-bottom: 50px;
        }
        
        .footer-brand {
            max-width: 400px;
        }
        
        .brand-logo h3 {
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }
        
        .brand-tagline {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 500;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        
        .brand-description {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        
        .footer-social-main {
            padding: 20px;
        }
        
        .social-links-grid {
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            background: rgba(230, 0, 126, 0.05);
            border-radius: 12px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(230, 0, 126, 0.1);
        }
        
        .social-btn:hover {
            background: var(--color-magenta);
            color: white;
            transform: translateY(-2px);
            border-color: var(--color-magenta);
        }
        
        .social-btn .social-icon {
            font-size: 1.3rem;
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }
        
        .social-btn:hover .social-icon {
            transform: scale(1.1);
        }
        
        .footer-links {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 50px;
        }
        
        .footer-column h5 {
            color: #1f2937;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
        }
        
        .footer-column h5::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 25px;
            height: 2px;
            background: var(--color-magenta);
            border-radius: 1px;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 12px;
        }
        
        .footer-column a {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .footer-column a:hover {
            color: var(--color-magenta);
            transform: translateX(3px);
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .contact-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }
        
        /* Footer Security Section */
        .footer-security {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-bottom: 40px;
            padding: 24px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }
        
        .payment-methods-section,
        .shipping-methods-section,
        .security-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
        
        .footer-security h6 {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin: 0;
            text-align: center;
        }
        
        .payment-icons,
        .shipping-icons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .payment-icon,
        .shipping-icon {
            transition: all 0.3s ease;
            opacity: 0.7;
            filter: grayscale(30%);
        }
        
        .payment-icon:hover,
        .shipping-icon:hover {
            transform: scale(1.05);
            opacity: 1;
            filter: grayscale(0%);
        }
        
        .security-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.8;
            transition: all 0.3s ease;
        }
        
        .security-badge:hover {
            opacity: 1;
            transform: scale(1.02);
        }
        
        .security-icon {
            transition: all 0.3s ease;
        }
        
        .security-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: #28A745;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        /* SSL Protection Styles */
        .ssl-protection {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .ssl-icon,
        .trust-icon {
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }
        
        .ssl-text {
            font-size: 0.75rem;
            font-weight: 600;
            color: #2ECC71;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        
        /* Trust Badges Styles */
        .trust-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            min-width: 90px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .trust-badge:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .trust-badge:hover .trust-icon,
        .trust-badge:hover .ssl-icon {
            transform: scale(1.1);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-security {
                gap: 12px;
                padding: 20px 0;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .trust-badge {
                min-width: 70px;
                padding: 6px 8px;
                gap: 4px;
            }
            
            .payment-icons,
            .shipping-icons {
                gap: 14px;
            }
            
            .payment-icon,
            .shipping-icon {
                width: 20px;
                height: 13px;
            }
            
            .ssl-icon,
            .trust-icon {
                width: 20px;
                height: 20px;
            }
            
            .ssl-text {
                font-size: 0.65rem;
            }
            
            .security-icon {
                width: 14px;
                height: 14px;
            }
            
            .security-text {
                font-size: 0.7rem;
            }
        }
        
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            background: #fafafa;
            margin: 0 -30px;
            padding-left: 30px;
            padding-right: 30px;
        }
        
        .copyright {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .payment-methods {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .payment-icons {
            display: flex;
            gap: 8px;
        }
        
        .payment-icons span {
            font-size: 1.2rem;
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .footer-modern {
                padding: 40px 0 0;
            }
            
            .footer-top {
                grid-template-columns: 1fr;
                gap: 35px;
            }
            
            .footer-links {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .trust-section {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 20px 0;
            }
            
            .payment-icons-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .shipping-icons-grid {
                gap: 8px;
            }
            
            .shipping-icon {
                width: 40px;
                height: 40px;
                padding: 8px;
                font-size: 1.1rem;
            }
            
            .social-links-grid {
                gap: 10px;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                margin: 0 -15px;
                padding-left: 15px;
                padding-right: 15px;
            }
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
            margin-right: 40px;
            color: #2d3748;
        }
        
        .chat-message.bot:nth-child(odd) {
            background: linear-gradient(135deg, #e0f2fe, #e1f5fe);
        }
        
        .chat-message.bot:nth-child(even) {
            background: linear-gradient(135deg, #f3e5f5, #fce4ec);
        }
        
        .chat-message.bot:nth-child(3n) {
            background: linear-gradient(135deg, #e8f5e8, #f1f8e9);
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
                <h2>Lançamentos</h2>
                <p>Conheça as novidades exclusivas que acabaram de chegar na D&Z</p>
            </div>
            
            <!-- Carrossel de Produtos -->
            <div class="lancamentos-carousel-container">
                <div class="lancamentos-grid" id="lancamentosCarousel">
                    
                    <!-- Produto 1: Esmalte Gel D&Z Pro -->
                    <div class="produto-card">
                        <div class="produto-image novo">
                            <div class="produto-placeholder">💅</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Esmalte Gel D&Z Pro</h3>
                            <p class="produto-description">Nova fórmula ultra resistente com tecnologia de secagem rápida</p>
                            <div class="produto-price">R$ 24,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 2: Magnetic Lash Collection -->
                    <div class="produto-card">
                        <div class="produto-image lancamento">
                            <div class="produto-placeholder">👁️</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Magnetic Lash Collection</h3>
                            <p class="produto-description">Cílios magnéticos inovadores, aplicação sem cola</p>
                            <div class="produto-price">R$ 52,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 3: Primer Nail Boost -->
                    <div class="produto-card">
                        <div class="produto-image novo">
                            <div class="produto-placeholder">✨</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Primer Nail Boost</h3>
                            <p class="produto-description">Tecnologia de crescimento acelerado para unhas fortes</p>
                            <div class="produto-price">R$ 39,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 4: Kit D&Z Glamour -->
                    <div class="produto-card">
                        <div class="produto-image exclusivo">
                            <div class="produto-placeholder">🎁</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Kit D&Z Glamour</h3>
                            <p class="produto-description">Edição limitada com produtos exclusivos para profissionais</p>
                            <div class="produto-price">R$ 127,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 5: Cola Premium Pro -->
                    <div class="produto-card">
                        <div class="produto-image novo">
                            <div class="produto-placeholder">🔗</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Cola Premium Pro</h3>
                            <p class="produto-description">Fixação ultra forte para cílios, duração de 15+ horas</p>
                            <div class="produto-price">R$ 31,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 6: Base Fortificante -->
                    <div class="produto-card">
                        <div class="produto-image lancamento">
                            <div class="produto-placeholder">💪</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Base Fortificante</h3>
                            <p class="produto-description">Fortalece e protege unhas fracas, com vitaminas</p>
                            <div class="produto-price">R$ 28,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                </div>
                
                <!-- Setas de navegação -->
                <button class="carousel-nav-arrows carousel-nav-prev" onclick="scrollLancamentos(-1)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <button class="carousel-nav-arrows carousel-nav-next" onclick="scrollLancamentos(1)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
            
            <!-- Botão Ver Todos -->
            <div class="ver-todos-btn">
                <button onclick="window.location.href='#catalogo'">Ver Todos os Lançamentos</button>
            </div>
        </div>
    </section>

    <!-- ===== TODOS OS PRODUTOS ===== -->
    <section class="produtos-dz" id="catalogo">
        <div class="container-dz">
            
            <!-- Título seção -->
            <div class="section-title fade-in-up">
                <h2>Todos os Produtos</h2>
                <p>Descubra nossa coleção completa de produtos profissionais D&Z</p>
            </div>
            
            <!-- Carrossel de Produtos -->
            <div class="lancamentos-carousel-container">
                <div class="lancamentos-grid" id="todosCarousel">
                    
                    <!-- Produto 1: Kit Unhas Profissional -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">💅</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Kit Unhas Profissional</h3>
                            <p class="produto-description">Kit completo com esmaltes gel, lixa e acessórios premium</p>
                            <div class="produto-price">R$ 89,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 2: Cílios Premium Volume -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">✨</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Cílios Premium Volume</h3>
                            <p class="produto-description">Cílios postiços ultra naturais para volume perfeito</p>
                            <div class="produto-price">R$ 45,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 3: Base Fortalecedora -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">💪</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Base Fortalecedora</h3>
                            <p class="produto-description">Fortalece e protege unhas fracas com vitaminas</p>
                            <div class="produto-price">R$ 32,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 4: Kit Alongamento Cílios -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">👁️</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Kit Alongamento Cílios</h3>
                            <p class="produto-description">Kit profissional completo para alongamento de cílios</p>
                            <div class="produto-price">R$ 78,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 5: Removedor Profissional -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">🧽</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Removedor Profissional</h3>
                            <p class="produto-description">Remove esmalte gel sem danificar as unhas naturais</p>
                            <div class="produto-price">R$ 25,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 6: Primer Adesivo -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">🔬</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Primer Adesivo</h3>
                            <p class="produto-description">Prepara a unha para máxima aderência do esmalte gel</p>
                            <div class="produto-price">R$ 29,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 7: Óleo Hidratante -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">💧</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Óleo Hidratante</h3>
                            <p class="produto-description">Hidrata cutículas e pele ao redor das unhas</p>
                            <div class="produto-price">R$ 22,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 8: Kit Manutenção -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">🛠️</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Kit Manutenção</h3>
                            <p class="produto-description">Ferramentas essenciais para manutenção profissional</p>
                            <div class="produto-price">R$ 67,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 9: Top Coat Brilho -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">✨</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Top Coat Brilho</h3>
                            <p class="produto-description">Finalização com brilho intenso e duração prolongada</p>
                            <div class="produto-price">R$ 27,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                    
                    <!-- Produto 10: Cabine UV/LED -->
                    <div class="produto-card">
                        <div class="produto-image">
                            <div class="produto-placeholder">💡</div>
                        </div>
                        <div class="produto-content">
                            <h3 class="produto-title">Cabine UV/LED</h3>
                            <p class="produto-description">Secagem profissional rápida e eficiente</p>
                            <div class="produto-price">R$ 159,90</div>
                            <button class="produto-btn">Adicionar ao Carrinho</button>
                        </div>
                    </div>
                </div>
                
                <!-- Setas de navegação -->
                <button class="carousel-nav-arrows carousel-nav-prev" onclick="scrollTodos(-1)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <button class="carousel-nav-arrows carousel-nav-next" onclick="scrollTodos(1)">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>
            
            <!-- Botão Ver Mais -->
            <div class="ver-todos-btn">
                <button onclick="window.location.href='#depoimentos'">Ver Depoimentos</button>
            </div>
        </div>
    </section>

    <!-- ===== DEPOIMENTOS DE CLIENTES ===== -->
    <section id="depoimentos" style="padding: 80px 0; background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);">
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
    <section class="promo-banner-modern">
        <div class="container-dz">
            <div class="promo-card fade-in-up">
                
                <!-- Badge de desconto -->
                <div class="discount-badge">
                    <span>15% OFF</span>
                </div>
                
                <!-- Conteúdo principal -->
                <div class="promo-content">
                    <div class="promo-title">
                        <span class="welcome-text">Seja bem-vinda!</span>
                        <h2>Primeira compra com <span class="discount-highlight">15% OFF</span></h2>
                    </div>
                    
                    <!-- Cupom destacado -->
                    <div class="coupon-container">
                        <div class="coupon-label">Use o cupom:</div>
                        <div class="coupon-code" id="couponCode" onclick="copyCoupon()">
                            <span>BEM-VINDA15</span>
                            <div class="copy-icon">📋</div>
                        </div>
                        <div class="copy-feedback" id="copyFeedback">Código copiado!</div>
                    </div>
                    

                    
                    <!-- Benefícios -->
                    <div class="promo-benefits">
                        <div class="benefit-item">
                            <span>Produtos premium</span>
                        </div>
                        <div class="benefit-item">
                            <span>Entrega rápida</span>
                        </div>
                        <div class="benefit-item">
                            <span>Embalagem especial</span>
                        </div>
                    </div>
                    
                    <!-- Call to Action -->
                    <button class="promo-cta-button" onclick="window.location.href='#lancamentos'">
                        <span class="button-text">Quero meu 15% OFF</span>
                        <div class="button-icon">→</div>
                    </button>
                </div>
                

            </div>
        </div>
    </section>
    
    <style>
        .promo-banner-modern {
            padding: 80px 0;
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 30%, #f3e8ff 70%, #ede9fe 100%);
            position: relative;
            overflow: hidden;
        }
        
        .promo-card {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 50px 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.8);
            text-align: center;
        }
        
        .discount-badge {
            display: inline-flex;
            align-items: center;
            background: var(--color-magenta);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(230, 0, 126, 0.3);
        }
        
        .promo-content {
            position: relative;
            z-index: 2;
        }
        
        .welcome-text {
            display: block;
            font-size: 1rem;
            color: var(--color-magenta);
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .promo-title h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.2;
            margin-bottom: 30px;
        }
        
        .discount-highlight {
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
        }
        
        .coupon-container {
            margin-bottom: 40px;
        }
        
        .coupon-label {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .coupon-code {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            padding: 16px 28px;
            border-radius: 16px;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(251, 191, 36, 0.4);
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }
        
        .coupon-code:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(251, 191, 36, 0.5);
        }
        
        .copy-icon {
            font-size: 1.2rem;
            opacity: 0.8;
        }
        
        .copy-feedback {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--color-magenta);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .copy-feedback.show {
            opacity: 1;
            top: -50px;
        }
        

        
        .promo-benefits {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .benefit-item {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4b5563;
        }
        
        .promo-cta-button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            color: white;
            border: none;
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 15px 35px rgba(230, 0, 126, 0.4);
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .promo-cta-button:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px rgba(230, 0, 126, 0.5);
        }
        
        .promo-cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .promo-cta-button:hover::before {
            left: 100%;
        }
        
        .button-text {
            position: relative;
            z-index: 2;
        }
        
        .button-icon {
            font-size: 1.3rem;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        
        .promo-cta-button:hover .button-icon {
            transform: translateX(4px);
        }
        

        
        /* Responsividade */
        @media (max-width: 768px) {
            .promo-card {
                padding: 30px 20px;
                margin: 0 15px;
                border-radius: 24px;
            }
            
            .promo-title h2 {
                font-size: 2.2rem;
            }
            
            .coupon-code {
                font-size: 1.2rem;
                padding: 14px 24px;
            }
            
            .countdown-timer {
                padding: 15px 25px;
                gap: 10px;
            }
            
            .time-value {
                font-size: 1.6rem;
            }
            
            .promo-benefits {
                flex-direction: column;
                gap: 12px;
            }
            
            .promo-cta-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    
    <script>
        // Função para copiar cupom
        function copyCoupon() {
            const couponText = 'BEM-VINDA15';
            
            // Tentar usar a API moderna de clipboard
            if (navigator.clipboard) {
                navigator.clipboard.writeText(couponText).then(() => {
                    showCopyFeedback();
                }).catch(() => {
                    fallbackCopy(couponText);
                });
            } else {
                fallbackCopy(couponText);
            }
        }
        
        // Método fallback para navegadores antigos
        function fallbackCopy(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showCopyFeedback();
        }
        
        // Mostrar feedback visual
        function showCopyFeedback() {
            const feedback = document.getElementById('copyFeedback');
            feedback.classList.add('show');
            setTimeout(() => {
                feedback.classList.remove('show');
            }, 2000);
        }
        

    </script>

    <!-- ===== NEWSLETTER ===== -->
    <section class="newsletter-modern">
        <div class="container-dz">
            <div class="newsletter-content fade-in-up">
                
                <!-- Conteúdo principal -->
                <div class="newsletter-header">
                    <div class="newsletter-badge">
                        <span class="badge-icon">📧</span>
                        <span>Newsletter Exclusiva</span>
                    </div>
                    <h3>Fique por dentro das novidades</h3>
                    <p>Receba em primeira mão nossos lançamentos e ofertas exclusivas</p>
                </div>
                
                <!-- Benefícios da newsletter -->
                <div class="newsletter-benefits">
                    <span>🎀 Ofertas exclusivas</span>
                    <span>•</span>
                    <span>✨ Lançamentos em primeira mão</span>
                    <span>•</span>
                    <span>🔒 Sem spam</span>
                </div>
                
                <!-- Formulário modernizado -->
                <form class="newsletter-form-modern" id="newsletterForm">
                    <div class="form-wrapper">
                        <input 
                            type="email" 
                            id="emailInput"
                            placeholder="Digite seu melhor e-mail" 
                            required
                        >
                        <button type="submit" class="submit-btn">
                            <span class="btn-text">Inscrever-se</span>
                        </button>
                    </div>
                    
                    <!-- Feedback messages -->
                    <div class="form-feedback">
                        <div class="success-message" id="successMessage">
                            <span class="success-icon">✓</span>
                            <span>Perfeito! Você receberá nossas novidades em breve!</span>
                        </div>
                        <div class="error-message" id="errorMessage">
                            <span class="error-icon">⚠</span>
                            <span>Por favor, insira um e-mail válido</span>
                        </div>
                    </div>
                </form>
                

            </div>
        </div>
    </section>
    
    <style>
        .newsletter-modern {
            padding: 60px 0;
            background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 50%, #f3e8ff 100%);
            position: relative;
        }
        
        .newsletter-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        

        
        .newsletter-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(230, 0, 126, 0.3);
        }
        
        .badge-icon {
            font-size: 1rem;
        }
        
        .newsletter-header h3 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.2;
        }
        
        .newsletter-header p {
            font-size: 1rem;
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 30px;
            font-weight: 500;
        }
        
        .newsletter-benefits {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 500;
            flex-wrap: wrap;
        }
        
        .newsletter-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(230, 0, 126, 0.3);
        }
        
        .badge-icon {
            font-size: 1rem;
        }
        
        .newsletter-form-modern {
            margin-bottom: 30px;
        }
        
        .form-wrapper {
            display: flex;
            gap: 15px;
            max-width: 450px;
            margin: 0 auto;
            align-items: stretch;
        }
        
        .form-wrapper input {
            flex: 1;
            padding: 18px 24px;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 2px solid transparent;
            transition: all 0.3s ease;
            color: #1a1a1a;
        }
        
        .form-wrapper input:focus {
            outline: none;
            border-color: var(--color-magenta);
            box-shadow: 0 12px 30px rgba(230, 0, 126, 0.2);
            transform: translateY(-2px);
        }
        
        .form-wrapper input::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--color-magenta), #d946ef);
            color: white;
            border: none;
            padding: 18px 32px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(230, 0, 126, 0.3);
            white-space: nowrap;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(230, 0, 126, 0.4);
            background: linear-gradient(135deg, #d946ef, var(--color-magenta));
        }
        
        .form-feedback {
            margin-top: 20px;
            min-height: 30px;
        }
        
        .success-message,
        .error-message {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            animation: slideIn 0.3s ease;
        }
        
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .success-message.show,
        .error-message.show {
            display: flex;
        }
        

        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsividade */
        @media (max-width: 768px) {
            .newsletter-modern {
                padding: 40px 0;
            }
            
            .newsletter-content {
                padding: 0 20px;
            }
            
            .newsletter-header h3 {
                font-size: 1.8rem;
            }
            
            .newsletter-benefits {
                flex-direction: column;
                gap: 8px;
            }
            
            .form-wrapper {
                flex-direction: column;
                gap: 15px;
                max-width: 350px;
            }
            
            .submit-btn {
                width: 100%;
                justify-content: center;
                padding: 18px 24px;
            }
        }
    </style>
    
    <script>
        // Validação e envio do formulário
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = document.getElementById('emailInput');
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            const email = emailInput.value.trim();
            
            // Reset messages
            successMessage.classList.remove('show');
            errorMessage.classList.remove('show');
            
            // Validação de email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!email || !emailRegex.test(email)) {
                errorMessage.classList.add('show');
                emailInput.focus();
                return;
            }
            
            // Simulação de envio (aqui você integraria com seu backend)
            const button = this.querySelector('.submit-btn');
            const originalText = button.querySelector('.btn-text').textContent;
            
            // Estado de loading
            button.querySelector('.btn-text').textContent = 'Enviando...';
            button.disabled = true;
            button.style.opacity = '0.7';
            
            // Simular delay de envio
            setTimeout(() => {
                // Reset button
                button.querySelector('.btn-text').textContent = originalText;
                button.disabled = false;
                button.style.opacity = '1';
                
                // Show success
                successMessage.classList.add('show');
                
                // Clear input
                emailInput.value = '';
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMessage.classList.remove('show');
                }, 5000);
            }, 1000);
        });
        
        // Limpar mensagens de erro quando o usuário digita
        document.getElementById('emailInput').addEventListener('input', function() {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage.classList.contains('show')) {
                errorMessage.classList.remove('show');
            }
        });
    </script>

    <!-- ===== FOOTER ===== -->
    <footer class="footer-modern">
        <div class="container-dz">
            <div class="footer-content">
                <div class="footer-top">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <h3>D&Z</h3>
                            <div class="brand-tagline">Beauty & Style</div>
                        </div>
                        
                        <p class="brand-description">
                            Transformando a beleza das mulheres brasileiras com produtos premium e atendimento excepcional.
                        </p>
                        
                        <div class="footer-social-main">
                            <div class="social-links-grid">
                                <a href="#" class="social-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" class="social-icon">
                                        <path fill="#E4405F" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                <a href="#" class="social-btn">
                                    <svg width="20" height="20" viewBox="0 0 24 24" class="social-icon">
                                        <path fill="#000" d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                    </svg>
                                </a>
                                <a href="#" class="social-btn">
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
                                <li><a href="#">Unhas Profissionais</a></li>
                                <li><a href="#">Cílios Premium</a></li>
                                <li><a href="#">Kits Completos</a></li>
                                <li><a href="#">Novidades</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h5>Atendimento</h5>
                            <ul>
                                <li><a href="#">Central de Ajuda</a></li>
                                <li><a href="#">Política de Troca</a></li>
                                <li><a href="#">Garantia</a></li>
                                <li><a href="#">Rastreamento</a></li>
                                <li><a href="#">Suporte Premium</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h5>Contato</h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <span class="contact-icon">📞</span>
                                    <span>(11) 9999-9999</span>
                                </div>
                                <div class="contact-item">
                                    <span class="contact-icon">💬</span>
                                    <span>WhatsApp 24h</span>
                                </div>
                                <div class="contact-item">
                                    <span class="contact-icon">✉️</span>
                                    <span>contato@dzecommerce.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer-security">
                    <div class="trust-badge">
                        <h6>Formas de pagamento</h6>
                        <div class="payment-icons">
                            <!-- Visa -->
                            <svg width="28" height="18" viewBox="0 0 780 500" class="payment-icon">
                                <path fill="#1434CB" d="M40 0h700c22 0 40 18 40 40v420c0 22-18 40-40 40H40c-22 0-40-18-40-40V40C0 18 18 0 40 0z"/>
                                <text x="390" y="350" text-anchor="middle" font-size="180" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">VISA</text>
                            </svg>
                            <!-- Mastercard -->
                            <svg width="28" height="18" viewBox="0 0 780 500" class="payment-icon">
                                <rect width="780" height="500" rx="40" fill="#000"/>
                                <circle cx="270" cy="250" r="125" fill="#EB001B"/>
                                <circle cx="510" cy="250" r="125" fill="#F79E1B"/>
                                <path d="M380 135.6v44.9c-11-17-30-28.4-51.6-28.4-35.3 0-64 28.7-64 64s28.7 64 64 64c21.6 0 40.6-11.4 51.6-28.4v44.9h32v-158H380v-.8z" fill="#FF5F00"/>
                            </svg>
                            <!-- PIX -->
                            <svg width="28" height="18" viewBox="0 0 512 512" class="payment-icon">
                                <rect width="512" height="512" rx="45" fill="#32BCAD"/>
                                <text x="256" y="280" text-anchor="middle" font-size="120" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">PIX</text>
                            </svg>
                            <!-- Boleto -->
                            <svg width="28" height="18" viewBox="0 0 100 64" class="payment-icon">
                                <rect width="100" height="64" rx="4" fill="#333" stroke="#666"/>
                                <rect x="4" y="8" width="92" height="2" fill="#FFF"/>
                                <rect x="4" y="12" width="92" height="2" fill="#FFF"/>
                                <rect x="4" y="16" width="70" height="2" fill="#FFF"/>
                                <rect x="4" y="20" width="85" height="2" fill="#FFF"/>
                                <text x="50" y="45" text-anchor="middle" font-size="10" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">BOLETO</text>
                            </svg>
                            <!-- Cartão de Crédito -->
                            <svg width="28" height="18" viewBox="0 0 100 64" class="payment-icon">
                                <rect width="100" height="64" rx="6" fill="#4A90E2" stroke="#357ABD"/>
                                <rect y="20" width="100" height="12" fill="#357ABD"/>
                                <rect x="8" y="42" width="20" height="4" fill="#FFF"/>
                                <circle cx="85" cy="50" r="4" fill="#FFF"/>
                            </svg>
                            <!-- Cartão de Débito -->
                            <svg width="28" height="18" viewBox="0 0 100 64" class="payment-icon">
                                <rect width="100" height="64" rx="6" fill="#28A745" stroke="#1E7E34"/>
                                <rect y="20" width="100" height="12" fill="#1E7E34"/>
                                <text x="8" y="55" font-size="8" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">DÉBITO</text>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="trust-badge">
                        <div class="ssl-protection">
                            <svg width="20" height="20" viewBox="0 0 24 24" class="ssl-icon">
                                <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" fill="#2ECC71"/>
                            </svg>
                            <span class="ssl-text">SSL</span>
                        </div>
                    </div>
                    
                    <div class="trust-badge">
                        <!-- CE -->
                        <svg width="20" height="20" viewBox="0 0 100 100" class="trust-icon">
                            <rect width="100" height="100" rx="8" fill="#003399"/>
                            <text x="50" y="60" text-anchor="middle" font-size="28" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">CE</text>
                        </svg>
                    </div>
                    
                    <div class="trust-badge">
                        <!-- ISO 9001 -->
                        <svg width="20" height="20" viewBox="0 0 100 100" class="trust-icon">
                            <circle cx="50" cy="50" r="45" fill="#FFF" stroke="#000" stroke-width="2"/>
                            <text x="50" y="35" text-anchor="middle" font-size="12" fill="#000" font-family="Arial, sans-serif" font-weight="bold">ISO</text>
                            <text x="50" y="50" text-anchor="middle" font-size="16" fill="#000" font-family="Arial, sans-serif" font-weight="bold">9001</text>
                            <text x="50" y="65" text-anchor="middle" font-size="8" fill="#000" font-family="Arial, sans-serif">Quality</text>
                        </svg>
                    </div>
                    
                    <div class="trust-badge">
                        <!-- Google Safe Browsing -->
                        <svg width="20" height="20" viewBox="0 0 100 100" class="trust-icon">
                            <rect width="100" height="100" rx="8" fill="#1a73e8"/>
                            <path d="M50 20L30 40v30l20 10 20-10V40L50 20z" fill="#34a853"/>
                            <path d="M45 45h10v20h-10V45z" fill="#FFF"/>
                            <circle cx="50" cy="38" r="3" fill="#FFF"/>
                        </svg>
                    </div>
                    
                    <div class="trust-badge">
                        <!-- CO2 Neutral -->
                        <svg width="20" height="20" viewBox="0 0 100 100" class="trust-icon">
                            <circle cx="50" cy="50" r="45" fill="#228B22"/>
                            <text x="50" y="40" text-anchor="middle" font-size="14" fill="#FFF" font-family="Arial, sans-serif" font-weight="bold">CO₂</text>
                            <text x="50" y="60" text-anchor="middle" font-size="10" fill="#FFF" font-family="Arial, sans-serif">NEUTRAL</text>
                        </svg>
                    </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                © 2026 D&Z Beauty • Todos os direitos reservados
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
        
        // ===== CARROSSEL LANÇAMENTOS =====
        function scrollLancamentos(direction) {
            const carousel = document.getElementById('lancamentosCarousel');
            const cardWidth = 310; // 280px + 30px gap
            const scrollAmount = cardWidth * direction;
            
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Auto scroll suave para lançamentos
        function autoScrollLancamentos() {
            const carousel = document.getElementById('lancamentosCarousel');
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            
            if (carousel.scrollLeft >= maxScroll) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                scrollLancamentos(1);
            }
        }
        
        // Auto scroll a cada 8 segundos (opcional)
        // setInterval(autoScrollLancamentos, 8000);
        
        // ===== CARROSSEL TODOS OS PRODUTOS =====
        function scrollTodos(direction) {
            const carousel = document.getElementById('todosCarousel');
            const cardWidth = 310; // 280px + 30px gap
            const scrollAmount = cardWidth * direction;
            
            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        }
        
        // Auto scroll suave para todos os produtos
        function autoScrollTodos() {
            const carousel = document.getElementById('todosCarousel');
            const maxScroll = carousel.scrollWidth - carousel.clientWidth;
            
            if (carousel.scrollLeft >= maxScroll) {
                carousel.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                scrollTodos(1);
            }
        }
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
