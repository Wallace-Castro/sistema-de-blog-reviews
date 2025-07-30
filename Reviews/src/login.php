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
$senha = $_POST["senha"];

$sql = "SELECT id FROM tb_usuarios WHERE nome = '$nome' AND senha = '$senha'";

$result = $conecta->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['usuario'] = $row['id'];
    echo '<script>alert("Login feito com sucesso");';
    echo 'window.location.href = "../index.php";</script>';
} else {
    echo '<script>alert("Erro em fazer login confira senha e nome");';
    echo 'window.location.href = "../index.php";</script>';
}

$conecta->close();

