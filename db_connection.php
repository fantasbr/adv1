<?php
// Função para abrir a conexão com o banco de dados
function openConnection() {
    // Defina suas credenciais do banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "adv";

    // Crie a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifique a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    return $conn;
}

// Função para fechar a conexão com o banco de dados
function closeConnection($conn) {
    $conn->close();
}
?>
