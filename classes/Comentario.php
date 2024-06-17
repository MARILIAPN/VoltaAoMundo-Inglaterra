<?php
class Comentario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listar() {
        $sql = "SELECT * FROM comentarios";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function aprovar($id) {
        $sql = "SELECT * FROM comentarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $comentario = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $sql = "INSERT INTO comentarios_aprovados (nome, email, comentario) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $comentario['nome'], $comentario['email'], $comentario['comentario']);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM comentarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function reprovar($id) {
        $sql = "DELETE FROM comentarios WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function inserir($nome, $email, $comentario) {
        $sql = "INSERT INTO comentarios (nome, email, comentario, data) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $comentario);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Erro: " . $stmt->error;
        }

        $stmt->close();
    }

    public function listarAprovados() {
        $sql = "SELECT nome, comentario, DATE_FORMAT(data, '%d/%m/%y') as data_formatada FROM comentarios_aprovados ORDER BY data DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
