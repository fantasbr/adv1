<?php
// Incluir o arquivo de conexão
include 'db_connection.php';

// Abrir a conexão
$conn = openConnection();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Construir a consulta SQL para excluir o usuário
    $sql = "DELETE FROM usuarios WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Usuário excluído com sucesso.";
        } else {
            echo "Erro ao excluir o usuário: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
} else {
    echo "ID do usuário não fornecido.";
}

// Fechar a conexão
closeConnection($conn);
?>

<a href="consultar_usuarios.php">Voltar</a>
