<?php
/**
 * Setup da Tabela cms_testimonials
 * Execute este arquivo uma vez para criar a tabela no banco
 */
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    die('Acesso negado. Faça login como administrador.');
}

require_once '../../../../PHP/conexao.php';

// Ler e executar SQL
$sql = file_get_contents(__DIR__ . '/create_testimonials_table.sql');

// Executar cada statement separadamente
$statements = array_filter(
    array_map('trim', explode(';', $sql)), 
    fn($s) => !empty($s) && strpos($s, '--') !== 0
);

$success = true;
$messages = [];

mysqli_begin_transaction($conexao);

try {
    foreach ($statements as $statement) {
        if (!empty(trim($statement))) {
            if (!mysqli_query($conexao, $statement)) {
                throw new Exception(mysqli_error($conexao));
            }
        }
    }
    
    mysqli_commit($conexao);
    $messages[] = "✅ Tabela cms_testimonials criada com sucesso!";
    $messages[] = "✅ 3 depoimentos de exemplo inseridos.";
    
} catch (Exception $e) {
    mysqli_rollback($conexao);
    $success = false;
    $messages[] = "❌ Erro: " . $e->getMessage();
}

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Depoimentos - D&Z CMS</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #f8fafc;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        h1 {
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }
        .message {
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #ff00d4, #ff1493);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🗣️ Setup - Depoimentos de Clientes</h1>
        <p class="subtitle">Configuração da tabela cms_testimonials</p>
        
        <?php foreach ($messages as $message): ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endforeach; ?>
        
        <?php if ($success): ?>
            <p style="margin-top: 20px; color: #6b7280;">
                Você pode agora acessar a página de Depoimentos no CMS para gerenciar os depoimentos.
            </p>
        <?php endif; ?>
        
        <a href="testimonials.php" class="btn">Ir para Depoimentos</a>
    </div>
</body>
</html>
