<?php
/**
 * Processamento de Login para Área do Cliente
 */

// Carrega as configurações
require_once 'config-cliente.php';

// Conecta ao banco
$conexao = getConexaoBanco();

// Verifica se a conexão está funcionando
if (!$conexao || !verificarConexaoBanco()) {
    error_log("Erro: Não foi possível conectar ao banco de dados em auth.php");
    // Define uma resposta de erro para evitar crashes
    $resultado = ['sucesso' => false, 'mensagem' => 'Erro interno do servidor. Tente novamente.'];
    
    if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }
}

// Inicia a sessão
session_start();

// Função para verificar se usuário está logado
function usuarioLogado() {
    return isset($_SESSION['cliente_id']) && !empty($_SESSION['cliente_id']);
}

// Função para fazer logout
function fazerLogout() {
    session_destroy();
    return true;
}

// Processa o login via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        $resultado = ['sucesso' => false, 'mensagem' => 'Preencha todos os campos'];
    } else {
        // Busca o usuário no banco
        // Adapte conforme sua estrutura de tabela de clientes
        $sqlLogin = "SELECT * FROM clientes WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($conexao, $sqlLogin);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado_query = mysqli_stmt_get_result($stmt);
        
        if ($cliente = mysqli_fetch_assoc($resultado_query)) {
            // Verifica a senha (assumindo que está hasheada)
            if (password_verify($senha, $cliente['senha'])) {
                // Login bem-sucedido
                $_SESSION['cliente_id'] = $cliente['id'];
                $_SESSION['cliente_nome'] = $cliente['nome'];
                $_SESSION['cliente_email'] = $cliente['email'];
                
                $resultado = [
                    'sucesso' => true, 
                    'mensagem' => 'Login realizado com sucesso!',
                    'cliente' => [
                        'nome' => $cliente['nome'],
                        'email' => $cliente['email']
                    ]
                ];
            } else {
                $resultado = ['sucesso' => false, 'mensagem' => 'Email ou senha incorretos'];
            }
        } else {
            $resultado = ['sucesso' => false, 'mensagem' => 'Email ou senha incorretos'];
        }
    }
    
    // Retorna resposta JSON para requisições AJAX
    if (isset($_POST['ajax']) && $_POST['ajax'] === '1') {
        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }
    
    // Redireciona se for POST normal
    if ($resultado['sucesso']) {
        header('Location: index.php?login=sucesso');
    } else {
        header('Location: index.php?erro=' . urlencode($resultado['mensagem']));
    }
    exit;
}

// Processa logout
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    fazerLogout();
    header('Location: index.php?logout=sucesso');
    exit;
}
?>