<?php
// Incluir o arquivo de conexão
include 'db_connection.php';

// Abrir a conexão
$conn = openConnection();

// Inicializar variáveis de filtro
$id = '';
$nome = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter valores do formulário de pesquisa
    $id = $_POST['id'];
    $nome = $_POST['nome'];
}

// Construir a consulta SQL com base nos filtros
$sql = "SELECT * FROM clientes WHERE 1=1";

if (!empty($id)) {
    $sql .= " AND id = " . intval($id);
}

if (!empty($nome)) {
    $sql .= " AND nome LIKE '%" . $conn->real_escape_string($nome) . "%'";
}

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto; /* Centraliza o conteúdo */
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto; /* Centraliza o formulário */
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: calc(100% - 22px); /* Ajusta a largura para compensar o padding */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"], button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 3px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        .actions a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultar Clientes</h1>
        <form method="post" action="consultar_clientes.php">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
            
            <input type="submit" value="Pesquisar">
            <button type="button" onclick="window.location.href='index.html'">Voltar</button>
        </form>

        <?php
        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Data de Cadastro</th><th>CNPJ/CPF</th><th>Nome</th><th>Rua</th><th>Número</th><th>Bairro</th><th>CEP</th><th>Cidade</th><th>Estado</th><th>Telefone</th><th>Número do Processo</th><th>Ações</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["data_cadastro"]. "</td>
                        <td>" . $row["cnpj_cpf"]. "</td>
                        <td>" . $row["nome"]. "</td>
                        <td>" . $row["rua"]. "</td>
                        <td>" . $row["numero"]. "</td>
                        <td>" . $row["bairro"]. "</td>
                        <td>" . $row["cep"]. "</td>
                        <td>" . $row["cidade"]. "</td>
                        <td>" . $row["estado"]. "</td>
                        <td>" . $row["telefone"]. "</td>
                        <td>" . $row["numero_processo"]. "</td>
                        <td class='actions'>
                            <a href='alterar_clientes.php?id=" . $row["id"] . "'>Alterar</a>
                            <a href='excluir_clientes.php?id=" . $row["id"] . "' onclick='return confirm(\"Tem certeza que deseja excluir este cliente?\")'>Excluir</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='error-message'>Nenhum resultado encontrado.</p>";
        }

        // Fechar a conexão
        closeConnection($conn);
        ?>
    </div>
</body>
</html>

