<?php

session_start();

$nomeB_servidor = "****";
$nomeB_usuario = "****";
$senhaB = "****";
$nome_B = "****";
//Por ser informações pessoais do meu computador eu tirei as informações de acesso

$conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);
if ($conecta->connect_error) {
    die("Conexão falhou: " . $conecta->connect_error . "<br>");
}

$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];

$sql_verificar = "SELECT * FROM tb_usuarios WHERE email='$email'";
$resultado = $conecta->query($sql_verificar);
if ($resultado->num_rows > 0) {
    echo '<script>alert("Já existe uma conta com esse email.");';
    echo 'window.location.href = "index.php";</script>';
} else {
    $sql = "INSERT INTO tb_usuarios(nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if ($conecta->query($sql) === TRUE) {

        $sql = "SELECT * FROM tb_usuarios WHERE nome = '$nome' AND senha = '$senha'";
        $result = $conecta->query($sql);
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $row['id'];
        echo '<script>alert("Registro inserido com sucesso!");';
        echo 'window.location.href = "../index.php";</script>';
    } else {
        echo '<script>alert("Erro em fazer o cadastro");';
        echo 'window.location.href = "../index.php";</script>';
    }
}
$conecta->close();

