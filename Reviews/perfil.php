<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo "<script>alert('Você precisa estar logado para acessar esta página!'); window.location.href = 'index.php';</script>";
    exit();
}

$nomeB_servidor = "****";
$nomeB_usuario = "****";
$senhaB = "****";
$nome_B = "****";
//Por ser informações pessoais do meu computador eu tirei as informações de acesso

$conecta = new mysqli($nomeB_servidor, $nomeB_usuario, $senhaB, $nome_B);
if ($conecta->connect_error) {
    die("Conexão falhou: " . $conecta->connect_error . "<br>");
}

$sql = "SELECT * FROM tb_usuarios WHERE id = '" . $_SESSION['usuario'] . "'";
$result = $conecta->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil do Usuário</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/perfil.css">
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
                        <li><a href="jogos.php" class="nav-link px-2 text-white">Jogos</a></li>
                        <li><a href="review.php" class="nav-link px-2 text-white">Criar Review</a></li>
                    </ul>

                    <div class="text-end">
                        <button type="button" class="btn btn-danger" id="logoutBtn" data-toggle="modal" data-target="#confirmLogoutModal">Sair</button>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="perfil-container">
                        <h3 class="text-center">Perfil do Usuário</h3>
                        <hr class="post-separator">
                        <p><strong>Nome de usuário:</strong> <?php echo $row["nome"]; ?></p>
                        <p><strong>Email:</strong> <?php echo $row["email"]; ?></p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger" id="excluirContaBtn">Excluir Conta</button>
                            <button class="btn btn-primary" id="atualizarPerfilBtn">Atualizar Perfil</button>
                        </div>
                        <div id="formAtualizarPerfil" style="display: none;">
                            <form action="src/atualizarPerfil.php" method="post">
                                <div class="form-group">
                                    <label for="email">Novo Email:</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="senha">Nova Senha:</label>
                                    <input type="password" class="form-control" id="senha" name="senha">
                                </div>
                                <div class="form-group">
                                    <label for="nome">Novo Nome:</label>
                                    <input type="text" class="form-control" id="nome" name="nome">
                                </div>
                                <input type="hidden" name="id" value="<?php echo $_SESSION['usuario']; ?>">
                                <button type="submit" class="btn btn-success">Atualizar</button>
                            </form>
                        </div>
                        <div id="historico" class="container">
                            <?php
                            $sqlh = "SELECT * FROM tb_reviews WHERE id_usuario = '" . $_SESSION['usuario'] . "'";
                            $resulta = $conecta->query($sqlh);
                            ?>
                            <h4>Histórico:</h4>
                            <?php
                            while ($row_hist = $resulta->fetch_assoc()) {
                                echo '<div class="review">';
                                echo '<hr class="post-separator">';
                                echo '<h6><strong>' . $row_hist["titulo"] . '</strong></h6>';
                                echo '<p>' . $row_hist["txtreview"] . '</p>';
                                echo '<div class="btn-group">';
                                echo '<button class="btn btn-primary editReviewBtn" data-toggle="modal" data-target="#editReviewModal" data-review-id="' . $row_hist["id"] . '">Atualizar</button>';
                                echo '<button class="btn btn-danger btn-sm deleteReviewBtn" data-review-id="' . $row_hist["id"] . '">Excluir</button>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <p>&copy; 2024 GameView</p>
        </footer>

        <div class="modal fade" id="confirmLogoutModal" tabindex="-1" role="dialog" aria-labelledby="confirmLogoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark text-light rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Tem certeza que deseja sair?</h1>
                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a href="src/logout.php" class="btn btn-danger">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReviewModalLabel">Atualizar Revisão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateReviewForm" method="POST" action="src/updateReview.php">
                            <div class="form-group">
                                <label for="updateTitulo">Título</label>
                                <input type="text" class="form-control" id="updateTitulo" name="updateTitulo">
                            </div>
                            <div class="form-group">
                                <label for="updateTxtReview">Texto da Review</label>
                                <textarea class="form-control" id="updateTxtReview" name="updateTxtReview" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="updateNotaReview">Nota da Review</label>
                                <input type="number" class="form-control" id="updateNotaReview" name="updateNotaReview">
                            </div>
                            <input type="hidden" name="reviewId" id="reviewId" value="">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function () {

                $(".deleteReviewBtn").click(function () {
                    var reviewId = $(this).data("review-id");
                    if (confirm("Tem certeza que deseja excluir esta revisão?")) {
                        window.location.href = "src/excluirReview.php?id=" + reviewId;
                    }
                });

                $(".editReviewBtn").click(function () {
                    var reviewId = $(this).data("review-id");
                    $("#reviewId").val(reviewId);
                });

                $("#excluirContaBtn").click(function () {
                    if (confirm("Tem certeza que deseja excluir sua conta?")) {
                        window.location.href = "src/excluir.php?id=<?php echo $_SESSION['usuario']; ?>";
                    }
                });

                $("#atualizarPerfilBtn").click(function () {
                    $("#formAtualizarPerfil").toggle();
                });
            });
        </script>
    </body>

</html>
