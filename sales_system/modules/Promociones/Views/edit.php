<?php
require_once __DIR__ . '/../../../db.php';
require_once '../Controllers/PromocionesController.php';

// Verificamos si viene el ID del producto
if (!isset($_GET['product_id'])) {
    die('ID de producto no proporcionado');
}

$product_id = $_GET['product_id'];

$controller = new PromocionesController($conn);
$promociones = $controller->getPromotionsByProduct($product_id);

// Por simplicidad, tomamos la primera promoción si existe
$promo = isset($promociones[0]) ? $promociones[0] : null;

if (!$promo) {
    die('Promoción no encontrada para este producto');
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $discount_percent = $_POST['discount_percent'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $controller->updatePromotion($promo->id, $product_id, $discount_percent, $start_date, $end_date);

    header("Location: index.php?msg=Promoción+actualizada+correctamente");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Promoción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2 class="mb-4">Editar Promoción para Producto ID: <?= $product_id ?></h2>

    <form method="POST" class="card p-4 ">
        <div class="mb-3">
            <label for="discount_percent" class="form-label">Descuento (%)</label>
            <input type="number" step="0.01" class="form-control" id="discount_percent" name="discount_percent" value="<?= $promo->discount_percent ?>" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $promo->start_date ?>" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de Fin</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $promo->end_date ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Promoción</button>
        <a href="index.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>

</body>
</html>
