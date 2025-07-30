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

$reviewId = $_POST['reviewId'];
$updateTitulo = $_POST['updateTitulo'];
$updateTxtReview = $_POST['updateTxtReview'];
$nota = $_POST['updateNotaReview'];

if ($nota < 1 || $nota > 5) {
    echo "<script>alert('A nota deve estar entre 1 e 5!'); window.location.href = '../perfil.php';</script>";
} else {

    $updateTitulo = $conecta->real_escape_string($updateTitulo);
    $updateTxtReview = $conecta->real_escape_string($updateTxtReview);

    $sql = "UPDATE tb_reviews SET titulo = '$updateTitulo', txtreview = '$updateTxtReview', nota ='$nota' WHERE id = $reviewId";

    if ($conecta->query($sql) === TRUE) {
        echo "<script>alert('Review atualizado com sucesso!'); window.location.href = '../perfil.php';</script>";
        exit();
    } else {
        echo "Erro ao atualizar a revisão: " . $conecta->error;
        header("Location: ../perfil.php");
    }

    $conecta->close();
}