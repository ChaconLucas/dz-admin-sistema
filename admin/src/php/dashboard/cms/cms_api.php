<?php
/**
 * CMS API Handler - Processa todas as ações do CMS
 * Banners, Home Settings, Featured Products
 */

// Log de erros em arquivo
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/cms_api_errors.log');

// Registrar início
file_put_contents(__DIR__ . '/cms_api_debug.log', 
    date('Y-m-d H:i:s') . " - API chamada\n", 
    FILE_APPEND
);

session_start();

// Verificar autenticação
if (!isset($_SESSION['usuario_logado'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Não autorizado']);
    exit();
}

require_once '../../../../PHP/conexao.php';

// Headers JSON
header('Content-Type: application/json');

// Capturar ação
$action = $_POST['action'] ?? $_GET['action'] ?? null;

file_put_contents(__DIR__ . '/cms_api_debug.log', 
    date('Y-m-d H:i:s') . " - Action: $action\n", 
    FILE_APPEND
);

if (!$action) {
    echo json_encode(['success' => false, 'message' => 'Ação não especificada']);
    exit();
}

// ====================================================================
// BANNERS - AÇÕES
// ====================================================================

if ($action === 'list_banners') {
    $sql = "SELECT * FROM home_banners ORDER BY position ASC, id DESC";
    $result = mysqli_query($conexao, $sql);
    
    $banners = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $banners[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $banners]);
    exit();
}

if ($action === 'add_banner') {
    // Buscar campos (todos opcionais agora)
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $button_text = trim($_POST['button_text'] ?? '');
    $button_link = trim($_POST['button_link'] ?? '');
    
    // Upload de imagem (opcional)
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_result = upload_banner_image($_FILES['image']);
        if (!$upload_result['success']) {
            echo json_encode($upload_result);
            exit();
        }
        $image_path = $upload_result['path'];
    }
    
    // Obter próxima posição
    $position_result = mysqli_query($conexao, "SELECT MAX(position) as max_pos FROM home_banners");
    $position_row = mysqli_fetch_assoc($position_result);
    $next_position = ($position_row['max_pos'] ?? 0) + 1;
    
    // Inserir banner
    $stmt = mysqli_prepare($conexao, 
        "INSERT INTO home_banners (title, subtitle, description, image_path, button_text, button_link, position) 
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    
    mysqli_stmt_bind_param($stmt, 'ssssssi', 
        $title, $subtitle, $description, $image_path, $button_text, $button_link, $next_position
    );
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Banner adicionado com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar banner']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'edit_banner') {
    $id = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit();
    }
    
    // Se houver nova imagem
    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_result = upload_banner_image($_FILES['image']);
        if (!$upload_result['success']) {
            echo json_encode($upload_result);
            exit();
        }
        $image_path = $upload_result['path'];
    }
    
    // Atualizar banner
    if ($image_path) {
        $stmt = mysqli_prepare($conexao,
            "UPDATE home_banners 
             SET title=?, subtitle=?, description=?, image_path=?, button_text=?, button_link=?, updated_at=NOW()
             WHERE id=?"
        );
        mysqli_stmt_bind_param($stmt, 'ssssssi',
            $_POST['title'], $_POST['subtitle'], $_POST['description'], 
            $image_path, $_POST['button_text'], $_POST['button_link'], $id
        );
    } else {
        $stmt = mysqli_prepare($conexao,
            "UPDATE home_banners 
             SET title=?, subtitle=?, description=?, button_text=?, button_link=?, updated_at=NOW()
             WHERE id=?"
        );
        mysqli_stmt_bind_param($stmt, 'sssssi',
            $_POST['title'], $_POST['subtitle'], $_POST['description'],
            $_POST['button_text'], $_POST['button_link'], $id
        );
    }
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Banner atualizado!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'toggle_banner') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit();
    }
    
    $stmt = mysqli_prepare($conexao, "UPDATE home_banners SET is_active = NOT is_active WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Status alterado!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao alterar status']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'delete_banner') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit();
    }
    
    $stmt = mysqli_prepare($conexao, "DELETE FROM home_banners WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Banner excluído!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao excluir']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'move_banner') {
    $id = (int)($_POST['id'] ?? 0);
    $direction = $_POST['direction'] ?? '';
    
    if ($id <= 0 || !in_array($direction, ['up', 'down'])) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit();
    }
    
    // Buscar posição atual
    $stmt = mysqli_prepare($conexao, "SELECT position FROM home_banners WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $banner = mysqli_fetch_assoc($result);
    
    if (!$banner) {
        echo json_encode(['success' => false, 'message' => 'Banner não encontrado']);
        exit();
    }
    
    $current_pos = $banner['position'];
    
    // Determinar nova posição
    if ($direction === 'up') {
        // Trocar com o banner de posição anterior
        $stmt = mysqli_prepare($conexao, 
            "SELECT id, position FROM home_banners WHERE position < ? ORDER BY position DESC LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, 'i', $current_pos);
    } else {
        // Trocar com o banner de posição posterior
        $stmt = mysqli_prepare($conexao,
            "SELECT id, position FROM home_banners WHERE position > ? ORDER BY position ASC LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, 'i', $current_pos);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $swap_banner = mysqli_fetch_assoc($result);
    
    if (!$swap_banner) {
        echo json_encode(['success' => false, 'message' => 'Não é possível mover mais nessa direção']);
        exit();
    }
    
    // Trocar posições
    mysqli_begin_transaction($conexao);
    
    try {
        // Atualizar banner atual
        $stmt1 = mysqli_prepare($conexao, "UPDATE home_banners SET position = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt1, 'ii', $swap_banner['position'], $id);
        mysqli_stmt_execute($stmt1);
        
        // Atualizar banner com quem trocamos
        $stmt2 = mysqli_prepare($conexao, "UPDATE home_banners SET position = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt2, 'ii', $current_pos, $swap_banner['id']);
        mysqli_stmt_execute($stmt2);
        
        mysqli_commit($conexao);
        echo json_encode(['success' => true, 'message' => 'Posição alterada!']);
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        echo json_encode(['success' => false, 'message' => 'Erro ao mover banner']);
    }
    
    exit();
}

// ====================================================================
// HOME SETTINGS - AÇÕES
// ====================================================================

if ($action === 'get_home_settings') {
    $result = mysqli_query($conexao, "SELECT * FROM home_settings WHERE id = 1");
    $settings = mysqli_fetch_assoc($result);
    
    echo json_encode(['success' => true, 'data' => $settings]);
    exit();
}

if ($action === 'update_home_settings') {
    file_put_contents(__DIR__ . '/cms_api_debug.log', 
        date('Y-m-d H:i:s') . " - Iniciando update_home_settings\n", 
        FILE_APPEND
    );
    
    // Verificar se a coluna banner_interval existe
    $checkColumn = mysqli_query($conexao, "SHOW COLUMNS FROM home_settings LIKE 'banner_interval'");
    $hasBannerInterval = mysqli_num_rows($checkColumn) > 0;
    
    file_put_contents(__DIR__ . '/cms_api_debug.log', 
        date('Y-m-d H:i:s') . " - Has banner_interval: " . ($hasBannerInterval ? 'YES' : 'NO') . "\n", 
        FILE_APPEND
    );
    
    if ($hasBannerInterval) {
        // Com banner_interval
        $stmt = mysqli_prepare($conexao,
            "UPDATE home_settings SET 
             hero_title=?, hero_subtitle=?, hero_description=?, 
             hero_button_text=?, hero_button_link=?,
             launch_title=?, launch_subtitle=?,
             banner_interval=?,
             updated_at=NOW()
             WHERE id=1"
        );
        
        if (!$stmt) {
            $error = mysqli_error($conexao);
            file_put_contents(__DIR__ . '/cms_api_debug.log', 
                date('Y-m-d H:i:s') . " - ERRO prepare: $error\n", 
                FILE_APPEND
            );
            echo json_encode(['success' => false, 'message' => 'Erro ao preparar query: ' . $error]);
            exit();
        }
        
        $hero_title = $_POST['hero_title'] ?? '';
        $hero_subtitle = $_POST['hero_subtitle'] ?? '';
        $hero_description = $_POST['hero_description'] ?? '';
        $hero_button_text = $_POST['hero_button_text'] ?? '';
        $hero_button_link = $_POST['hero_button_link'] ?? '';
        $launch_title = $_POST['launch_title'] ?? '';
        $launch_subtitle = $_POST['launch_subtitle'] ?? '';
        $banner_interval = (int)($_POST['banner_interval'] ?? 6);
        
        file_put_contents(__DIR__ . '/cms_api_debug.log', 
            date('Y-m-d H:i:s') . " - Valores: interval=$banner_interval\n", 
            FILE_APPEND
        );
        
        $bindResult = mysqli_stmt_bind_param($stmt, 'sssssssi',
            $hero_title, $hero_subtitle, $hero_description,
            $hero_button_text, $hero_button_link,
            $launch_title, $launch_subtitle,
            $banner_interval
        );
        
        if (!$bindResult) {
            $error = mysqli_stmt_error($stmt);
            file_put_contents(__DIR__ . '/cms_api_debug.log', 
                date('Y-m-d H:i:s') . " - ERRO bind: $error\n", 
                FILE_APPEND
            );
            echo json_encode(['success' => false, 'message' => 'Erro ao fazer bind: ' . $error]);
            exit();
        }
    } else {
        // Sem banner_interval (compatibilidade)
        $stmt = mysqli_prepare($conexao,
            "UPDATE home_settings SET 
             hero_title=?, hero_subtitle=?, hero_description=?, 
             hero_button_text=?, hero_button_link=?,
             launch_title=?, launch_subtitle=?,
             updated_at=NOW()
             WHERE id=1"
        );
        
        mysqli_stmt_bind_param($stmt, 'sssssss',
            $_POST['hero_title'], $_POST['hero_subtitle'], $_POST['hero_description'],
            $_POST['hero_button_text'], $_POST['hero_button_link'],
            $_POST['launch_title'], $_POST['launch_subtitle']
        );
    }
    
    if (mysqli_stmt_execute($stmt)) {
        file_put_contents(__DIR__ . '/cms_api_debug.log', 
            date('Y-m-d H:i:s') . " - UPDATE executado com sucesso\n", 
            FILE_APPEND
        );
        
        $message = 'Configurações salvas com sucesso!';
        if (!$hasBannerInterval) {
            $message .= ' (Execute a migração do banco para ativar o intervalo do carrossel)';
        }
        echo json_encode(['success' => true, 'message' => $message]);
    } else {
        $error = mysqli_stmt_error($stmt);
        file_put_contents(__DIR__ . '/cms_api_debug.log', 
            date('Y-m-d H:i:s') . " - ERRO execute: $error\n", 
            FILE_APPEND
        );
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar: ' . $error]);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

// ====================================================================
// FEATURED PRODUCTS - AÇÕES
// ====================================================================

if ($action === 'list_products') {
    $search = $_GET['search'] ?? '';
    
    $sql = "SELECT id, nome, preco, preco_promocional, imagem_principal AS imagem, 
                   estoque, status, sku
            FROM produtos 
            WHERE status = 'ativo' AND estoque > 0";
    
    if (!empty($search)) {
        $sql .= " AND nome LIKE ?";
        $stmt = mysqli_prepare($conexao, $sql . " ORDER BY nome ASC LIMIT 50");
        $search_param = "%$search%";
        mysqli_stmt_bind_param($stmt, 's', $search_param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $result = mysqli_query($conexao, $sql . " ORDER BY nome ASC LIMIT 50");
    }
    
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $products]);
    exit();
}

if ($action === 'list_featured_products') {
    $section = $_GET['section'] ?? 'launches';
    
    $sql = "SELECT hfp.id, hfp.product_id AS produto_id, hfp.position, 
                   p.nome AS produto_nome, p.preco AS produto_preco, 
                   p.imagem_principal AS produto_imagem
            FROM home_featured_products hfp
            INNER JOIN produtos p ON hfp.product_id = p.id
            WHERE hfp.section_key = ?
            ORDER BY hfp.position ASC";
    
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 's', $section);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    
    echo json_encode(['success' => true, 'data' => $products]);
    exit();
}

if ($action === 'add_featured_product') {
    $section = $_POST['section'] ?? 'launches';
    $product_id = (int)($_POST['product_id'] ?? 0);
    
    if ($product_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Produto inválido']);
        exit();
    }
    
    // Verificar se já existe
    $check = mysqli_prepare($conexao, "SELECT id FROM home_featured_products WHERE section_key=? AND product_id=?");
    mysqli_stmt_bind_param($check, 'si', $section, $product_id);
    mysqli_stmt_execute($check);
    if (mysqli_stmt_get_result($check)->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Produto já está na lista']);
        exit();
    }
    
    // Obter próxima posição
    $pos_result = mysqli_query($conexao, "SELECT MAX(position) as max_pos FROM home_featured_products WHERE section_key='$section'");
    $pos_row = mysqli_fetch_assoc($pos_result);
    $next_pos = ($pos_row['max_pos'] ?? 0) + 1;
    
    // Inserir
    $stmt = mysqli_prepare($conexao,
        "INSERT INTO home_featured_products (section_key, product_id, position) VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, 'sii', $section, $product_id, $next_pos);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Produto adicionado!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'remove_featured_product') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit();
    }
    
    $stmt = mysqli_prepare($conexao, "DELETE FROM home_featured_products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'Produto removido!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao remover']);
    }
    
    mysqli_stmt_close($stmt);
    exit();
}

if ($action === 'move_featured_product') {
    $id = (int)($_POST['id'] ?? 0);
    $direction = $_POST['direction'] ?? '';
    
    if ($id <= 0 || !in_array($direction, ['up', 'down'])) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit();
    }
    
    // Similar à lógica de move_banner
    $stmt = mysqli_prepare($conexao, "SELECT position, section_key FROM home_featured_products WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $item = mysqli_fetch_assoc($result);
    
    if (!$item) {
        echo json_encode(['success' => false, 'message' => 'Item não encontrado']);
        exit();
    }
    
    $current_pos = $item['position'];
    $section = $item['section_key'];
    
    if ($direction === 'up') {
        $stmt = mysqli_prepare($conexao,
            "SELECT id, position FROM home_featured_products 
             WHERE section_key=? AND position < ? ORDER BY position DESC LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, 'si', $section, $current_pos);
    } else {
        $stmt = mysqli_prepare($conexao,
            "SELECT id, position FROM home_featured_products 
             WHERE section_key=? AND position > ? ORDER BY position ASC LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, 'si', $section, $current_pos);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $swap_item = mysqli_fetch_assoc($result);
    
    if (!$swap_item) {
        echo json_encode(['success' => false, 'message' => 'Não é possível mover mais nessa direção']);
        exit();
    }
    
    // Trocar posições
    mysqli_begin_transaction($conexao);
    
    try {
        $stmt1 = mysqli_prepare($conexao, "UPDATE home_featured_products SET position = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt1, 'ii', $swap_item['position'], $id);
        mysqli_stmt_execute($stmt1);
        
        $stmt2 = mysqli_prepare($conexao, "UPDATE home_featured_products SET position = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt2, 'ii', $current_pos, $swap_item['id']);
        mysqli_stmt_execute($stmt2);
        
        mysqli_commit($conexao);
        echo json_encode(['success' => true, 'message' => 'Posição alterada!']);
    } catch (Exception $e) {
        mysqli_rollback($conexao);
        echo json_encode(['success' => false, 'message' => 'Erro ao mover']);
    }
    
    exit();
}

// ====================================================================
// FUNÇÃO DE UPLOAD SEGURO - VERSÃO MELHORADA COM DEBUG
// ====================================================================

function upload_banner_image($file) {
    // Log inicial
    error_log("=== UPLOAD BANNER IMAGE - INÍCIO ===");
    error_log("Arquivo recebido: " . ($file['name'] ?? 'VAZIO'));
    error_log("Tamanho: " . ($file['size'] ?? 0) . " bytes");
    error_log("Tmp name: " . ($file['tmp_name'] ?? 'VAZIO'));
    error_log("Error code: " . ($file['error'] ?? 'N/A'));
    
    // Validar se arquivo foi realmente enviado
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        error_log("ERRO: tmp_name vazio ou não definido");
        return ['success' => false, 'message' => 'Arquivo temporário não encontrado'];
    }
    
    if (!is_uploaded_file($file['tmp_name'])) {
        error_log("ERRO: Arquivo não foi enviado via POST (possível ataque)");
        return ['success' => false, 'message' => 'Arquivo inválido'];
    }
    
    // Validar extensão
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    $file_type = mime_content_type($file['tmp_name']);
    error_log("MIME Type detectado: " . $file_type);
    
    if (!in_array($file_type, $allowed_types)) {
        error_log("ERRO: Tipo de arquivo não permitido: " . $file_type);
        return ['success' => false, 'message' => 'Formato inválido. Use JPG, PNG ou WEBP'];
    }
    
    // Validar tamanho (2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        error_log("ERRO: Arquivo muito grande: " . $file['size'] . " bytes");
        return ['success' => false, 'message' => 'Imagem muito grande. Máximo 2MB'];
    }
    
    // =====================================================
    // CAMINHO ABSOLUTO ROBUSTO
    // =====================================================
    
    // cms_api.php está em: admin/src/php/dashboard/cms/
    // Precisamos chegar em: admin-teste/uploads/banners/
    // Subir 5 níveis: cms → dashboard → php → src → admin → admin-teste
    $upload_dir = dirname(__DIR__, 5) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'banners' . DIRECTORY_SEPARATOR;
    
    // Normalizar barras (Windows/Linux)
    $upload_dir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $upload_dir);
    
    error_log("Caminho de upload (relativo): " . $upload_dir);
    error_log("__DIR__ atual: " . __DIR__);
    
    // =====================================================
    // CRIAR PASTA SE NÃO EXISTIR
    // =====================================================
    
    if (!is_dir($upload_dir)) {
        error_log("Pasta não existe, tentando criar: " . $upload_dir);
        
        if (!mkdir($upload_dir, 0755, true)) {
            $error_msg = error_get_last();
            error_log("ERRO: Falha ao criar pasta: " . ($error_msg['message'] ?? 'desconhecido'));
            return ['success' => false, 'message' => 'Erro ao criar pasta de upload. Verifique permissões.'];
        }
        
        error_log("Pasta criada com sucesso!");
    } else {
        error_log("Pasta já existe: " . $upload_dir);
    }
    
    // =====================================================
    // VERIFICAR PERMISSÕES
    // =====================================================
    
    if (!is_writable($upload_dir)) {
        error_log("ERRO: Pasta sem permissão de escrita!");
        return ['success' => false, 'message' => 'Pasta de upload sem permissão de escrita'];
    }
    
    error_log("Pasta tem permissão de escrita: OK");
    
    // Obter caminho real (absoluto) para debug
    $real_upload_dir = realpath($upload_dir);
    error_log("Caminho real absoluto: " . ($real_upload_dir ?: 'FALHOU realpath()'));
    
    // =====================================================
    // GERAR NOME ÚNICO E SEGURO
    // =====================================================
    
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $filename = 'banner_' . time() . '_' . uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    error_log("Nome do arquivo gerado: " . $filename);
    error_log("Caminho completo de destino: " . $filepath);
    
    // =====================================================
    // MOVER ARQUIVO
    // =====================================================
    
    error_log("Tentando mover arquivo...");
    error_log("FROM: " . $file['tmp_name']);
    error_log("TO: " . $filepath);
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        error_log("✓ Upload bem-sucedido!");
        
        // Verificar se arquivo foi realmente criado
        if (file_exists($filepath)) {
            $filesize = filesize($filepath);
            error_log("✓ Arquivo existe fisicamente! Tamanho: " . $filesize . " bytes");
            error_log("✓ Caminho completo: " . realpath($filepath));
        } else {
            error_log("⚠️ ALERTA: move_uploaded_file retornou true mas arquivo não existe!");
        }
        
        // Retornar caminho relativo para salvar no banco
        $relative_path = 'uploads/banners/' . $filename;
        error_log("Caminho relativo para banco: " . $relative_path);
        error_log("=== UPLOAD BANNER IMAGE - FIM (SUCESSO) ===");
        
        return [
            'success' => true,
            'path' => $relative_path,
            'filename' => $filename
        ];
    } else {
        $error_msg = error_get_last();
        $error_detail = $error_msg ? $error_msg['message'] : 'Desconhecido';
        
        error_log("✗ ERRO no move_uploaded_file!");
        error_log("Detalhes do erro: " . $error_detail);
        error_log("=== UPLOAD BANNER IMAGE - FIM (FALHA) ===");
        
        return [
            'success' => false, 
            'message' => 'Erro ao mover arquivo. Verifique logs do servidor.',
            'debug' => $error_detail
        ];
    }
}

// ====================================================================
// AÇÃO INVÁLIDA
// ====================================================================

echo json_encode(['success' => false, 'message' => 'Ação não reconhecida: ' . $action]);
exit();
