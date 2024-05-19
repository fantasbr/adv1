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
$sql = "SELECT * FROM usuarios WHERE 1=1";

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
    <title>Consultar Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center; /* Centraliza o título */
        }
        form {
            max-width: 400px;
            margin: 50px auto; /* Centraliza o formulário */
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
        input[type="submit"], button, a.button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
            border-radius: 3px;
        }
        input[type="submit"]:hover, button:hover, a.button:hover {
            background-color: #0056b3;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto; /* Centraliza a tabela */
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Consultar Usuários</h1>
    <form method="post" action="consultar_usuarios.php">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
        
        <input type="submit" value="Pesquisar">
        <button type="button" onclick="window.location.href='index.html'">Voltar</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>ID</th><th>Nome de Usuário</th><th>Nome</th><th>E-mail</th><th>Ações</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"]. "</td>
                    <td>" . $row["nome_usuario"]. "</td>
                    <td>" . $row["nome"]. "</td>
                    <td>" . $row["email"]. "</td>
                    <td>
                        <a href='alterar_usuarios.php?id=" . $row["id"] . "'>Alterar</a> |
                        <a href='excluir_usuarios.php?id=" . $row["id"] . "' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>Nenhum resultado encontrado.</p>";
    }
    ?>
</body>
</html>
