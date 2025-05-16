<?php
class ReportController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    // Reporte: Ventas por fecha
  public function getAllSales($startDate, $endDate) {
    $stmt = $this->conn->prepare("
        SELECT id, created_at, total, payment_method
        FROM sales
        WHERE created_at BETWEEN ? AND ?
        ORDER BY created_at ASC
    ");
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


    // Reporte: Productos más vendidos
    public function getTopProducts($startDate, $endDate, $limit = 10) {
        $stmt = $this->conn->prepare("
            SELECT p.name, 
                   SUM(sp.quantity) as total_quantity, 
                   SUM(sp.quantity * sp.price) as total_revenue
            FROM sale_product sp
            JOIN productos p ON sp.product_id = p.id
            JOIN sales s ON sp.sale_id = s.id
            WHERE s.created_at BETWEEN ? AND ?
            GROUP BY p.id
            ORDER BY total_quantity DESC
            LIMIT ?
        ");
        $stmt->bind_param("ssi", $startDate, $endDate, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
