
<?php
class Producto {
    private $conn;
    public function __construct($conn) { $this->conn = $conn; }
    public function all() {
        $res = $this->conn->query("SELECT * FROM productos");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
