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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $reviewId = $_GET['id'];

    $sqlDeleteComments = "DELETE FROM tb_comentarios WHERE id_review = '$reviewId'";
    if ($conecta->query($sqlDeleteComments) === TRUE) {
        $sqlDeleteTags = "DELETE FROM tb_reviews_tags WHERE id_review = '$reviewId'";
        if ($conecta->query($sqlDeleteTags) === TRUE) {
            $sqlDeleteReview = "DELETE FROM tb_reviews WHERE id = '$reviewId' AND id_usuario = '{$_SESSION['usuario']}'";
            if ($conecta->query($sqlDeleteReview) === TRUE) {
                echo "<script>alert('Revisão excluída com sucesso!'); window.location.href = '../perfil.php';</script>";
            } else {
                echo "Erro ao excluir a revisão: " . $conecta->error;
            }
        } else {
            echo "Erro ao excluir as relações entre tags e revisão: " . $conecta->error;
        }
    } else {
        echo "Erro ao excluir os comentários: " . $conecta->error;
    }
}

