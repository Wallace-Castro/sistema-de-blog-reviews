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

$comentario = $_POST['comentario'];
$id_review = $_POST['id_review'];
$nome_usuario = $_SESSION['usuario'];

$sql_usuario = "SELECT id FROM tb_usuarios WHERE nome = '$nome_usuario'";
$result_usuario = $conecta->query($sql_usuario);

if ($result_usuario->num_rows > 0) {
    $row_usuario = $result_usuario->fetch_assoc();
    $id_usuario = $row_usuario['id'];

    if (!empty($comentario)) {
        $sql = "INSERT INTO tb_comentarios (id_review, id_usuario, txtcomentario) VALUES ('$id_review', '$id_usuario', '$comentario')";
        if ($conecta->query($sql) === TRUE) {
            echo '<script>alert("Registro inserido com sucesso!");';
            echo 'window.location.href = "../index.php";</script>';
        } else {
            echo '<script>alert("Erro em fazer o cadastro");';
            echo "Erro ao inserir registro: " . $conecta->error;
            echo 'window.location.href = "../index.php";</script>';
        }
    } else {
        echo '<script>alert("O comentario não pode estar vazio");';
        echo 'window.location.href = "../index.php";</script>';
    }
} else {
    echo "Usuário não encontrado.";
}