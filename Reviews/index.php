<?php
session_start();

$usuario_logado = isset($_SESSION['usuario']);


?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GamesViews</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
        <link rel="icon" href="img/icon.png">
    </head>
    <body>
        <header class="p-3 text-bg-dark">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="index.php" class="nav-link px-2 text-secondary">Home</a></li>
                        <li><a href="jogos.php" class="nav-link px-2 text-white">Jogos</a></li>
                        <li><a href="review.php" class="nav-link px-2 text-white">Criar Review</a></li>
                    </ul>



                    <div class="text-end">
                        <?php if (!$usuario_logado) { ?>
                            <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#loginModal">Entrar</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#signupModal">Cadastrar</button>
                        <?php } else { ?>
                            <a href="perfil.php" class="nav-link px-2 text-white">Perfil</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </header>
        <?php
        $nomeB_servidor = "****";
        $nomeB_usuario = "****";
        $senhaB = "****";
        $nome_B = "****";
        //Por ser informações pessoais do meu computador eu tirei as informações de acesso

        $conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);

        $sql_revisoes = "SELECT r.id, r.titulo, r.txtreview, r.id_jogo, j.nomejogo, r.nota
                 FROM tb_reviews r
                 INNER JOIN tb_jogos j ON r.id_jogo = j.id";
        $result_revisoes = $conecta->query($sql_revisoes);

        if ($result_revisoes->num_rows > 0) {
            while ($row_revisao = $result_revisoes->fetch_assoc()) {
                ?>
                <div class="container">
                    <div class="post">
                        <h2><?php echo $row_revisao["titulo"]; ?></h2>
                        <?php $nota = $row_revisao["nota"]; ?>
                        <p>
                            <?php echo str_repeat('<img src="img/estrela.png" alt="Estrela" width="20">', $nota); ?>
                        </p>
                        <?php
                        $id_revisao = $row_revisao["id"];
                        $sql_tags = "SELECT t.nome_tag
                     FROM tb_tags t
                     INNER JOIN tb_reviews_tags rt ON t.id = rt.id_tag
                     WHERE rt.id_review = $id_revisao";
                        $result_tags = $conecta->query($sql_tags);
                        if ($result_tags->num_rows > 0) {
                            echo "<p>Tags:";
                            while ($row_tag = $result_tags->fetch_assoc()) {
                                echo " <span class='tag'>" . $row_tag["nome_tag"] . "</span>";
                            }
                            echo "</p>";
                        }
                        ?>
                        <!-- Fim das tags -->
                        <img src="img/<?php echo $row_revisao["id_jogo"]; ?>.jpg" alt="Imagem do post" class="imagem-400x400">
                        <p><?php echo $row_revisao["txtreview"]; ?></p>
                        <div class="post-separator"></div>
                        <h3>Comentários</h3>
                        <div class="post-separator"></div>
                        <?php
                        $sql_comentarios = "SELECT c.txtcomentario, u.nome 
                            FROM tb_comentarios c
                            INNER JOIN tb_usuarios u ON c.id_usuario = u.id
                            WHERE c.id_review = $id_revisao";
                        $result_comentarios = $conecta->query($sql_comentarios);
                        if ($result_comentarios->num_rows > 0) {
                            while ($row_comentario = $result_comentarios->fetch_assoc()) {
                                echo '<p><strong>' . $row_comentario["nome"] . ':</strong> ' . $row_comentario["txtcomentario"] . '</p>';
                            }
                        } else {
                            echo "Sem comentários";
                        }
                        if ($usuario_logado) {
                            ?>
                            <form class="comment" method="POST" action="src/comentario.php">
                                <input type="hidden" name="id_review" value="<?php echo $id_revisao; ?>">
                                <input type="hidden" name="id_usuario" value="<?php echo $usuario_logado; ?>">
                                <div class="form-group">
                                    <textarea name="comentario" class="form-control" placeholder="Adicionar Comentário" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
                            </form>
                        <?php } else { ?>
                            <form class="comment">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Adicionar Comentário" rows="3" onclick="mostrarAlerta('Você precisa estar logado para comentar.')"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="mostrarAlerta('Você precisa estar logado para comentar.')">Enviar</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Sem resultados";
        }
        $conecta->close();
        ?>

        <footer>
            <p>&copy; 2024 GameView</p>
        </footer>
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark text-light rounded-4 shadow">

                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Entrar na conta</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <form action="src/login.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" name="nome" class="form-control rounded-3 bg-dark text-light" id="floatingName" placeholder="Nome">
                                <label for="floatingName">Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="senha" class="form-control rounded-3 bg-dark text-light" id="floatingPassword" placeholder="Senha">
                                <label for="floatingPassword">Senha</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>        
        </div>
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark text-light rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Cadastre-se</h1>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <form method="POST" action="src/cadastrar.php">
                            <div class="form-floating mb-3">
                                <input type="text" name="nome" class="form-control rounded-3 bg-dark text-light" id="floatingName" placeholder="Nome">
                                <label for="floatingName">Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control rounded-3 bg-dark text-light" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="senha" class="form-control rounded-3 bg-dark text-light" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Senha</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>
</html>
