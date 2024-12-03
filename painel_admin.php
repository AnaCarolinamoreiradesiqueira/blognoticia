<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['acao'], $_GET['id'])) {
    $acao = $_GET['acao'];
    $id_noticia = $_GET['id'];

    if ($acao == 'aprovar') {
        $status = 'aprovado';
    } elseif ($acao == 'rejeitar') {
        $status = 'rejeitado';
    } else {
        $status = null;
    }

    if ($status) {
        $sql = "UPDATE noticias SET status = '$status' WHERE id = $id_noticia";
        if ($mysqli->query($sql) === TRUE) {
            echo "<div class='message success'>Notícia $status com sucesso!</div>";
        } else {
            echo "<div class='message error'>Erro ao atualizar o status da notícia: " . $mysqli->error . "</div>";
        }
    }
}

$sql = "SELECT id, titulo, conteudo, imagem, status FROM noticias WHERE status = 'pendente' ORDER BY id DESC";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Aprovar Notícias</title>
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
    <div class="container">
        <h1>Painel Administrativo - Aprovação de Notícias</h1>

        <h2>Notícias Pendentes</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Conteúdo</th>
                        <th>Imagem</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['conteudo'])); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem da Notícia"></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td class="actions">
                                <a href="?acao=aprovar&id=<?php echo $row['id']; ?>">Aprovar</a> | 
                                <a href="?acao=rejeitar&id=<?php echo $row['id']; ?>">Rejeitar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há notícias pendentes para aprovação.</p>
        <?php endif; ?>

        <a href="logout.php" class="logout-btn">Sair</a>
        <a href="index.php" class="back-btn">Pagina de noticias</a>
    </div>
</body>
</html>

<?php
$mysqli->close();
?>


