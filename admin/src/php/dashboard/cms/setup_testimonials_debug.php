<?php
/**
 * Setup DEBUG da Tabela cms_testimonials
 * Este arquivo mostra todos os detalhes da execução
 */
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    die('Acesso negado. Faça login como administrador.');
}

require_once '../../../../PHP/conexao.php';

$logs = [];
$success = true;

// 1. Verificar conexão
$logs[] = "✅ Conexão estabelecida com banco: " . DB;
$logs[] = "✅ Host: " . HOST;

// 2. Verificar se tabela já existe
$check = mysqli_query($conexao, "SHOW TABLES LIKE 'cms_testimonials'");
if (mysqli_num_rows($check) > 0) {
    $logs[] = "⚠️ Tabela cms_testimonials JÁ EXISTE. Será recriada.";
    mysqli_query($conexao, "DROP TABLE cms_testimonials");
} else {
    $logs[] = "ℹ️ Tabela não existe. Será criada.";
}

// 3. Criar tabela (SQL direto, sem split)
$sql_create = "CREATE TABLE cms_testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL COMMENT 'Nome do cliente',
    cargo_empresa VARCHAR(120) NULL COMMENT 'Cargo/função do cliente',
    texto VARCHAR(600) NOT NULL COMMENT 'Texto do depoimento',
    rating TINYINT NOT NULL DEFAULT 5 COMMENT 'Avaliação de 1 a 5 estrelas',
    avatar_path VARCHAR(255) NULL COMMENT 'Caminho da foto do cliente',
    ordem INT DEFAULT 0 COMMENT 'Ordem de exibição',
    ativo TINYINT(1) DEFAULT 1 COMMENT 'Depoimento ativo/inativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_ativo (ativo),
    INDEX idx_ordem (ordem)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (mysqli_query($conexao, $sql_create)) {
    $logs[] = "✅ Tabela cms_testimonials CRIADA com sucesso!";
} else {
    $logs[] = "❌ ERRO ao criar tabela: " . mysqli_error($conexao);
    $success = false;
}

// 4. Inserir dados de exemplo (se tabela foi criada)
if ($success) {
    $inserts = [
        "INSERT INTO cms_testimonials (nome, cargo_empresa, texto, rating, ordem, ativo) VALUES ('Maria Silva', 'Cliente verificada', 'Simplesmente apaixonada pelos produtos! A qualidade é incrível e o atendimento é excepcional. Minha pele nunca esteve tão bonita!', 5, 1, 1)",
        "INSERT INTO cms_testimonials (nome, cargo_empresa, texto, rating, ordem, ativo) VALUES ('Ana Costa', 'Cliente verificada', 'O kit de unhas é perfeito! Resultado de salão em casa. Economizei muito e o resultado é profissional. Super recomendo!', 5, 2, 1)",
        "INSERT INTO cms_testimonials (nome, cargo_empresa, texto, rating, ordem, ativo) VALUES ('Carla Mendes', 'Cliente verificada', 'Entrega rápida e produtos originais! Já fiz várias compras e sempre fico satisfeita. Virei cliente fiel da D&Z!', 5, 3, 1)"
    ];
    
    $inserted = 0;
    foreach ($inserts as $i => $sql) {
        if (mysqli_query($conexao, $sql)) {
            $inserted++;
        } else {
            $logs[] = "❌ ERRO no INSERT #" . ($i+1) . ": " . mysqli_error($conexao);
            $success = false;
        }
    }
    
    if ($inserted == 3) {
        $logs[] = "✅ 3 depoimentos de exemplo inseridos!";
    }
}

// 5. Verificação final
$verify = mysqli_query($conexao, "SELECT COUNT(*) as total FROM cms_testimonials");
if ($verify) {
    $row = mysqli_fetch_assoc($verify);
    $logs[] = "✅ VERIFICAÇÃO FINAL: " . $row['total'] . " registros na tabela";
} else {
    $logs[] = "❌ ERRO na verificação: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup DEBUG - Depoimentos</title>
    <style>
        body {
            font-family: 'Consolas', 'Monaco', monospace;
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #1a1a1a;
            color: #00ff00;
        }
        .card {
            background: #2a2a2a;
            padding: 30px;
            border-radius: 12px;
            border: 2px solid #00ff00;
        }
        h1 {
            color: #00ff00;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }
        .log {
            padding: 8px 12px;
            margin: 5px 0;
            border-left: 3px solid #00ff00;
            background: rgba(0, 255, 0, 0.05);
        }
        .log.error {
            border-left-color: #ff0000;
            color: #ff6666;
        }
        .log.warning {
            border-left-color: #ffaa00;
            color: #ffdd88;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #00ff00;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.2s;
        }
        .btn:hover {
            background: #00cc00;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🔧 Setup DEBUG - Depoimentos</h1>
        <p style="color: #888; margin-bottom: 30px;">Log detalhado da execução</p>
        
        <?php foreach ($logs as $log): ?>
            <?php
            $class = '';
            if (strpos($log, '❌') !== false) $class = 'error';
            elseif (strpos($log, '⚠️') !== false) $class = 'warning';
            ?>
            <div class="log <?= $class ?>"><?= htmlspecialchars($log) ?></div>
        <?php endforeach; ?>
        
        <?php if ($success): ?>
            <div style="margin-top: 30px; padding: 20px; background: rgba(0,255,0,0.1); border-radius: 8px;">
                <strong style="color: #00ff00; font-size: 1.2rem;">✅ Setup concluído com sucesso!</strong>
            </div>
            <a href="testimonials.php" class="btn">→ IR PARA DEPOIMENTOS</a>
        <?php else: ?>
            <div style="margin-top: 30px; padding: 20px; background: rgba(255,0,0,0.1); border-radius: 8px;">
                <strong style="color: #ff6666; font-size: 1.2rem;">❌ Ocorreram erros durante o setup</strong>
            </div>
            <a href="setup_testimonials_debug.php" class="btn" style="background: #ffaa00;">🔄 TENTAR NOVAMENTE</a>
        <?php endif; ?>
    </div>
</body>
</html>
