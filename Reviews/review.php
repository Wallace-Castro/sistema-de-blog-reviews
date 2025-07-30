<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página!'); window.location.href = 'index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GamesViews</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/review.css">
        <link rel="icon" href="img/icon.png">
    </head>
    <body>
        <header class="p-3 text-bg-dark">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                        <use xlink:href="#bootstrap"></use>
                        </svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
                        <li><a href="index.php" class="nav-link px-2 text-white">Jogos</a></li>
                        <li><a href="review.php" class="nav-link px-2 text-white">Criar Review</a></li>
                        <a href="perfil.php" class="nav-link px-2 text-white">Perfil</a>
                    </ul>
                </div>
            </div>
        </header>

        <div class="container">
            <h2 class="text-center mb-4">Crie sua Review</h2>
            <form method="post" action="src/cadastrarReview.php">
                <div class="form-group">
                    <label for="gameSelect">Escolha o jogo:</label>
                    <select class="form-control" id="gameSelect" name="id_jogo">
                        <?php
                        
                        $nomeB_servidor = "****";
                        $nomeB_usuario = "****";
                        $senhaB = "****";
                        $nome_B = "****";
                        //Por ser informações pessoais do meu computador eu tirei as informações de acesso

                        $conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);

                        $sql_jogos = "SELECT id, nomejogo FROM tb_jogos";
                        $result_jogos = $conecta->query($sql_jogos);
                        if ($result_jogos->num_rows > 0) {
                            while ($row_jogo = $result_jogos->fetch_assoc()) {
                                echo '<option value="' . $row_jogo["id"] . '">' . $row_jogo["nomejogo"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tagsSelect">Escolha as tags(Segura Ctrl e click pra selecionar mais de uma):</label>
                    <select class="form-control" id="tagsSelect" name="tags[]" multiple>
                        <?php
                        $sql_tags = "SELECT id, nome_tag FROM tb_tags";
                        $result_tags = $conecta->query($sql_tags);
                        if ($result_tags->num_rows > 0) {
                            while ($row_tag = $result_tags->fetch_assoc()) {
                                echo '<option value="' . $row_tag["id"] . '">' . $row_tag["nome_tag"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gameTitle">Título do Jogo:</label>
                    <input type="text" class="form-control" id="gameTitle" name="titulo" placeholder="Insira o título do jogo">
                </div>
                <div class="form-group">
                    <label for="reviewText">Sua Review:</label>
                    <textarea class="form-control" id="reviewText" name="txtreview" rows="5" placeholder="Escreva sua review aqui"></textarea>
                </div>
                <div class="form-group">
                    <label for="reviewNote">Sua Nota de 1 a 5:</label>
                    <textarea class="form-control" id="reviewNote" name="nota" placeholder="Não coloque numero quebrado como 4.9"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
