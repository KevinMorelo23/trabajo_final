<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/CategoryController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new CategoryController($conn);

$id = $_GET['id'] ?? null;
$categoria = $controller->getCategoryById($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Detalle de Categoría</h2>

    <?php if ($categoria): ?>
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> <?= $categoria->id ?></li>
            <li class="list-group-item"><strong>Nombre:</strong> <?= $categoria->nombre ?></li>
            <li class="list-group-item"><strong>Descripción:</strong> <?= $categoria->descripcion ?></li>
            <li class="list-group-item"><strong>Fecha de creación:</strong> <?= $categoria->fecha_creacion ?></li>
            <li class="list-group-item"><strong>Estado:</strong> <?= $categoria->estado ? 'Activo' : 'Inactivo' ?></li>
        </ul>
        <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
    <?php else: ?>
        <div class="alert alert-danger">Categoría no encontrada.</div>
    <?php endif; ?>
</body>
</html>
