<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Model/Product.php';
require_once __DIR__ . '/../Controllers/ProductController.php';
require_once __DIR__ . '/../../Category/Controllers/CategoryController.php';
require_once __DIR__ . '/../../Provider/Controllers/ProviderController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$productController = new ProductController($conn);
$categoryController = new CategoryController($conn);
$providerController = new ProviderController($conn);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$product = $productController->getProductById($id);

if (!$product) {
    header("Location: index.php");
    exit;
}

// Obtener nombre de categoría y proveedor para mostrar
$category = $categoryController->getCategoryById($product->category_id);
$provider = $providerController->getById($product->provider_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Detalle del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<div class="container">
    <div class="card">
        <div class="card-header">

            <h1>Detalle del Producto</h1>

        </div>
        <div class="card-body">

            <dl class="row">
                
                <dt class="col-sm-3">Nombre:</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($product->name) ?></dd>
        
                <dt class="col-sm-3">Descripción:</dt>
                <dd class="col-sm-9"><?= nl2br(htmlspecialchars($product->description)) ?></dd>
        
                <dt class="col-sm-3">Precio:</dt>
                <dd class="col-sm-9">$<?= number_format($product->price, 2) ?></dd>
        
                <dt class="col-sm-3">Stock:</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($product->stock) ?></dd>
        
                <dt class="col-sm-3">Categoría:</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($category->name ?? $category->nombre ?? 'N/A') ?></dd>
        
                <dt class="col-sm-3">Proveedor:</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($provider->name ?? $provider->nombre ?? 'N/A') ?></dd>
            </dl>

        </div>
    </div>


    <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
</div>

</body>
</html>
