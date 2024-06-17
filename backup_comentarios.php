<?php
require_once 'conexao.php';
require_once 'classes/Comentario.php';

$comentario = new Comentario($conn);
$comentariosAprovados = $comentario->listarAprovados();

$json_data = json_encode($comentariosAprovados, JSON_PRETTY_PRINT);

if (file_put_contents('comentarios_backup.json', $json_data)) {
    $message = 'Backup realizado com sucesso.';
} else {
    $message = 'Falha ao realizar o backup.';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Backup de Comentários</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <h1><?php echo $message; ?></h1>
  <a href="comentarios_backup.json" download>Baixar Backup</a>
  <br>
  <a href="admin-area.php">Voltar à Área do Administrador</a>
</body>
</html>
