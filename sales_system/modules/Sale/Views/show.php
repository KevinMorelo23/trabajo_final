<?php
// Incluir el archivo donde está tu controlador (ajusta ruta si es necesario)
require_once '../Controllers/SaleController.php';
require_once __DIR__ . '/../../../db.php';

$controller = new SaleController($conn);
$saleController = new SaleController($conn); // 💡 Esto crea la instancia

$saleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sale = $controller->getSaleById($saleId);
$products = $controller->getProductsBySaleId($saleId);

// Obtener todas las ventas
$sales = $controller->getAllSales();

// Obtener el ID de la venta desde la URL
$saleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$saleId) {
    die('No se especificó ID de la venta');
}

// Buscar la venta con ese ID
$sale = null;
foreach ($sales as $s) {
    if ($s['id'] == $saleId) {
        $sale = $s;
        break;
    }
}

if (!$sale) {
    die('Venta no encontrada');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Detalle Venta #<?= htmlspecialchars($sale['id']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">


        <h4>Detalle de la venta #<?= htmlspecialchars($sale['id']) ?>
        <a href="index.php" class="float-end">Volver a la lista de ventas</a>
    
    </h4>
        

        <div class="card">
            <div class="card-header">
                <h3>Información de la Venta</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <p><strong>Fecha:</strong> <?= htmlspecialchars($sale['created_at']) ?></p>
                        <p><strong>Total:</strong> $<?= number_format($sale['total'], 2, ',', '.') ?></p>

                    </div>
                    <div class="col">
                        <p><strong>Estado:</strong> <?= htmlspecialchars($sale['status']) ?></p>
                        <p><strong>Método de Pago:</strong> <?= htmlspecialchars($sale['payment_method']) ?></p>

                    </div>

                </div>

            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Información de Envio</h3>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col">
                        <p><strong>Cliente:</strong> <?= htmlspecialchars($sale['shipping_name']) ?></p>
                        <p><strong>Teléfono:</strong> <?= htmlspecialchars($sale['shipping_phone']) ?></p>

                    </div>
                    <div class="col">

                        <p><strong>Dirección:</strong> <?= htmlspecialchars($sale['shipping_address']) ?></p>
                        <p><strong>Ciudad:</strong> <?= htmlspecialchars($sale['shipping_city']) ?></p>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">

                <h3>Productos comprados</h3>

            </div>
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr class="table-light">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $prod): ?>
                        <tr>
                            <td><?= htmlspecialchars($prod['name']) ?></td>
                            <td><?= $prod['quantity'] ?></td>
                            <td>$<?= number_format($prod['price'], 2) ?></td>
                            <td>$<?= number_format($prod['price'] * $prod['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</body>

</html>