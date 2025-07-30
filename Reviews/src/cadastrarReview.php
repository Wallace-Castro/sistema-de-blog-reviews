<?php

session_start();

$nomeB_servidor = "****";
$nomeB_usuario = "****";
$senhaB = "****";
$nome_B = "****";
//Por ser informações pessoais do meu computador eu tirei as informações de acesso

$conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);

if ($conecta->connect_error) {
    die("Conexão falhou: " . $conecta->connect_error);
}

$idU = $_SESSION['usuario'];
$idJ = $_POST["id_jogo"];
$titulo = $_POST["titulo"];
$txt = $_POST["txtreview"];
$nota = $_POST["nota"];
$tags = $_POST["tags"];

$sql_review = "INSERT INTO tb_reviews (id_usuario, id_jogo, titulo, txtreview, nota) VALUES ('$idU', '$idJ', '$titulo', '$txt', '$nota')";

if ($conecta->query($sql_review) === TRUE) {
    $id_revisao = $conecta->insert_id;

    foreach ($tags as $tag_id) {
        $sql_relacao = "INSERT INTO tb_reviews_tags (id_review, id_tag) VALUES ('$id_revisao', '$tag_id')";
        $conecta->query($sql_relacao);
    }

    echo '<script>alert("Review e tags relacionadas inseridas com sucesso!");';
    echo 'window.location.href = "../index.php";</script>';
} else {
    echo '<script>alert("Erro em fazer o cadastro");';
    echo 'window.location.href = "../index.php";</script>';
}

