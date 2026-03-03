<?php
/**
 * CMS DATA PROVIDER - Integração Site Público
 * Fornece dados do CMS (banners, textos, produtos em destaque)
 * para o site público usando conexão mysqli existente
 * 
 * USO: 
 * require_once 'cms_data_provider.php';
 * $cms = new CMSProvider($conexao);
 */

/**
 * =====================================================
 * CLASSE CMS PROVIDER - Dependency Injection
 * =====================================================
 * Recebe conexão mysqli já existente via construtor
 */
class CMSProvider {
    
    /**
     * @var mysqli Conexão mysqli compartilhada
     */
    private $conn;
    
    /**
     * Construtor - Recebe conexão existente
     * 
     * @param mysqli $conn Conexão mysqli já configurada
     */
    public function __construct($conn) {
        if (!$conn instanceof mysqli) {
            throw new InvalidArgumentException('CMSProvider requer uma conexão mysqli válida');
        }
        $this->conn = $conn;
    }
    
    /**
     * Buscar configurações da home (textos)
     * 
     * @return array Configurações ou fallback se não existir
     */
    public function getHomeSettings() {
        $query = "
            SELECT hero_title, hero_subtitle, hero_description, 
                   hero_button_text, hero_button_link,
                   launch_title, launch_subtitle, banner_interval
            FROM home_settings 
            WHERE id = 1
            LIMIT 1
        ";
        
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            error_log("Erro ao buscar home_settings: " . mysqli_error($this->conn));
            return $this->getDefaultHomeSettings();
        }
        
        $settings = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        
        // Se não houver dados, retornar fallback
        if (!$settings) {
            return $this->getDefaultHomeSettings();
        }
        
        return $settings;
    }
    
    /**
     * Buscar banners ativos (ordenados por position)
     * 
     * @return array Lista de banners ativos
     */
    public function getActiveBanners() {
        $query = "
            SELECT id, title, subtitle, description, image_path, 
                   button_text, button_link, position
            FROM home_banners 
            WHERE is_active = 1 
            ORDER BY position ASC
        ";
        
        $result = mysqli_query($this->conn, $query);
        
        if (!$result) {
            error_log("Erro ao buscar banners: " . mysqli_error($this->conn));
            return [];
        }
        
        $banners = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        
        return $banners;
    }
    
    /**
     * Buscar produtos em destaque (com prepared statement)
     * 
     * @param int $limit Limite de produtos (padrão: 6)
     * @return array Lista de produtos em destaque
     */
    public function getFeaturedProducts($limit = 6) {
        $query = "
            SELECT 
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.preco_promocional,
                p.imagem_principal,
                p.slug,
                fp.position
            FROM home_featured_products fp
            INNER JOIN produtos p ON fp.product_id = p.id
            WHERE fp.section_key = 'launches'
              AND p.status = 'ativo'
              AND p.estoque > 0
            ORDER BY fp.position ASC
            LIMIT ?
        ";
        
        $stmt = mysqli_prepare($this->conn, $query);
        
        if (!$stmt) {
            error_log("Erro ao preparar query de produtos: " . mysqli_error($this->conn));
            return [];
        }
        
        // Bind do parâmetro limit (tipo i = integer)
        mysqli_stmt_bind_param($stmt, 'i', $limit);
        
        // Executar
        if (!mysqli_stmt_execute($stmt)) {
            error_log("Erro ao executar query de produtos: " . mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return [];
        }
        
        // Obter resultado
        $result = mysqli_stmt_get_result($stmt);
        
        if (!$result) {
            error_log("Erro ao obter resultado de produtos: " . mysqli_error($this->conn));
            mysqli_stmt_close($stmt);
            return [];
        }
        
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        mysqli_free_result($result);
        mysqli_stmt_close($stmt);
        
        return $products;
    }
    
    /**
     * Buscar todos os dados com fallback
     * 
     * @return array Array com banners, settings e featured_products
     */
    public function getAllData() {
        $banners = $this->getActiveBanners();
        $settings = $this->getHomeSettings();
        $featured = $this->getFeaturedProducts(8);
        
        // Fallback para banners vazios
        if (empty($banners)) {
            $banners = [[
                'title' => 'Bem-vindo à D&Z',
                'subtitle' => 'Beleza Premium',
                'description' => 'Descubra produtos profissionais de qualidade superior',
                'image_path' => '',
                'button_text' => 'Ver Produtos',
                'button_link' => '#catalogo'
            ]];
        }
        
        return [
            'banners' => $banners,
            'settings' => $settings,
            'featured_products' => $featured
        ];
    }
    
    /**
     * Configurações padrão da home (fallback)
     * 
     * @return array
     */
    private function getDefaultHomeSettings() {
        return [
            'hero_title' => 'Bem-vindo à D&Z',
            'hero_subtitle' => 'Beleza Premium para Você',
            'hero_description' => 'Descubra produtos profissionais de qualidade superior',
            'hero_button_text' => 'Ver Produtos',
            'hero_button_link' => '#catalogo',
            'launch_title' => 'Lançamentos',
            'launch_subtitle' => 'Conheça as novidades exclusivas que acabaram de chegar na D&Z'
        ];
    }
}

/**
 * =====================================================
 * HELPER FUNCTIONS - Funções Auxiliares
 * =====================================================
 */

/**
 * Helper: URL da imagem do banner (caminho relativo correto)
 * 
 * @param string $image_path Caminho da imagem do banco
 * @return string Caminho relativo correto ou vazio
 */
function getBannerImageUrl($image_path) {
    // Se vazio, retornar vazio
    if (empty($image_path)) {
        return '';
    }
    
    // Se começar com http/https, retornar direto (URL externa)
    if (preg_match('#^https?://#i', $image_path)) {
        return $image_path;
    }
    
    // Sanitizar: remover barras duplicadas e path traversal
    $image_path = str_replace(['../', '.\\'], '', $image_path);
    $image_path = preg_replace('#/+#', '/', $image_path);
    
    // Se o caminho não incluir 'uploads/banners/', adicionar
    if (strpos($image_path, 'uploads/banners/') === false) {
        $image_path = 'uploads/banners/' . ltrim($image_path, '/');
    }
    
    // Caminho relativo ao index.php (que está em cliente/)
    // index.php está em: admin-teste/cliente/
    // Upload está em: admin-teste/uploads/banners/
    // Então: ../ sobe para admin-teste/
    return '../' . ltrim($image_path, '/');
}

/**
 * Helper: Preço formatado em R$
 * 
 * @param float $price Preço em decimal
 * @return string Preço formatado (ex: R$ 24,90)
 */
function formatPrice($price) {
    return 'R$ ' . number_format($price, 2, ',', '.');
}

/**
 * Helper: Verificar se produto está em promoção
 * 
 * @param array $product Array do produto
 * @return bool True se em promoção
 */
function isOnSale($product) {
    return isset($product['preco_promocional']) 
           && $product['preco_promocional'] > 0 
           && $product['preco_promocional'] < $product['preco'];
}

/**
 * Helper: Calcular desconto percentual
 * 
 * @param float $regular_price Preço regular
 * @param float $sale_price Preço promocional
 * @return int Percentual de desconto
 */
function getDiscountPercentage($regular_price, $sale_price) {
    if ($sale_price >= $regular_price) return 0;
    return round((($regular_price - $sale_price) / $regular_price) * 100);
}

