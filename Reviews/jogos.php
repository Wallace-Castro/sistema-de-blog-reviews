<?php
session_start();

$usuario_logado = isset($_SESSION['usuario']);

function mostrarAlerta($mensagem) {
    echo "<script>alert('$mensagem');</script>";
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

$sql_jogos = "SELECT j.id, j.nomejogo, GROUP_CONCAT(DISTINCT p.nomeplataforma SEPARATOR ', ') AS plataformas, GROUP_CONCAT(DISTINCT c.nomecategoria SEPARATOR ', ') AS categorias, IFNULL(AVG(r.nota), 0) AS media_nota
              FROM tb_jogos j
              LEFT JOIN tb_jogos_plataformas jp ON j.id = jp.id_jogo
              LEFT JOIN tb_plataformas p ON jp.id_plataforma = p.id
              LEFT JOIN tb_jogos_categorias jc ON j.id = jc.id_jogo
              LEFT JOIN tb_categorias c ON jc.id_categoria = c.id
              LEFT JOIN tb_reviews r ON j.id = r.id_jogo
              GROUP BY j.id, j.nomejogo
              ORDER BY media_nota DESC";

$result_jogos = $conecta->query($sql_jogos);

$conecta->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Meu Site de Review de Jogos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/jogos.css">
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

                  
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <?php
                if ($result_jogos->num_rows > 0) {
                    while ($row_jogo = $result_jogos->fetch_assoc()) {
                        ?>
                        <div class="col-md-4">
                            <div class="game-card">
                                <img src="img/<?php echo $row_jogo["id"]; ?>.jpg" alt="<?php echo $row_jogo["nomejogo"]; ?>">
                                <div class="game-details p-3">
                                    <h4><?php echo $row_jogo["nomejogo"]; ?></h4>
                                    <div class="game-info">
                                        <p><strong>Média da Nota:</strong> <?php echo number_format($row_jogo["media_nota"], 1); ?></p>
                                        <p><strong>Plataforma:</strong> <?php echo $row_jogo["plataformas"]; ?></p>
                                        <p><strong>Categoria:</strong> <?php echo $row_jogo["categorias"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "Sem resultados";
                }
                ?>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
