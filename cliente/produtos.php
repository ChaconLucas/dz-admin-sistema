<?php
/**
 * Página de Produtos Filtrados
 * Filtra produtos por categoria_id ou menu_group
 */

session_start();

require_once 'config.php';
require_once 'conexao.php';

/**
 * Busca subcategorias de uma categoria pai
 */
function buscarSubcategorias($conexao, $parent_id) {
    $sql = "SELECT id, nome FROM categorias WHERE ativo = 1 AND parent_id = ? ORDER BY nome ASC";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $parent_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $subcategorias = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subcategorias[] = $row;
    }
    return $subcategorias;
}

// Parâmetros de filtro
$categoria_id = isset($_GET['categoria_id']) ? intval($_GET['categoria_id']) : null;
$menu_group = isset($_GET['menu']) ? $_GET['menu'] : null;
$categoria_nome = isset($_GET['categoria']) ? trim($_GET['categoria']) : null;
$marca_nome = isset($_GET['marca']) ? trim($_GET['marca']) : null;

// Informações da página
$tituloPagina = 'Produtos';
$categoriaNome = '';
$produtosArray = [];

// Construir query baseado nos filtros
if ($categoria_nome) {
    // Filtrar por nome da categoria
    $tituloPagina = $categoria_nome;
    $categoriaNome = $categoria_nome;
    
    // Buscar categorias que correspondam ao nome
    $sql_cat = "SELECT id, nome FROM categorias WHERE nome LIKE ? AND ativo = 1";
    $stmt_cat = mysqli_prepare($conn, $sql_cat);
    $search_term = "%{$categoria_nome}%";
    mysqli_stmt_bind_param($stmt_cat, "s", $search_term);
    mysqli_stmt_execute($stmt_cat);
    $result_cat = mysqli_stmt_get_result($stmt_cat);
    
    $categoria_ids = [];
    while ($cat = mysqli_fetch_assoc($result_cat)) {
        $categoria_ids[] = $cat['id'];
        // Incluir subcategorias
        $subs = buscarSubcategorias($conn, $cat['id']);
        foreach ($subs as $sub) {
            $categoria_ids[] = $sub['id'];
        }
    }
    
    if (!empty($categoria_ids)) {
        $placeholders = str_repeat('?,', count($categoria_ids) - 1) . '?';
        $sql_produtos = "SELECT p.* FROM produtos p 
                         WHERE p.categoria_id IN ($placeholders) 
                         AND p.status = 'ativo' 
                         ORDER BY p.destaque DESC, p.id DESC";
        
        $stmt_prod = mysqli_prepare($conn, $sql_produtos);
        $types = str_repeat('i', count($categoria_ids));
        mysqli_stmt_bind_param($stmt_prod, $types, ...$categoria_ids);
        mysqli_stmt_execute($stmt_prod);
        $result_prod = mysqli_stmt_get_result($stmt_prod);
        
        while ($produto = mysqli_fetch_assoc($result_prod)) {
            $produtosArray[] = $produto;
        }
    }
    
} elseif ($marca_nome) {
    // Filtrar por nome da marca
    $tituloPagina = $marca_nome;
    $categoriaNome = $marca_nome;
    
    // Buscar produtos por marca
    $sql_produtos = "SELECT * FROM produtos WHERE marca LIKE ? AND status = 'ativo' ORDER BY destaque DESC, id DESC";
    $stmt_prod = mysqli_prepare($conn, $sql_produtos);
    $search_term = "%{$marca_nome}%";
    mysqli_stmt_bind_param($stmt_prod, "s", $search_term);
    mysqli_stmt_execute($stmt_prod);
    $result_prod = mysqli_stmt_get_result($stmt_prod);
    
    while ($produto = mysqli_fetch_assoc($result_prod)) {
        $produtosArray[] = $produto;
    }
    
} elseif ($categoria_id) {
    // Buscar info da categoria
    $sql_cat = "SELECT nome, menu_group, parent_id FROM categorias WHERE id = ? AND ativo = 1";
    $stmt_cat = mysqli_prepare($conn, $sql_cat);
    mysqli_stmt_bind_param($stmt_cat, "i", $categoria_id);
    mysqli_stmt_execute($stmt_cat);
    $result_cat = mysqli_stmt_get_result($stmt_cat);
    $categoria_info = mysqli_fetch_assoc($result_cat);
    
    if ($categoria_info) {
        $categoriaNome = $categoria_info['nome'];
        $tituloPagina = $categoriaNome;
        
        // Buscar subcategorias
        $subcategorias = buscarSubcategorias($conn, $categoria_id);
        $categoria_ids = [$categoria_id];
        foreach ($subcategorias as $sub) {
            $categoria_ids[] = $sub['id'];
        }
        
        // Buscar produtos desta categoria + subcategorias
        $placeholders = str_repeat('?,', count($categoria_ids) - 1) . '?';
        $sql_produtos = "SELECT p.* FROM produtos p 
                         WHERE p.categoria_id IN ($placeholders) 
                         AND p.status = 'ativo' 
                         ORDER BY p.destaque DESC, p.id DESC";
        
        $stmt_prod = mysqli_prepare($conn, $sql_produtos);
        $types = str_repeat('i', count($categoria_ids));
        mysqli_stmt_bind_param($stmt_prod, $types, ...$categoria_ids);
        mysqli_stmt_execute($stmt_prod);
        $result_prod = mysqli_stmt_get_result($stmt_prod);
        
        while ($produto = mysqli_fetch_assoc($result_prod)) {
            $produtosArray[] = $produto;
        }
    }
    
} elseif ($menu_group) {
    // Filtrar por menu_group
    $menu_labels = [
        'unhas' => 'UNHAS',
        'cilios' => 'CÍLIOS',
        'eletronicos' => 'ELETRÔNICOS',
        'ferramentas' => 'FERRAMENTAS',
        'marcas' => 'MARCAS',
        'outros' => 'OUTROS'
    ];
    
    $tituloPagina = $menu_labels[$menu_group] ?? 'Produtos';
    
    // Buscar todas as categorias desse menu
    $categorias = buscarCategoriasPorMenu($conn, $menu_group);
    $categoria_ids = [];
    
    foreach ($categorias as $cat) {
        $categoria_ids[] = $cat['id'];
        // Incluir subcategorias
        $subs = buscarSubcategorias($conn, $cat['id']);
        foreach ($subs as $sub) {
            $categoria_ids[] = $sub['id'];
        }
    }
    
    if (!empty($categoria_ids)) {
        $placeholders = str_repeat('?,', count($categoria_ids) - 1) . '?';
        $sql_produtos = "SELECT p.* FROM produtos p 
                         WHERE p.categoria_id IN ($placeholders) 
                         AND p.status = 'ativo' 
                         ORDER BY p.destaque DESC, p.id DESC";
        
        $stmt_prod = mysqli_prepare($conn, $sql_produtos);
        $types = str_repeat('i', count($categoria_ids));
        mysqli_stmt_bind_param($stmt_prod, $types, ...$categoria_ids);
        mysqli_stmt_execute($stmt_prod);
        $result_prod = mysqli_stmt_get_result($stmt_prod);
        
        while ($produto = mysqli_fetch_assoc($result_prod)) {
            $produtosArray[] = $produto;
        }
    }
} else {
    // Todos os produtos
    $sql_produtos = "SELECT * FROM produtos WHERE status = 'ativo' ORDER BY destaque DESC, id DESC";
    $result_prod = mysqli_query($conn, $sql_produtos);
    while ($produto = mysqli_fetch_assoc($result_prod)) {
        $produtosArray[] = $produto;
    }
}

$totalProdutos = count($produtosArray);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($tituloPagina); ?> - D&Z</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --color-magenta: #E6007E;
            --color-magenta-dark: #B8005F;
            --color-rose: #FFC0CB;
            --color-white: #FFFFFF;
            --color-bg: #F8F9FA;
            --color-text: #2D3748;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-magenta);
            margin-bottom: 10px;
        }
        
        .products-count {
            color: #718096;
            font-size: 1rem;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(230, 0, 126, 0.2);
        }
        
        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: #f0f0f0;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--color-text);
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-magenta);
        }
        
        .btn-back {
            display: inline-block;
            padding: 12px 24px;
            background: var(--color-magenta);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background: var(--color-magenta-dark);
            transform: translateY(-2px);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state h3 {
            font-size: 1.5rem;
            color: #718096;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn-back">← Voltar para Home</a>
        
        <div class="page-header">
            <h1 class="page-title"><?php echo htmlspecialchars($tituloPagina); ?></h1>
            <p class="products-count"><?php echo $totalProdutos; ?> produto<?php echo $totalProdutos != 1 ? 's' : ''; ?> encontrado<?php echo $totalProdutos != 1 ? 's' : ''; ?></p>
        </div>
        
        <?php if (empty($produtosArray)): ?>
            <div class="empty-state">
                <h3>Nenhum produto encontrado nesta categoria</h3>
                <p>Em breve teremos novidades!</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($produtosArray as $produto): 
                    $imagens = !empty($produto['imagens']) ? json_decode($produto['imagens'], true) : [];
                    $imagem_principal = $produto['imagem_principal'] ?? ($imagens[0] ?? '');
                    $preco = number_format($produto['preco'], 2, ',', '.');
                ?>
                    <div class="product-card" onclick="window.location.href='produto-detalhes.php?id=<?php echo $produto['id']; ?>'">
                        <?php if ($imagem_principal): ?>
                            <img src="../admin/assets/images/produtos/<?php echo htmlspecialchars($imagem_principal); ?>" 
                                 alt="<?php echo htmlspecialchars($produto['nome']); ?>" 
                                 class="product-image">
                        <?php else: ?>
                            <div class="product-image" style="background: linear-gradient(135deg, #E6007E, #FFC0CB);"></div>
                        <?php endif; ?>
                        
                        <div class="product-info">
                            <h3 class="product-name"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <div class="product-price">R$ <?php echo $preco; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
