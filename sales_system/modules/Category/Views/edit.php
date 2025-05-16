<?php

require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/CategoryController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new CategoryController($conn);

$id = $_GET['id'] ?? null;
$categoria = $controller->getCategoryById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = (int) $_POST['estado'];

    $result = $controller->updateCategory($id, $nombre, $descripcion, $estado);
    $_SESSION['mensaje'] = [
        'tipo' => $result ? 'success' : 'danger',
        'texto' => $result ? 'Categoría actualizada con éxito.' : 'Error al actualizar la categoría.'
    ];
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Editar Categoría</h2>

    <?php if ($categoria): ?>
        <form method="POST">
            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= $categoria->nombre ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción</label>
                <textarea name="descripcion" class="form-control"><?= $categoria->descripcion ?></textarea>
            </div>
            <div class="mb-3">
                <label>Estado</label>
                <select name="estado" class="form-select">
                    <option value="1" <?= $categoria->estado ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= !$categoria->estado ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Categoría no encontrada.</div>
    <?php endif; ?>
</body>
</html>
