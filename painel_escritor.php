<?php
session_start();

include('conexao.php');  


if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 'escritor') {
    header("Location: index.php");
    exit;
}


$noticias = [];
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['consulta'])) {
    $consulta = $mysqli->real_escape_string($_GET['consulta']);
    $sql_consulta = "SELECT * FROM noticias WHERE titulo LIKE '%$consulta%' ORDER BY id DESC";
    $result = $mysqli->query($sql_consulta);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $noticias[] = $row;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $titulo = $mysqli->real_escape_string($_POST['titulo']);
    $conteudo = $mysqli->real_escape_string($_POST['conteudo']);

  
    $imagem_nome = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];
    $imagem_error = $_FILES['imagem']['error'];

    if ($imagem_error === 0) {
        $imagem_destino = "uploads/" . basename($imagem_nome);

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (move_uploaded_file($imagem_tmp, $imagem_destino)) {
            $sql = "INSERT INTO noticias (titulo, conteudo, imagem, id_usuarios, status) 
                    VALUES ('$titulo', '$conteudo', '$imagem_destino', '".$_SESSION['id']."', 'pendente')";

            if ($mysqli->query($sql) === TRUE) {
                echo "<p style='color: green;'>Notícia submetida com sucesso! Aguardando aprovação.</p>";
            } else {
                echo "<p style='color: red;'>Erro ao submeter notícia: " . $mysqli->error . "</p>";
            }
        } else {
            echo "<p style='color: red;'>Erro ao fazer upload da imagem.</p>";
        }
    } else {
        echo "<p style='color: red;'>Erro ao enviar imagem.</p>";
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escrever Notícia</title>
    <link rel= "stylesheet" href = "styleescritor.css">
</head>
<body>

<header>
    <h1>Escritor adicionar nova  Notícia</h1>
</header>

<div class="container">
   
    <form action="painel_escritor.php" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título da Notícia:</label>
        <input type="text" id="titulo" name="titulo" required><br>

        <label for="conteudo">Conteúdo da Notícia:</label>
        <textarea id="conteudo" name="conteudo" rows="5" required></textarea><br>

        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*"><br>

        <button type="submit">Adicionar Notícia</button>
    </form>

 
    <div class="search-container">
        <form action="painel_escritor.php" method="GET">
            <label for="consulta">Consultar Notícias:</label>
            <input type="text" id="consulta" name="consulta" placeholder="Pesquisar por título..." required>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <?php if (!empty($noticias)): ?>
    <div class="news-list">
        <?php foreach ($noticias as $noticia): ?>
        <div class="news-item">
            <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
            <p><strong>Conteúdo:</strong> <?php echo nl2br(htmlspecialchars($noticia['conteudo'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($noticia['status']); ?></p>
            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia" style="max-width: 100%; height: auto;">
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <a href="index.php" class="back-btn">Voltar para pagina de noticias</a>
</div>

</body>
</html>

