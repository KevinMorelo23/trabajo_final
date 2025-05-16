<?php
// Incluye conexión y controlador
require_once '../../../db.php';  // Ajusta la ruta según tu proyecto
require_once '../Controllers/ReportController.php';

$reportController = new ReportController($conn);

$data = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['report_type'])) {
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;
    $reportType = $_GET['report_type'] ?? null;

    if (!$startDate || !$endDate || !$reportType) {
        $error = "Por favor completa todos los campos.";
    } else {
       if ($reportType === 'all_sales') {
    $data = $reportController->getAllSales($startDate, $endDate);
} elseif ($reportType === 'top_products') {
    $data = $reportController->getTopProducts($startDate, $endDate);
} else {
    $error = "Tipo de reporte no válido.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Módulo de Reportes</h1>

    <form method="GET" action="index.php" class="mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Fecha Inicio</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Fecha Fin</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="report_type" class="form-label">Tipo de Reporte</label>
                <select id="report_type" name="report_type" class="form-select" required>
                    <option value="">Seleccione...</option>
                 
                    <option value="top_products" <?= (($_GET['report_type'] ?? '') === 'top_products') ? 'selected' : '' ?>>Productos más vendidos</option>
                    <option value="all_sales" <?= (($_GET['report_type'] ?? '') === 'all_sales') ? 'selected' : '' ?>>Todas las ventas</option>

                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Generar</button>
            </div>
        </div>
    </form>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($data)): ?>
<?php if ($reportType === 'all_sales'): ?>
    <h2>Todas las ventas</h2>
    <table class="table ">
        <thead>
        <tr class="table-light">
            <th>ID Venta</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>ID Cliente</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>$<?= number_format($row['total'], 2) ?></td>
                <td><?= htmlspecialchars($row['payment_method']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>



        <?php elseif ($reportType === 'top_products'): ?>
            <h2>Productos más vendidos</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad Vendida</th>
                    <th>Ingresos</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= $row['total_quantity'] ?></td>
                        <td>$<?= number_format($row['total_revenue'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['report_type'])): ?>
        <div class="alert alert-info">No se encontraron datos para los filtros seleccionados.</div>
    <?php endif; ?>

</div>
</body>
</html>
