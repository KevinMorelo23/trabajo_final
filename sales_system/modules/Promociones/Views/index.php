<?php
// Incluye el archivo de configuración donde se crea la conexión $conn
require_once __DIR__ . '/../../../db.php';  // Ajusta la ruta según tu estructura
require_once __DIR__ . '/../Model/Promociones.php';
require_once __DIR__ . '/../Controllers/PromocionesController.php';

// Ahora $conn debe estar definido, puedes usarlo para crear el controlador
$promocionesController = new PromocionesController($conn);

// Obtén las promociones
$promociones = $promocionesController->getAllPromotions();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Promociones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">

                <h1>Listado de Promociones

                    <a href="create.php" class="btn btn-primary float-end">Nueva Promoción</a>
                </h1>
            </div>
            <div class="card-body">


                
                
                    <table class="table ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID Producto</th>
                                <th>Descuento (%)</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($promociones)): ?>
                                <tr><td colspan="6" class="text-center">No hay promociones registradas.</td></tr>
                            <?php else: ?>
                                <?php foreach ($promociones as $promo): ?>
                                    <tr class="table-light">
                                        <td><?= htmlspecialchars($promo->id) ?></td>
                                        <td><?= htmlspecialchars($promo->product_id) ?></td>
                                        <td><?= htmlspecialchars($promo->discount_percent) ?></td>
                                        <td><?= htmlspecialchars($promo->start_date) ?></td>
                                        <td><?= htmlspecialchars($promo->end_date ?? 'Indefinida') ?></td>
                                        <td>
                                            <a href="show.php?product_id=<?= $promo->product_id ?>" class="btn btn-info btn-sm">Ver</a>
                                            <a href="edit.php?product_id=<?= $promo->product_id ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="delete.php?id=<?= $promo->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta promoción?');">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <a href="../../../dashboard.php" class="btn btn-secondary mt-4">Volver</a>
    </div>
</body>
</html>
