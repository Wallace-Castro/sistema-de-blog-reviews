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

$id_usuario = $_SESSION['usuario'];

$sqlDeleteTagsRl = "DELETE rt FROM tb_reviews_tags rt INNER JOIN tb_reviews r ON rt.id_review = r.id WHERE r.id_usuario = '$id_usuario'";
if ($conecta->query($sqlDeleteTagsRl) === TRUE) {
    $sqlDeleteCom = "DELETE FROM tb_comentarios WHERE id_usuario = '$id_usuario'";
    if ($conecta->query($sqlDeleteCom) === TRUE) {
        $sqlDeleteReviews = "DELETE FROM tb_reviews WHERE id_usuario = '$id_usuario'";
        if ($conecta->query($sqlDeleteReviews) === TRUE) {
            $sqlDeleteConta = "DELETE FROM tb_usuarios WHERE id = '$id_usuario'";
            if ($conecta->query($sqlDeleteConta) === TRUE) {
                session_destroy();
                echo "<script>alert('Conta excluída com sucesso!'); window.location.href = '../index.php';</script>";
            } else {
                echo "Erro ao excluir a conta: " . $conecta->error;
            }
        } else {
            echo "Erro ao excluir as revisões: " . $conecta->error;
        }
    } else {
        echo "Erro ao excluir os comentários: " . $conecta->error;
    }
} else {
    echo "Erro ao excluir as relações entre revisões e tags: " . $conecta->error;
}

$conecta->close();
