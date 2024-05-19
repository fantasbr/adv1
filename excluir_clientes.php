<?php
// Incluir o arquivo de conexão
include 'db_connection.php';

// Abrir a conexão
$conn = openConnection();

// Verificar se o ID do cliente foi fornecido via GET
if (isset($_GET['id'])) {
    // Obter o ID do cliente da URL
    $id = intval($_GET['id']);
    
    // Consulta SQL para excluir o cliente com o ID fornecido
    $sql = "DELETE FROM clientes WHERE id = ?";
    
    // Preparar a consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincular o ID do cliente ao parâmetro da consulta
        $stmt->bind_param("i", $id);
        
        // Executar a consulta
        if ($stmt->execute()) {
            echo "Cliente excluído com sucesso.";
        } else {
            echo "Erro ao excluir o cliente: " . $conn->error;
        }
        
        // Fechar o statement
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
    
    // Fechar a conexão
    closeConnection($conn);
    
    // Botão de voltar para a página de consulta
    echo '<br><a href="consultar_clientes.php">Voltar</a>';
    
    // Encerrar o script
    exit();
} else {
    echo "ID do cliente não fornecido.";
}

// Fechar a conexão
closeConnection($conn);
?>
