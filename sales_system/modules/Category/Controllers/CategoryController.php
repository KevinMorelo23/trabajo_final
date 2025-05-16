<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Model/Category.php';

class CategoryController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getCategories() {
        $result = $this->conn->query("SELECT * FROM categorias");
        $categorias = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categorias[] = new Category(
                    $row['id'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['fecha_creacion'],
                    $row['estado']
                );
            }
        }
        return $categorias;
    }
    
public function getCategoryById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            return new Category(
                $row['id'],
                $row['nombre'],
                $row['descripcion'],
                $row['fecha_creacion'],
                $row['estado']
            );
        }
        return null;
    }

    public function createCategory($nombre, $descripcion, $estado) {
        $fecha_creacion = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion, fecha_creacion, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $descripcion, $fecha_creacion, $estado);
        return $stmt->execute();
    }

    public function updateCategory($id, $nombre, $descripcion, $estado) {
        $stmt = $this->conn->prepare("UPDATE categorias SET nombre = ?, descripcion = ?, estado = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nombre, $descripcion, $estado, $id);
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // Puedes agregar más funciones aquí como create, update, delete, etc.
}