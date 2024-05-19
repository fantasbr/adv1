<?php
// Incluir o arquivo de conexão
include 'db_connection.php';

// Abrir a conexão
$conn = openConnection();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Consulta para obter os dados do cliente
    $sql = "SELECT * FROM clientes WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $cliente = $result->fetch_assoc();
        } else {
            echo "Cliente não encontrado.";
            exit();
        }
        
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
        exit();
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atualizar o cliente no banco de dados
    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $cnpj_cpf = $_POST['cnpj_cpf'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];
    $numero_processo = $_POST['numero_processo'];
    
    $sql = "UPDATE clientes SET nome = ?, cnpj_cpf = ?, rua = ?, numero = ?, bairro = ?, cep = ?, cidade = ?, estado = ?, telefone = ?, numero_processo = ? WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssssi", $nome, $cnpj_cpf, $rua, $numero, $bairro, $cep, $cidade, $estado, $telefone, $numero_processo, $id);
        if ($stmt->execute()) {
            echo "Cliente atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar o cliente: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
    
    // Fechar a conexão
    closeConnection($conn);
    echo "<a href='consultar_clientes.php'>Voltar</a>";
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
    <title>Alterar Cliente</title>
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
        input[type="submit"] {
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
    <form action="alterar_clientes.php" method="post">
        <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?php echo $cliente['nome']; ?>" required>
        <label for="cnpj_cpf">CNPJ/CPF:</label>
        <input type="text" name="cnpj_cpf" id="cnpj_cpf" value="<?php echo $cliente['cnpj_cpf']; ?>" required>
        <label for="rua">Rua:</label>
        <input type="text" name="rua" id="rua" value="<?php echo $cliente['rua']; ?>" required>
        <label for="numero">Número:</label>
        <input type="text" name="numero" id="numero" value="<?php echo $cliente['numero']; ?>" required>
        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" id="bairro" value="<?php echo $cliente['bairro']; ?>" required>
        <label for="cep">CEP:</label>
        <input type="text" name="cep" id="cep" value="<?php echo $cliente['cep']; ?>" required>
        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" id="cidade" value="<?php echo $cliente['cidade']; ?>" required>
        <label for="estado">Estado:</label>
        <input type="text" name="estado" id="estado" value="<?php echo $cliente['estado']; ?>" required>
        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" value="<?php echo $cliente['telefone']; ?>" required>
        <label for="numero_processo">Número do Processo:</label>
        <input type="text" name="numero_processo" id="numero_processo" value="<?php echo $cliente['numero_processo']; ?>" required>
        <input type="submit" value="Salvar">
    </form>
</body>
</html>
