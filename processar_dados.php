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
    // Pegar o CNPJ/CPF do formulário
    $cnpj_cpf = $_POST['cnpj_cpf'];

    // Verificar se o CNPJ/CPF já existe na base de dados
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM clientes WHERE cnpj_cpf = :cnpj_cpf");
    $stmt_check->bindParam(':cnpj_cpf', $cnpj_cpf);
    $stmt_check->execute();
    $count = $stmt_check->fetchColumn();

    if ($count > 0) {
        // Se o CNPJ/CPF já existir, exibir alerta e perguntar ao usuário se deseja continuar cadastrando
        echo "<script>
                if(confirm('O CNPJ/CPF já existe na base de dados. Deseja continuar cadastrando?')) {
                    // Se o usuário confirmar, redirecionar de volta ao formulário
                    window.location.href = 'cadastro_clientes.html';
                } else {
                    // Se o usuário não confirmar, interromper o processo de inserção
                    window.history.back();
                }
            </script>";
        exit(); // Encerrar o script para evitar a execução do restante do código
    }

    // Se o CNPJ/CPF não existir na base de dados, continuar com a inserção do novo registro
    // Pegar os dados do formulário
    $data_cadastro = $_POST['data_cadastro'];
    $nome = $_POST['nome'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];
    $numero_processo = $_POST['numero_processo'];

    // Preparar e executar a query SQL para inserir os dados na tabela
    $sql = "INSERT INTO clientes (data_cadastro, cnpj_cpf, nome, rua, numero, bairro, cep, cidade, estado, telefone, numero_processo) 
            VALUES (:data_cadastro, :cnpj_cpf, :nome, :rua, :numero, :bairro, :cep, :cidade, :estado, :telefone, :numero_processo)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':data_cadastro', $data_cadastro);
    $stmt->bindParam(':cnpj_cpf', $cnpj_cpf);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':rua', $rua);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':numero_processo', $numero_processo);
    $stmt->execute();

    echo "Dados inseridos com sucesso!";
    // Adicionar um botão de voltar
    echo '<br><button onclick="history.go(-1)">Voltar</button>';
} else {
    echo "Erro: O formulário não foi submetido corretamente.";
}
?>
