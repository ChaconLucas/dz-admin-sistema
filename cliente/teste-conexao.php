<?php
/**
 * Página de Teste para Verificação de Conexão
 * Use apenas para debug - remova em produção
 */

// Carrega as configurações
require_once 'config-cliente.php';

echo "<h1>Teste de Conexão - Área do Cliente</h1>";

echo "<h2>1. Verificação de Caminhos</h2>";
echo "<ul>";
echo "<li><strong>PATH_CONFIG:</strong> " . PATH_CONFIG . "</li>";
echo "<li><strong>PATH_PHP_ADMIN:</strong> " . PATH_PHP_ADMIN . "</li>";
echo "<li><strong>PATH_ASSETS:</strong> " . PATH_ASSETS . "</li>";
echo "<li><strong>PATH_SRC:</strong> " . PATH_SRC . "</li>";
echo "</ul>";

echo "<h2>2. Verificação de Arquivos</h2>";
echo "<ul>";
echo "<li><strong>config.php existe:</strong> " . (file_exists(PATH_CONFIG . 'config.php') ? '✅ SIM' : '❌ NÃO') . "</li>";
echo "<li><strong>conexao.php existe:</strong> " . (file_exists(PATH_PHP_ADMIN . 'conexao.php') ? '✅ SIM' : '❌ NÃO') . "</li>";
echo "</ul>";

echo "<h2>3. Constantes de Conexão</h2>";
echo "<ul>";
echo "<li><strong>HOST:</strong> " . (defined('HOST') ? HOST : 'NÃO DEFINIDO') . "</li>";
echo "<li><strong>USUARIO:</strong> " . (defined('USUARIO') ? USUARIO : 'NÃO DEFINIDO') . "</li>";
echo "<li><strong>DB:</strong> " . (defined('DB') ? DB : 'NÃO DEFINIDO') . "</li>";
echo "<li><strong>SENHA:</strong> " . (defined('SENHA') ? '***' : 'NÃO DEFINIDO') . "</li>";
echo "</ul>";

echo "<h2>4. Teste de Conexão</h2>";

$conexao = getConexaoBanco();

if ($conexao) {
    echo "<p style='color: green;'>✅ <strong>Conexão estabelecida com sucesso!</strong></p>";
    
    // Teste de ping
    if (mysqli_ping($conexao)) {
        echo "<p style='color: green;'>✅ <strong>Ping do MySQL: OK</strong></p>";
    } else {
        echo "<p style='color: orange;'>⚠️ <strong>Ping do MySQL: Falhou</strong></p>";
    }
    
    // Teste de query simples
    $resultado = mysqli_query($conexao, "SELECT 1 as teste");
    if ($resultado) {
        echo "<p style='color: green;'>✅ <strong>Query de teste: OK</strong></p>";
        mysqli_free_result($resultado);
    } else {
        echo "<p style='color: red;'>❌ <strong>Query de teste: FALHOU</strong></p>";
        echo "<p>Erro: " . mysqli_error($conexao) . "</p>";
    }
    
    // Verifica se existe tabela produtos
    $resultado = mysqli_query($conexao, "SHOW TABLES LIKE 'produtos'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<p style='color: green;'>✅ <strong>Tabela 'produtos': Existe</strong></p>";
        
        // Conta produtos
        $resultado = mysqli_query($conexao, "SELECT COUNT(*) as total FROM produtos");
        if ($resultado) {
            $row = mysqli_fetch_assoc($resultado);
            echo "<p style='color: blue;'>ℹ️ <strong>Total de produtos:</strong> " . $row['total'] . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ <strong>Tabela 'produtos': Não encontrada</strong></p>";
        echo "<p>Talvez você precise criar a tabela de produtos primeiro.</p>";
    }
    
    // Verifica se existe tabela clientes
    $resultado = mysqli_query($conexao, "SHOW TABLES LIKE 'clientes'");
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<p style='color: green;'>✅ <strong>Tabela 'clientes': Existe</strong></p>";
    } else {
        echo "<p style='color: orange;'>⚠️ <strong>Tabela 'clientes': Não encontrada</strong></p>";
        echo "<p>Você pode precisar criar esta tabela para o sistema de login.</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ <strong>FALHA na conexão com o banco de dados</strong></p>";
    echo "<p>Verifique as configurações no arquivo conexao.php</p>";
    echo "<p>Erro de conexão: " . mysqli_connect_error() . "</p>";
}

echo "<h2>5. Estrutura SQL Recomendada</h2>";
echo "<p>Se as tabelas não existem, execute estes comandos SQL:</p>";
echo "<pre style='background: #f0f0f0; padding: 15px; border-radius: 5px;'>";
echo "-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    categoria VARCHAR(100),
    descricao TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo BOOLEAN DEFAULT TRUE
);

-- Inserir alguns produtos de exemplo
INSERT IGNORE INTO produtos (nome, preco, categoria) VALUES 
('Smartphone Premium', 1299.00, 'eletronicos'),
('Notebook Gamer', 2899.00, 'eletronicos'),
('Fone Bluetooth', 199.00, 'eletronicos'),
('Smart TV 55\"', 1699.00, 'eletronicos');
";
echo "</pre>";

echo "<hr>";
echo "<p><a href='index.php' style='color: blue;'>⬅️ Voltar para a Loja</a></p>";
echo "<p><em>Nota: Esta página é apenas para debug. Remova em produção.</em></p>";
?>