<?php
require_once __DIR__ . '/../Model/Promociones.php';

class PromocionesController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getAllPromotions() {
    $result = $this->conn->query("SELECT * FROM promociones ORDER BY start_date DESC");
    $promotions = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $promotions[] = new Promotion(
                $row['id'],
                $row['product_id'],
                $row['discount_percent'],
                $row['start_date'],
                $row['end_date'],
                $row['created_at'],
                $row['updated_at']
            );
        }
    }
    return $promotions;
}


    // Crear una nueva promoción
    public function createPromotion($product_id, $discount_percent, $start_date, $end_date = null) {
        $stmt = $this->conn->prepare("INSERT INTO promociones (product_id, discount_percent, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $product_id, $discount_percent, $start_date, $end_date);
        $stmt->execute();
        $stmt->close();
    }

    // Obtener todas las promociones de un producto
    public function getPromotionsByProduct($product_id) {
        $stmt = $this->conn->prepare("SELECT * FROM promociones WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $promotions = [];
        while ($row = $result->fetch_assoc()) {
            $promotions[] = new Promotion(
                $row['id'],
                $row['product_id'],
                $row['discount_percent'],
                $row['start_date'],
                $row['end_date'],
                $row['created_at'],
                $row['updated_at']
            );
        }
        $stmt->close();
        return $promotions;
    }

    // Obtener promoción activa (si existe) para un producto en la fecha actual
    public function getActivePromotion($product_id) {
        $today = date('Y-m-d');
        $stmt = $this->conn->prepare("SELECT * FROM promociones WHERE product_id = ? AND start_date <= ? AND (end_date IS NULL OR end_date >= ?)");
        $stmt->bind_param("iss", $product_id, $today, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $promotion = null;
        if ($row = $result->fetch_assoc()) {
            $promotion = new Promotion(
                $row['id'],
                $row['product_id'],
                $row['discount_percent'],
                $row['start_date'],
                $row['end_date'],
                $row['created_at'],
                $row['updated_at']
            );
        }
        $stmt->close();
        return $promotion;
    }

    // Opcional: actualizar promoción
    public function updatePromotion($id, $discount_percent, $start_date, $end_date = null) {
        $stmt = $this->conn->prepare("UPDATE promociones SET discount_percent = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("dssi", $discount_percent, $start_date, $end_date, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Opcional: eliminar promoción
    public function deletePromotion($id) {
        $stmt = $this->conn->prepare("DELETE FROM promociones WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
