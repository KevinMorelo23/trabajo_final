
<?php
require_once "../../../db.php";
require_once "../modelo/Producto.php";
require_once "../../../auth_middleware.php";

$producto = new Producto($conn);

$action = $_GET['action'] ?? 'list';

if ($action === 'list') {
    $productos = $producto->all();
    require("../vista/listado.php");
}
?>
