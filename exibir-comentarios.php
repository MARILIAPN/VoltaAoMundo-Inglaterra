<?php
require_once 'conexao.php';
require_once 'classes/Comentario.php';

header('Content-Type: application/json');

$comentario = new Comentario($conn);
$comentariosAprovados = $comentario->listarAprovados();

echo json_encode($comentariosAprovados);

$conn->close();
?>
