<?php

require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/ProviderController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new ProviderController($conn);

$id = $_GET['id'] ?? null;
$prov = $controller->getById($id);

if (!$prov) {
    $_SESSION['mensaje'] = ['tipo' => 'danger', 'texto' => 'Proveedor no encontrado.'];
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    $result = $controller->update($id, $name, $email, $phone, $address);

    $_SESSION['mensaje'] = [
        'tipo' => $result ? 'success' : 'danger',
        'texto' => $result ? 'Proveedor actualizado correctamente.' : 'Error al actualizar el proveedor.'
    ];
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Editar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">

    <h2>Editar Proveedor</h2>

    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre *</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($prov->name) ?>" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($prov->email) ?>" />
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($prov->phone) ?>" />
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <textarea class="form-control" id="address" name="address"><?= htmlspecialchars($prov->address) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

</body>
</html>
