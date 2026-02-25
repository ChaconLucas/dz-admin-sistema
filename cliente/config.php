<?php
/**
 * Configuração de Conexão PDO - Cliente
 * Banco: teste_dz
 * Tabela: clientes
 */

// Configurações do banco de dados
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'teste_dz');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');

/**
 * Conexão PDO com tratamento de erros
 */
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET . ", time_zone = '-03:00'"
        ];
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Em produção, registrar erro sem expor detalhes
        error_log("Erro de conexão: " . $e->getMessage());
        die("Erro ao conectar ao banco de dados. Tente novamente mais tarde.");
    }
}

// Cria a conexão global
$pdo = getConnection();

/**
 * Função auxiliar para normalizar CPF/CNPJ
 * Remove todos os caracteres especiais
 */
function normalizarCpfCnpj($cpfCnpj) {
    return preg_replace('/[^0-9]/', '', $cpfCnpj);
}

/**
 * Função auxiliar para normalizar CEP
 * Remove hífens e espaços
 */
function normalizarCep($cep) {
    return preg_replace('/[^0-9]/', '', $cep);
}

/**
 * Função para verificar se email já existe
 */
function emailExiste($pdo, $email) {
    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    return $stmt->fetch() !== false;
}

/**
 * Função para verificar se CPF/CNPJ já existe
 */
function cpfCnpjExiste($pdo, $cpfCnpj) {
    $cpfCnpjNormalizado = normalizarCpfCnpj($cpfCnpj);
    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE cpf_cnpj = ? LIMIT 1");
    $stmt->execute([$cpfCnpjNormalizado]);
    return $stmt->fetch() !== false;
}
?>
