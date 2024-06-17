<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['admin-user'];
    $pass = $_POST['admin-pass'];

    // Prepara a consulta SQL para buscar o usuário e a senha
    $stmt = $conn->prepare("SELECT senha FROM usuarios_admin WHERE usuario = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        
        // Verifica se a senha está correta
        if (hash('sha256', $pass) === $hashed_password) {
            $_SESSION['admin'] = true;
            header('Location: admin-area.php');
        } else {
            echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='admin-login.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='admin-login.html';</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>
