<?php
require_once __DIR__ . '/../Controllers/SaleController.php';
require_once __DIR__ . '/../../../db.php';

$controller = new SaleController($conn);
$sale = $controller->getSaleById($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->updateSale(
        $sale->id,
        $_POST['total'],
        $_POST['payment_method'],
        $_POST['payment_details'],
        $_POST['status'],
        $_POST['user_id'],
        $_POST['shipping_name'],
        $_POST['shipping_address'],
        $_POST['shipping_city'],
        $_POST['shipping_phone']
    );
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h1>Editar Venta</h1>
    <form method="POST">
        <div class="mb-3">
            <label>Total</label>
            <input type="number" name="total" value="<?= $sale->total ?>" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Método de Pago</label>
            <input type="text" name="payment_method" value="<?= $sale->payment_method ?>" class="form-control" required>
        </div>
       
        <div class="mb-3">
            <label>Estado</label>
            <input type="text" name="status" value="<?= $sale->status ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ID Usuario</label>
            <input type="number" name="user_id" value="<?= $sale->user_id ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nombre Cliente</label>
            <input type="text" name="shipping_name" value="<?= $sale->shipping_name ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="shipping_address" value="<?= $sale->shipping_address ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Ciudad</label>
            <input type="text" name="shipping_city" value="<?= $sale->shipping_city ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="shipping_phone" value="<?= $sale->shipping_phone ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</body>
</html>
