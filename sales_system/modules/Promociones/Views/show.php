<?php
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../Model/Promociones.php';
require_once __DIR__ . '/../Controllers/PromocionesController.php';


$product_id = $_GET['product_id'] ?? null;
if (!$product_id) {
    header("Location: index.php");
    exit;
}

$controller = new PromocionesController($conn);
$promos = $controller->getPromotionsByProduct($product_id);

// Obtener nombre del producto
$producto = $conn->query("SELECT name FROM productos WHERE id = {$product_id}")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Promociones del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container mt-4">
    
    <?php if (empty($promos)): ?>
        <div class="alert alert-warning">Este producto no tiene promociones activas.</div>
        <?php else: ?>
            <?php foreach ($promos as $promo): ?>
                <div class="card  ">
                <div class="card-header">
                    <h1 class="mb-4">Promociones para: <?= htmlspecialchars($producto['name']) ?></h1>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Descuento: <?= $promo->discount_percent ?>%</h5>
                    <p class="card-text"><strong>Inicio:</strong> <?= $promo->start_date ?></p>
                    <p class="card-text"><strong>Fin:</strong> <?= $promo->end_date ?: 'Sin fecha de fin' ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
</div>
</body>
</html>
