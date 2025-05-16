<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Model/Provider.php';

class ProviderController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los proveedores
    public function getAll() {
        $result = $this->conn->query("SELECT * FROM proveedores ORDER BY id DESC");
        $proveedores = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $proveedores[] = new Provider(
                    $row['id'],
                    $row['name'],
                    $row['email'],
                    $row['phone'],
                    $row['address'],
                    $row['created_at'],
                    $row['updated_at']
                );
            }
        }

        return $proveedores;
    }

    // Obtener proveedor por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $row = $res->fetch_assoc()) {
            return new Provider(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone'],
                $row['address'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return null;
    }

    // Crear nuevo proveedor
    public function create($name, $email, $phone, $address) {
        $stmt = $this->conn->prepare("INSERT INTO proveedores (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $address);
        return $stmt->execute();
    }

    // Actualizar proveedor existente
    public function update($id, $name, $email, $phone, $address) {
        $stmt = $this->conn->prepare("UPDATE proveedores SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
        return $stmt->execute();
    }

    // Eliminar proveedor
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM proveedores WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
