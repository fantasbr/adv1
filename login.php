<?php
session_start();

// Configurações do banco de dados
$host = 'localhost';
$db = 'adv';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO($dsn, $user, $pass);
    // Configurar o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter as entradas do usuário e sanitizá-las
    $username = filter_input(INPUT_POST, 'nome_usuario', FILTER_SANITIZE_STRING);
    $password = $_POST['password']; // Senha não precisa de sanitização, mas será verificada de outra forma

    // Preparar e executar a consulta SQL para buscar o usuário
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome_usuario = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário foi encontrado e se a senha está correta
    if ($user && password_verify($password, $user['senha'])) {
        // Autenticação bem-sucedida
        $_SESSION['nome_usuario'] = $user['nome_usuario'];
        header("Location: index.html"); // Redirecionar para a página inicial
        exit();
    } else {
        // Autenticação falhou
        $error_message = "Credenciais inválidas. Por favor, tente novamente.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="POST">
        <h2 style="text-align: center; color: #007bff;">Login</h2>
        <label for="nome_usuario">Nome de Usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" required>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Entrar</button>
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
