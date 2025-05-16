<?php

require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/ProviderController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new ProviderController($conn);

$proveedores = $controller->getAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Lista de Proveedores
                <a href="create.php" class="btn btn-primary float-end">Agregar Proveedor</a>
            </h5>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-<?= $_SESSION['mensaje']['tipo'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje']['texto'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proveedores as $prov): ?>
                        <tr>
                            <td><?= $prov->id ?></td>
                            <td><?= htmlspecialchars($prov->name) ?></td>
                            <td><?= htmlspecialchars($prov->email) ?></td>
                            <td><?= htmlspecialchars($prov->phone) ?></td>
                            <td><?= htmlspecialchars($prov->address) ?></td>
                            <td>
                                <a href="show.php?id=<?= $prov->id ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="edit.php?id=<?= $prov->id ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="delete.php?id=<?= $prov->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este proveedor?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($proveedores)): ?>
                        <tr><td colspan="6" class="text-center">No hay proveedores registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>


    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<a href="../../../dashboard.php" class="btn btn-secondary mt-4">Volver</a>
</body>
</html>
