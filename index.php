<?php
session_start();
include('conexao.php');


if(isset($_POST['email']) || isset($_POST['senha']) || isset($_POST['tipo_usuario'])) {
    if(strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else if(!isset($_POST['tipo_usuario']) || ($_POST['tipo_usuario'] != 'admin' && $_POST['tipo_usuario'] != 'escritor')) {
        echo "Selecione um tipo de usuário";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        $tipo_usuario = $_POST['tipo_usuario'];

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha' AND tipo_usuario = '$tipo_usuario'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            if($_SESSION['tipo_usuario'] == 'admin') {
                header("Location: painel_admin.php");  
            } else if($_SESSION['tipo_usuario'] == 'escritor') {
                header("Location: painel_escritor.php"); 
            }

        } else {
            echo "Falha ao logar! E-mail, senha ou tipo de usuário incorretos";
        }
    }
}


$sql_noticias = "SELECT * FROM noticias WHERE status = 'aprovado' ORDER BY id DESC";
$sql_query_noticias = $mysqli->query($sql_noticias) or die("Erro ao buscar notícias: " . $mysqli->error);

$noticias = [];
while($noticia = $sql_query_noticias->fetch_assoc()) {
    $noticias[] = $noticia;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Notícias</title>
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
  
    <div class="news-container">
        <h2>Diario de Notícias</h2>
        <?php if(count($noticias) > 0): ?>
            <ul>
                <?php foreach($noticias as $noticia): ?>
                    <li class="news-item">
                        <div class="news-image">
                            <img src="<?php echo htmlspecialchars($noticia['imagem']); ?>" alt="Imagem da notícia">
                        </div>
                        <div class="news-details">
                            <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($noticia['conteudo'])); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nenhuma notícia aprovada encontrada.</p>
        <?php endif; ?>

        
        <button class="login-btn" onclick="toggleLoginForm()">Entrar</button>

        
        <div class="login-overlay" id="loginOverlay">
            <div class="login-container">
                <div class="logo">
                    <h1>Notícias Online</h1>
                    <p>Entre para gerenciar o conteúdo</p>
                </div>
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" required>
                    </div>
                    <div class="input-group tipo-usuario">
                        <label>Tipo de Usuário</label><br>
                        <input type="radio" name="tipo_usuario" value="admin" required> Administrador
                        <input type="radio" name="tipo_usuario" value="escritor" required> Escritor
                    </div>
                    <button type="submit">Entrar</button>
                  
                    <button type="button" class="cancel-btn" onclick="toggleLoginForm()">Cancelar</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        
        function toggleLoginForm() {
            const loginOverlay = document.getElementById('loginOverlay');
            loginOverlay.style.display = (loginOverlay.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</body>
</html>






