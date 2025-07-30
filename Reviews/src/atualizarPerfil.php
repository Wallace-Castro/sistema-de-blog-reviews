<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $novoEmail = $_POST['email'];
    $novaSenha = $_POST['senha'];
    $novoNome = $_POST['nome'];

    $nomeB_servidor = "****";
    $nomeB_usuario = "****";
    $senhaB = "****";
    $nome_B = "****";
    //Por ser informações pessoais do meu computador eu tirei as informações de acesso

    $conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);
    if ($conecta->connect_error) {
        die("Conexão falhou: " . $conecta->connect_error . "<br>");
    }

    $sql = "UPDATE tb_usuarios SET email='$novoEmail', senha='$novaSenha', nome='$novoNome' WHERE id='$id'";

    if ($conecta->query($sql) === TRUE) {
        echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href = '../perfil.php';</script>";
    } else {
        echo "Erro ao atualizar o perfil: " . $conecta->error;
    }

    $conecta->close();
}
