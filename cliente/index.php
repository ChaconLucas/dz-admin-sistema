<?php
/**
 * Página Principal da Loja - Área do Cliente
 * E-commerce - Vitrine de Produtos
 */

// Carrega as configurações e conexões
require_once 'config-cliente.php';

// Conecta ao banco de dados usando a conexão do admin
$conexao = getConexaoBanco();
$produtos = [];

// Verifica se a conexão está funcionando antes de fazer queries
if ($conexao && verificarConexaoBanco()) {
    // Busca produtos no banco (exemplo)
    // Você pode adaptar conforme sua estrutura de tabelas
    $sqlProdutos = "SELECT * FROM produtos LIMIT 8"; // Adapte conforme sua tabela
    $resultadoProdutos = mysqli_query($conexao, $sqlProdutos);
    
    if ($resultadoProdutos) {
        while ($produto = mysqli_fetch_assoc($resultadoProdutos)) {
            $produtos[] = $produto;
        }
    }
} else {
    // Log do erro para debug
    error_log("Erro: Não foi possível conectar ao banco de dados na área do cliente");
}

// Título da página
$tituloPagina = "Loja Virtual - Bem-vindo";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloPagina; ?></title>
    
    <!-- CSS da Loja -->
    <link rel="stylesheet" href="loja.css">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header-loja">
        <div class="container-header">
            <div class="logo-loja">
                <i class="fas fa-store"></i> Sua Loja
            </div>
            
            <nav class="nav-loja">
                <ul>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#produtos">Produtos</a></li>
                    <li><a href="#categorias">Categorias</a></li>
                    <li><a href="#contato">Contato</a></li>
                </ul>
            </nav>
            
            <div class="user-area">
                <a href="#" class="btn btn-outline" onclick="abrirModalLogin()">
                    <i class="fas fa-user"></i> Entrar
                </a>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Carrinho (0)
                </a>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <!-- Hero Section -->
        <section id="inicio" class="hero-section">
            <div class="hero-content">
                <h1>Bem-vindo à Nossa Loja</h1>
                <p>Encontre os melhores produtos com qualidade garantida</p>
                <a href="#produtos" class="btn btn-primary btn-lg">
                    Ver Produtos <i class="fas fa-arrow-down"></i>
                </a>
            </div>
        </section>

        <!-- Seção de Categorias -->
        <section id="categorias" class="categorias-section">
            <div class="container">
                <h2 class="categorias-titulo">Nossas Categorias</h2>
                <div class="categorias-grid">
                    <div class="categoria-item" onclick="filtrarPorCategoria('eletronicos')">
                        <div class="categoria-icone">📱</div>
                        <div class="categoria-nome">Eletrônicos</div>
                    </div>
                    <div class="categoria-item" onclick="filtrarPorCategoria('moda')">
                        <div class="categoria-icone">👗</div>
                        <div class="categoria-nome">Moda</div>
                    </div>
                    <div class="categoria-item" onclick="filtrarPorCategoria('casa')">
                        <div class="categoria-icone">🏠</div>
                        <div class="categoria-nome">Casa & Jardim</div>
                    </div>
                    <div class="categoria-item" onclick="filtrarPorCategoria('esportes')">
                        <div class="categoria-icone">⚽</div>
                        <div class="categoria-nome">Esportes</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Produtos -->
        <section id="produtos" class="container">
            <h2 style="text-align: center; margin-bottom: 2rem; color: #2c3e50; font-size: 2.5rem; font-weight: 300;">
                Produtos em Destaque
            </h2>
            
            <!-- Barra de Busca -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <input type="text" id="busca" placeholder="Buscar produtos..." 
                       style="padding: 1rem; border: 2px solid #ddd; border-radius: 25px; width: 300px; font-size: 1rem;"
                       onkeyup="buscarProdutos()">
            </div>

            <div class="produtos-grid">
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                        <div class="produto-card">
                            <div class="produto-imagem">
                                <?php if (!empty($produto['imagem'])): ?>
                                    <img src="<?php echo getAssetUrl('images/produtos/' . $produto['imagem']); ?>" 
                                         alt="<?php echo htmlspecialchars($produto['nome']); ?>"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-image" style="font-size: 3rem; color: #ccc;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="produto-info">
                                <h3 class="produto-nome"><?php echo htmlspecialchars($produto['nome'] ?? 'Produto'); ?></h3>
                                <div class="produto-preco">
                                    R$ <?php echo number_format($produto['preco'] ?? 0, 2, ',', '.'); ?>
                                </div>
                                <button class="btn btn-primary" style="width: 100%;" 
                                        onclick="adicionarAoCarrinho(<?php echo $produto['id'] ?? 0; ?>, '<?php echo htmlspecialchars($produto['nome'] ?? ''); ?>', <?php echo $produto['preco'] ?? 0; ?>)">
                                    <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Produtos de exemplo caso não haja produtos no banco -->
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <i class="fas fa-mobile-alt" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                        <div class="produto-info">
                            <h3 class="produto-nome">Smartphone Premium</h3>
                            <div class="produto-preco">R$ 1.299,00</div>
                            <button class="btn btn-primary" style="width: 100%;" onclick="adicionarAoCarrinho(1, 'Smartphone Premium', 1299)">
                                <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                    
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <i class="fas fa-laptop" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                        <div class="produto-info">
                            <h3 class="produto-nome">Notebook Gamer</h3>
                            <div class="produto-preco">R$ 2.899,00</div>
                            <button class="btn btn-primary" style="width: 100%;" onclick="adicionarAoCarrinho(2, 'Notebook Gamer', 2899)">
                                <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                    
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <i class="fas fa-headphones" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                        <div class="produto-info">
                            <h3 class="produto-nome">Fone Bluetooth</h3>
                            <div class="produto-preco">R$ 199,00</div>
                            <button class="btn btn-primary" style="width: 100%;" onclick="adicionarAoCarrinho(3, 'Fone Bluetooth', 199)">
                                <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                    
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <i class="fas fa-tv" style="font-size: 3rem; color: #ccc;"></i>
                        </div>
                        <div class="produto-info">
                            <h3 class="produto-nome">Smart TV 55"</h3>
                            <div class="produto-preco">R$ 1.699,00</div>
                            <button class="btn btn-primary" style="width: 100%;" onclick="adicionarAoCarrinho(4, 'Smart TV 55', 1699)">
                                <i class="fas fa-cart-plus"></i> Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Modal de Login -->
    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <h2><i class="fas fa-user-circle"></i> Fazer Login</h2>
            </div>
            <form id="formLogin">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
                <div style="text-align: center; margin-top: 1rem;">
                    <a href="#" style="color: #e74c3c;">Esqueci minha senha</a> | 
                    <a href="#" style="color: #e74c3c;">Criar conta</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 Sua Loja Virtual. Todos os direitos reservados.</p>
            <p>Desenvolvido com ❤️ para oferecer a melhor experiência</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="loja.js"></script>
    
    <!-- Conexão com banco estabelecida -->
    <script>
        console.log('Área do Cliente carregada com sucesso!');
        console.log('Conexão com banco de dados:', <?php 
            echo json_encode([
                'status' => $conexao ? 'Ativa' : 'Inativa',
                'verificacao' => verificarConexaoBanco() ? 'OK' : 'Falhou',
                'produtos_encontrados' => count($produtos),
                'timestamp' => date('Y-m-d H:i:s')
            ]); 
        ?>);
        
        <?php if (count($produtos) > 0): ?>
        console.log('Produtos carregados do banco:', <?php echo count($produtos); ?>);
        <?php else: ?>
        console.log('Nenhum produto encontrado no banco. Usando produtos de exemplo.');
        <?php endif; ?>
    </script>
</body>
</html>