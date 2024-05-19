<?php
// Incluir o arquivo de conexão
include 'db_connection.php';

// Abrir a conexão
$conn = openConnection();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Consulta para obter os dados do usuário
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
        } else {
            echo "Usuário não encontrado.";
            exit();
        }
        
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
        exit();
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atualizar o usuário no banco de dados
    $id = intval($_POST['id']);
    $nome_usuario = $_POST['nome_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha
    
    $sql = "UPDATE usuarios SET nome_usuario = ?, nome = ?, email = ?, senha = ? WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", $nome_usuario, $nome, $email, $senha, $id); // Corrigido
        if ($stmt->execute()) {
            echo "Usuário atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o usuário: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
    
    // Fechar a conexão
    closeConnection($conn);
    echo "<a href='consultar_usuarios.php'>Voltar</a>";
    exit();
}

// Fechar a conexão
closeConnection($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"], button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="alterar_usuarios.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <label for="nome_usuario">Nome de usuário</label>
        <input type="text" name="nome_usuario" id="nome_usuario" value="<?php echo htmlspecialchars($user['nome_usuario']); ?>" required>
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" value="" required> <!-- Campo de senha corrigido -->
        <input type="submit" value="Salvar">
    </form>
</body>
</html>
