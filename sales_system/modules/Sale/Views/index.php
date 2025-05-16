<?php
require_once __DIR__ . '/../Controllers/SaleController.php';
require_once __DIR__ . '/../Model/Sale.php';
require_once __DIR__ . '/../../../db.php';

$saleController = new SaleController($conn);
$sales = $saleController->getAllSales();
?>

    <meta charset="UTF-8">
    <title>Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
<div class="card">
    <div class="card-header">
        <h4>Ventas
            <a href="create.php" class="btn btn-primary float-end">Crear Nueva Venta</a>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table ">
                <thead>
                    <tr class="table-light">
                        <th>ID</th>
                        <th>Total</th>
                        <th>Método de pago</th>
                        <th>Estado</th>
                        
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= $sale['id'] ?></td>
                            <td>$<?= number_format($sale['total'], 2) ?></td>
                            <td><?= htmlspecialchars($sale['payment_method']) ?></td>
                            <td><?= htmlspecialchars($sale['status']) ?></td>
                            
                            <td><?= $sale['created_at'] ?></td>
                            <td>
                                <!-- Aquí podrías agregar enlaces para ver detalles, editar, eliminar -->
                                <a href="show.php?id=<?= $sale['id'] ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="edit.php?id=<?= $sale['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($sales)) : ?>
                        <tr><td colspan="7" class="text-center">No hay ventas registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

    </div>
<a href="../../../dashboard.php">Salir</a>
</body>
</html>