<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
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
        h1 {
            text-align: center; /* Centraliza apenas o título */
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
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            margin-right: 10px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="usuario.php" method="POST">
        <h1>Cadastro de Usuários</h1> <!-- Título centralizado -->
        
        <label for="nome_usuario">Nome de Usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <input type="submit" value="Cadastrar">
        <button type="button" onclick="window.location.href='index.html'">Voltar</button>
    </form>
</body>
</html>
