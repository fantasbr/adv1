<?php
// Conectar ao banco de dados MariaDB
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=adv', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    die();
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegar os dados do formulário
    $nome_usuario = $_POST['nome_usuario'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Verificar se o nome de usuário já existe
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE nome_usuario = :nome_usuario");
    $stmt_check->bindParam(':nome_usuario', $nome_usuario);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        echo "Nome de usuário já existe. Por favor, escolha outro.";
        exit();
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar e executar a query SQL para inserir os dados na tabela de usuários
    $sql = "INSERT INTO usuarios (nome_usuario, senha, nome, email) 
            VALUES (:nome_usuario, :senha, :nome, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_usuario', $nome_usuario);
    $stmt->bindParam(':senha', $senha_hash);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);

    try {
        $stmt->execute();
        echo "Usuário cadastrado com sucesso!";

        // Adicionar botão de voltar
        echo '<br><button onclick="window.location.href=\'cadastro_usuario.php\'">Voltar</button>';
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
} else {
    echo "Erro: O formulário não foi submetido corretamente.";
}
?>
