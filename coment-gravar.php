<?php
require_once 'conexao.php';
require_once 'classes/Comentario.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['txtnome'];
    $email = $_POST['txtemail'];
    $comentario = $_POST['txtcomentario'];

    // Cria uma instância da classe Comentario
    $comentarioObj = new Comentario($conn);

    // Tenta inserir o comentário no banco de dados
    $resultado = $comentarioObj->inserir($nome, $email, $comentario);

    // Verifica o resultado da inserção
    if ($resultado === true) {
        echo "<script>alert('Comentário salvo com sucesso!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Erro: " . $resultado . "'); window.location.href='index.html';</script>";
    }
}

// Fecha a conexão
$conn->close();
?>
