<?php
session_start();
require_once '../config.php';

// Verificar se o usuário está logado
$usuarioLogado = isset($_SESSION['cliente']);
$nomeUsuario = $usuarioLogado ? htmlspecialchars($_SESSION['cliente']['nome']) : '';

$pageTitle = 'Carrinho - D&Z';
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
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f8f9fa;
            padding-top: 100px;
            padding-bottom: 60px;
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
        
        .cart-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 24px;
        }
        
        .cart-items {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .cart-summary {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            height: fit-content;
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-icon {
            font-size: 5rem;
            margin-bottom: 24px;
            opacity: 0.5;
        }
        
        .btn-continue {
            display: inline-block;
            margin-top: 24px;
            padding: 16px 32px;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-continue:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        .cart-item {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 100px;
            height: 100px;
            background: #f8f9fa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 8px;
        }
        
        .item-price {
            color: var(--color-magenta);
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .qty-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 12px;
        }
        
        .qty-btn {
            width: 32px;
            height: 32px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.2s;
        }
        
        .qty-btn:hover {
            border-color: var(--color-magenta);
            color: var(--color-magenta);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
        }
        
        .summary-total {
            border-top: 2px solid #f1f5f9;
            margin-top: 16px;
            padding-top: 16px;
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .btn-checkout {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 24px;
            transition: all 0.3s;
        }
        
        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 0, 126, 0.3);
        }
        
        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
        }
        
        /* Navbar */
        .header-loja {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(230, 0, 126, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            padding: 16px 0;
        }
        
        .container-header {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        
        .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--color-magenta) 0%, var(--color-magenta-dark) 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-back {
            padding: 10px 20px;
            border-radius: 8px;
            background: transparent;
            color: var(--color-magenta);
            border: 2px solid var(--color-magenta);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background: var(--color-magenta);
            color: white;
        }
    </style>
</head>
<body>
    <header class="header-loja">
        <div class="container-header">
            <a href="../index.php" class="logo-container">
                <img src="../assets/images/Logodz.png" alt="D&Z" class="logo-dz-oficial" style="height: 40px;" onerror="this.style.display='none'">
                <span class="logo-text">D&Z</span>
            </a>
            <a href="../index.php" class="btn-back">← Continuar comprando</a>
        </div>
    </header>

    <div class="page-container">
        <div class="page-header">
            <h1>Seu Carrinho</h1>
            <p>Revise seus produtos antes de finalizar a compra</p>
        </div>
        
        <div class="cart-container">
            <div class="cart-items">
                <div id="cartItemsContainer">
                    <!-- Preenchido via JavaScript -->
                </div>
            </div>
            
            <div class="cart-summary">
                <h3 style="color: var(--color-magenta); margin-bottom: 20px;">Resumo do Pedido</h3>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong id="subtotal">R$ 0,00</strong>
                </div>
                
                <div class="summary-row">
                    <span>Frete</span>
                    <strong id="frete">Calcular</strong>
                </div>
                
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <strong id="total" style="color: var(--color-magenta);">R$ 0,00</strong>
                </div>
                
                <button class="btn-checkout" onclick="finalizarCompra()">Finalizar Compra</button>
            </div>
        </div>
    </div>

    <script>
        // Carregar carrinho do localStorage
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('dz_cart') || '[]');
            const container = document.getElementById('cartItemsContainer');
            
            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-icon">🛒</div>
                        <h2>Seu carrinho está vazio</h2>
                        <p>Adicione produtos para começar suas compras!</p>
                        <a href="../index.php" class="btn-continue">Começar a Comprar</a>
                    </div>
                `;
                return;
            }
            
            // Renderizar itens
            container.innerHTML = cart.map((item, index) => `
                <div class="cart-item">
                    <div class="item-image">${item.image || '💅'}</div>
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        ${item.variant ? `<div style="color: #666; font-size: 0.9rem;">${item.variant}</div>` : ''}
                        <div class="item-price">R$ ${item.price.toFixed(2).replace('.', ',')}</div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
                            <span style="font-weight: 600;">${item.qty}</span>
                            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                            <button onclick="removeItem(${index})" style="margin-left: auto; color: #ef4444; background: none; border: none; cursor: pointer;">🗑️ Remover</button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            updateSummary();
        }
        
        function updateQuantity(index, delta) {
            const cart = JSON.parse(localStorage.getItem('dz_cart') || '[]');
            cart[index].qty += delta;
            
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            
            localStorage.setItem('dz_cart', JSON.stringify(cart));
            loadCart();
        }
        
        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('dz_cart') || '[]');
            cart.splice(index, 1);
            localStorage.setItem('dz_cart', JSON.stringify(cart));
            loadCart();
        }
        
        function updateSummary() {
            const cart = JSON.parse(localStorage.getItem('dz_cart') || '[]');
            const subtotal = cart.reduce((total, item) => total + (item.price * item.qty), 0);
            
            document.getElementById('subtotal').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            document.getElementById('total').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
            
            // Frete grátis acima de R$ 99
            const frete = subtotal >= 99 ? 0 : 15;
            document.getElementById('frete').textContent = frete === 0 ? 'GRÁTIS' : `R$ ${frete.toFixed(2).replace('.', ',')}`;
            
            const total = subtotal + frete;
            document.getElementById('total').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }
        
        function finalizarCompra() {
            <?php if ($usuarioLogado): ?>
                alert('Funcionalidade de checkout em desenvolvimento! 🚧');
                // Redirecionar para checkout quando estiver pronto
                // window.location.href = 'checkout.php';
            <?php else: ?>
                if (confirm('Você precisa estar logado para finalizar a compra. Deseja fazer login agora?')) {
                    window.location.href = 'login.php';
                }
            <?php endif; ?>
        }
        
        // Carregar ao iniciar
        loadCart();
    </script>
</body>
</html>
