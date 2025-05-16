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

// Obtener categorías y proveedores para el select
$categories = $categoryController->getCategories();
$providers = $providerController->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $category_id = $_POST['category_id'] ?? null;
    $provider_id = $_POST['provider_id'] ?? null;

    // Validar datos mínimos aquí si quieres

    $productController->createProduct($name, $description, $price, $stock, $category_id, $provider_id);

    // Redirigir con mensaje
    header("Location: index.php?msg=Producto creado correctamente");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="p-4">

<div class="container">
    <h1>Crear Producto</h1>

    <form method="post" action="create.php">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required />
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required />
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required />
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name ?? $cat->nombre) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="provider_id" class="form-label">Proveedor</label>
            <select class="form-select" id="provider_id" name="provider_id" required>
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($providers as $prov): ?>
                    <option value="<?= $prov->id ?>"><?= htmlspecialchars($prov->name ?? $prov->nombre) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
