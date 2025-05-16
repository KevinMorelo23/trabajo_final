<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/ProviderController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new ProviderController($conn);

$id = $_GET['id'] ?? null;
$prov = $controller->getById($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Ver Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">

    <h2>Detalles del Proveedor</h2>

    <?php if ($prov): ?>
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> <?= $prov->id ?></li>
            <li class="list-group-item"><strong>Nombre:</strong> <?= htmlspecialchars($prov->name) ?></li>
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($prov->email) ?></li>
            <li class="list-group-item"><strong>Teléfono:</strong> <?= htmlspecialchars($prov->phone) ?></li>
            <li class="list-group-item"><strong>Dirección:</strong> <?= htmlspecialchars($prov->address) ?></li>
            <li class="list-group-item"><strong>Creado:</strong> <?= $prov->created_at ?></li>
            <li class="list-group-item"><strong>Última actualización:</strong> <?= $prov->updated_at ?></li>
        </ul>
        <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
    <?php else: ?>
        <div class="alert alert-danger">Proveedor no encontrado.</div>
        <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
    <?php endif; ?>

</body>
</html>
