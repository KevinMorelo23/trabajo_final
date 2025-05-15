
<?php
class Category {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function all() {
        $res = $this->conn->query("SELECT * FROM categorias");
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($nombre) {
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);
        return $stmt->execute();
    }

    public function update($id, $nombre) {
        $stmt = $this->conn->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
