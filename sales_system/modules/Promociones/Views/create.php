<?php
require_once __DIR__ . '/../../../db.php';
require_once __DIR__ . '/../Model/Promociones.php';
require_once __DIR__ . '/../Controllers/PromocionesController.php';

// Obtener productos desde la base de datos
$productos = $conn->query("SELECT id, name FROM productos");

// Guardar promoción si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $discount_percent = $_POST['discount_percent'];
    $start_date = $_POST['start_date'];
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    $controller = new PromocionesController($conn);
    $controller->createPromotion($product_id, $discount_percent, $start_date, $end_date);

    // Redirigir al index con mensaje
    header("Location: index.php?success=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Promoción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Registrar Nueva Promoción</h1>

        <div class="card ">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Producto</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Selecciona un producto --</option>
                            <?php while ($row = $productos->fetch_assoc()): ?>
                                <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="discount_percent" class="form-label">Descuento (%)</label>
                        <input type="number" step="0.01" min="0" max="100" name="discount_percent" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Fecha de Inicio</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">Fecha de Fin (opcional)</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Promoción</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>
</html>
