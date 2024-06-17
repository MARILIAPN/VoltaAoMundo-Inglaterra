<?php
session_start();
require_once 'conexao.php';
require_once 'classes/Comentario.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.html');
    exit();
}

$comentario = new Comentario($conn);
$lista = $comentario->listar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aprovar'])) {
        $id = $_POST['id'];
        $comentario->aprovar($id);
    } elseif (isset($_POST['reprovar'])) {
        $id = $_POST['id'];
        $comentario->reprovar($id);
    } elseif (isset($_POST['logout'])) {
        session_destroy();
        header('Location: admin-login.html');
        exit();
    } elseif (isset($_POST['cadastrar'])) {
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $hashed_senha = hash('sha256', $senha);

        $stmt = $conn->prepare("INSERT INTO usuarios_admin (nome, usuario, senha) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $usuario, $hashed_senha);
        if ($stmt->execute()) {
            echo "<script>alert('Novo administrador cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar novo administrador.');</script>";
        }
        $stmt->close();
    }
    header('Location: admin-area.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Administrador</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin-style.css">
    <script>
        function openPopup() {
            document.getElementById('popupForm').classList.add('admin-popup-open');
            document.getElementById('popupOverlay').classList.add('admin-popup-overlay-open');
        }

        function closePopup() {
            document.getElementById('popupForm').classList.remove('admin-popup-open');
            document.getElementById('popupOverlay').classList.remove('admin-popup-overlay-open');
        }
    </script>
</head>
<body>
    <div class="admin-container">
        <h1>Área do Administrador - Gerenciar Comentários</h1>
        <form method="post" style="text-align: right;">
            <button type="submit" name="logout" class="admin-btn admin-btn-danger admin-btn-logout">Sair</button>
        </form>
        <button onclick="openPopup()" class="admin-btn admin-btn-success admin-btn-cadastrar">Cadastrar Novo Administrador</button>
      
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $linha) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($linha['nome']); ?></td>
                        <td><?php echo htmlspecialchars($linha['email']); ?></td>
                        <td><?php echo htmlspecialchars($linha['comentario']); ?></td>
                        <td><?php echo htmlspecialchars($linha['data']); ?></td>
                        <td>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $linha['id']; ?>">
                                <button type="submit" name="aprovar" class="admin-btn admin-btn-success">Aprovar</button>
                                <button type="submit" name="reprovar" class="admin-btn admin-btn-danger">Reprovar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="popupOverlay" class="admin-popup-overlay" onclick="closePopup()"></div>
    <div id="popupForm" class="admin-popup">
        <h2>Cadastrar Novo Administrador</h2>
        <form method="post">
            <div class="mb-3">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" name="cadastrar" class="admin-btn admin-btn-success">Cadastrar</button>
            <button type="button" onclick="closePopup()" class="admin-btn admin-btn-danger">Cancelar</button>
        </form>
        
    </div>
    <div class="admin-container">
        <form action="backup_comentarios.php" method="post" style="text-align: right;">
            <button type="submit">Fazer Backup dos Comentários Aprovados</button>
        </form>
    </div>
</body>
</html>
