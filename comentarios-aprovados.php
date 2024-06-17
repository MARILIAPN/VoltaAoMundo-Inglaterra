<?php
require_once 'conexao.php';

// Consulta para buscar os comentários aprovados
$sql = "SELECT nome, comentario, data  FROM comentarios_aprovados";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<h3>" . htmlspecialchars($row['nome']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
        echo "<span>" . htmlspecialchars($row['data']) . "</span>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum comentário aprovado ainda.</p>";
}

$conn->close();
?>

