<?php

require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/ProductController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new ProductController($conn);
$products = $controller->getProducts();
$products = $controller->getAllProductsWithPromotions();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1>Lista de Productos
                <a href="create.php" class="btn btn-primary mb-3 float-end">Agregar Producto</a>
            </h1>
        </div>
        <div class="card-body">

            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Categoría</th><th>Proveedor</th><th>Acciones</th>
                    </tr>
                </thead>
               <tbody>
<?php if (count($products) > 0): ?>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= htmlspecialchars($product->name) ?></td>

            <td>
                <?php if ($product->has_promotion): ?>
                    <p><del>$<?= number_format($product->price, 2) ?></del></p>
                    <p><strong>$<?= number_format($product->price_with_discount, 2) ?></strong></p>
                    <p class="text-success"><?= $product->discount_percent ?>% de descuento</p>
                <?php else: ?>
                    $<?= number_format($product->price, 2) ?>
                <?php endif; ?>
            </td>

            <td><?= $product->stock ?></td>
            <td><?= $product->category_id ?></td>
            <td><?= $product->provider_id ?></td>
            <td>
                <a href="show.php?id=<?= $product->id ?>" class="btn btn-info btn-sm">Ver</a>
                <a href="edit.php?id=<?= $product->id ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="delete.php?id=<?= $product->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="7" class="text-center">No hay productos registrados.</td></tr>
<?php endif; ?>
</tbody>

            </table>
        </div>
    </div>

    <!-- Sección de Promociones -->
    <div class="card mt-4">
        <div class="card-header bg-success text-white">
            <h3>Promociones activas</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <?php if ($product->has_promotion): ?>
                        <div class="col-md-4 mb-3">
                            <div class="border p-3 h-100">
                                <h4><?= htmlspecialchars($product->name) ?></h4>
                                <p>Precio original: <del>$<?= number_format($product->price, 2) ?></del></p>
                                <p>Precio con descuento: <strong>$<?= number_format($product->price_with_discount, 2) ?></strong></p>
                                <p>Descuento: <?= $product->discount_percent ?>%</p>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success mt-4"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <a href="../../../dashboard.php" class="btn btn-secondary mt-4">Volver</a>
</div>
</body>

</html>
