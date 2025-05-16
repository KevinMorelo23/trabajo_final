<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Model/Sale.php';

class SaleController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Listar todas las ventas
    public function getAllSales() {
        $query = "SELECT * FROM sales ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        $sales = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $sales[] = $row;
            }
        }
        return $sales;
    }
    public function updateSale($id, $total, $payment_method, $payment_details, $status, $user_id, $shipping_name, $shipping_address, $shipping_city, $shipping_phone) {
    $sql = "UPDATE sales SET
                total = ?,
                payment_method = ?,
                payment_details = ?,
                status = ?,
                user_id = ?,
                shipping_name = ?,
                shipping_address = ?,
                shipping_city = ?,
                shipping_phone = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        // Manejo del error de prepare
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }

    // Vincular parámetros (tipos: d=double, s=string, i=int)
    // Ajusta los tipos según corresponda:
    $stmt->bind_param(
        "dssssisssi",
        $total,
        $payment_method,
        $payment_details,
        $status,
        $user_id,
        $shipping_name,
        $shipping_address,
        $shipping_city,
        $shipping_phone,
        $id
    );

    $stmt->execute();

    return $stmt->affected_rows > 0;
}

    public function getSaleById($id) {
    $query = "SELECT * FROM sales WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_object(); // o fetch_assoc() si prefieres array
}
public function getProductsBySaleId($saleId) {
    $query = "SELECT sp.quantity, sp.price, p.name 
              FROM sale_product sp
              JOIN productos p ON sp.product_id = p.id
              WHERE sp.sale_id = ?";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $saleId);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}

    // Listar todos los productos disponibles para el formulario
    public function getAllProducts() {
        $query = "SELECT id, name, price, stock FROM productos WHERE stock > 0";
        $result = $this->conn->query($query);
        $products = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    // Crear venta y guardar productos vendidos (con validación stock)
    public function createSale($data,$paymentData) {
        // $data debe contener:
        // total, payment_method, payment_details, status, user_id, shipping_name, shipping_address, shipping_city, shipping_phone
        // y también un array de productos con product_id y quantity

        $this->conn->begin_transaction();

        try {
            // 1. Insertar la venta
            $stmt = $this->conn->prepare("INSERT INTO sales (total, payment_method, payment_details, status, user_id, shipping_name, shipping_address, shipping_city, shipping_phone, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param(
                'dssssssss',
                $data['total'],
                $data['payment_method'],
                $data['payment_details'],
                $data['status'],
                $data['user_id'],
                $data['shipping_name'],
                $data['shipping_address'],
                $data['shipping_city'],
                $data['shipping_phone']
            );
            $stmt->execute();
            $sale_id = $stmt->insert_id;

            // 2. Validar stock y guardar productos vendidos
            foreach ($data['products'] as $prod) {
                $product_id = $prod['product_id'];
                $quantity = $prod['quantity'];

                // Consultar stock actual
                $result = $this->conn->query("SELECT stock, price FROM productos WHERE id = $product_id FOR UPDATE");
                $product = $result->fetch_assoc();

                if (!$product) {
                    throw new Exception("Producto ID $product_id no encontrado.");
                }

                if ($quantity > $product['stock']) {
                    throw new Exception("No hay suficiente stock para el producto ID $product_id. Stock disponible: {$product['stock']}");
                }

                // Guardar en sale_product
                $price = $product['price'];
                $stmtProd = $this->conn->prepare("INSERT INTO sale_product (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
                $stmtProd->bind_param('iiid', $sale_id, $product_id, $quantity, $price);
                $stmtProd->execute();
                $saleId = $this->conn->insert_id; // Obtener el ID de la venta recién creada

        // 2. Insertar pago relacionado
        $stmtPayment = $this->conn->prepare("INSERT INTO payments 
            (sale_id, payment_method, reference_number, card_number, cardholder_name, card_expiry, bank_name, account_number, amount, status, amount_tendered, `change`, installments) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmtPayment->bind_param(
            "issssssssdddi",
            $saleId,
            $paymentData['payment_method'],
            $paymentData['reference_number'],
            $paymentData['card_number'],
            $paymentData['cardholder_name'],
            $paymentData['card_expiry'],
            $paymentData['bank_name'],
            $paymentData['account_number'],
            $paymentData['amount'],
            $paymentData['status'],
            $paymentData['amount_tendered'],
            $paymentData['change'],
            $paymentData['installments']
        );

                // Actualizar stock
                $new_stock = $product['stock'] - $quantity;
                $this->conn->query("UPDATE productos SET stock = $new_stock WHERE id = $product_id");
            }

            $this->conn->commit();
            return $sale_id;

        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
}
