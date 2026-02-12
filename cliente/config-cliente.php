<?php
/**
 * Configuração específica para a área do cliente
 * Define caminhos relativos para acessar recursos do admin
 */

// Define caminhos relativos para acessar os recursos
define('PATH_ROOT_ADMIN', '../admin/'); // Volta para a pasta admin
define('PATH_CONFIG', '../admin/config/'); // Pasta de configuração
define('PATH_PHP_ADMIN', '../admin/PHP/'); // Pasta PHP do admin
define('PATH_ASSETS', '../admin/assets/'); // Assets (imagens)
define('PATH_SRC', '../admin/src/'); // Pasta src

// Carrega as configurações do admin (banco de dados)
require_once PATH_CONFIG . 'config.php';

// Inclui o arquivo de conexão globalmente
require_once PATH_PHP_ADMIN . 'conexao.php';

// Função para incluir arquivos PHP do admin
function incluirArquivoAdmin($arquivo) {
    $caminho = PATH_PHP_ADMIN . $arquivo;
    if (file_exists($caminho)) {
        return require_once $caminho;
    }
    return false;
}

// Função para obter URL de assets
function getAssetUrl($arquivo) {
    return PATH_ASSETS . $arquivo;
}

// Função para obter URL de CSS
function getCssUrl($arquivo) {
    return PATH_SRC . 'css/' . $arquivo;
}

// Função para obter URL de JS
function getJsUrl($arquivo) {
    return PATH_SRC . 'js/' . $arquivo;
}

// Função para conexão com banco (usando a conexão do admin)
function getConexaoBanco() {
    global $conexao;
    
    // Verifica se a conexão existe e está ativa
    if (!isset($conexao) || !$conexao) {
        // Tenta reconectar caso necessário
        $conexao = mysqli_connect(HOST, USUARIO, SENHA, DB);
        if (!$conexao) {
            error_log("Erro de conexão com banco de dados: " . mysqli_connect_error());
            return null;
        }
        // Configura timezone
        mysqli_query($conexao, "SET time_zone = '-03:00'");
    }
    
    return $conexao;
}

// Função para verificar se a conexão está funcionando
function verificarConexaoBanco() {
    $conn = getConexaoBanco();
    return ($conn !== null && mysqli_ping($conn));
}

?>