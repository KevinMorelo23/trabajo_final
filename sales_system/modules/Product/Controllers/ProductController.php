<?php
require_once __DIR__ . '/../Model/Product.php';

class ProductController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Obtener todos los productos
    public function getProducts() {
        $result = $this->conn->query("SELECT * FROM productos");
        $products = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['price'],
                    $row['stock'],
                    $row['category_id'],
                    $row['provider_id'],
                    $row['created_at'],
                    $row['updated_at']
                );
            }
        }
        return $products;
    }

    public function getAllProductsWithPromotions()
{
    $sql = "SELECT p.*, pr.discount_percent, (p.price - (p.price * pr.discount_percent / 100)) AS price_with_discount FROM productos p LEFT JOIN promociones pr ON p.id = pr.product_id";
$stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $hasPromotion = $row['discount_percent'] !== null;
        $priceWithDiscount = $row['price'];

        if ($hasPromotion) {
            $discount = $row['discount_percent'];
            $priceWithDiscount = $row['price'] - ($row['price'] * $discount / 100);
        } else {
            $discount = 0;
        }

        // Creamos el producto y le agregamos propiedades extra si tiene promoción
        $product = new Product(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['price'],
            $row['stock'],
            $row['category_id'],
            $row['provider_id'],
            $row['created_at'],
            $row['updated_at']
        );

        // Propiedades adicionales
        $product->has_promotion = $hasPromotion;
        $product->price_with_discount = $priceWithDiscount;
        $product->discount_percent = $discount;

        $products[] = $product;
    }

    return $products;
}

    // Obtener producto por ID
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock'],
                $row['category_id'],
                $row['provider_id'],
                $row['created_at'],
                $row['updated_at']
            );
        }
        return null;
    }

    // Crear un nuevo producto
    public function createProduct($name, $description, $price, $stock, $category_id, $provider_id) {
        $stmt = $this->conn->prepare("INSERT INTO productos (name, description, price, stock, category_id, provider_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdiii", $name, $description, $price, $stock, $category_id, $provider_id);
        return $stmt->execute();
    }

    // Actualizar producto existente
    public function updateProduct($id, $name, $description, $price, $stock, $category_id, $provider_id) {
        $stmt = $this->conn->prepare("UPDATE productos SET name = ?, description = ?, price = ?, stock = ?, category_id = ?, provider_id = ? WHERE id = ?");
        $stmt->bind_param("ssdiiii", $name, $description, $price, $stock, $category_id, $provider_id, $id);
        return $stmt->execute();
    }

    // Eliminar producto
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
