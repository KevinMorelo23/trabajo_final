<?php

require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/ProviderController.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$controller = new ProviderController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    $result = $controller->create($name, $email, $phone, $address);

    $_SESSION['mensaje'] = [
        'tipo' => $result ? 'success' : 'danger',
        'texto' => $result ? 'Proveedor creado correctamente.' : 'Error al crear el proveedor.'
    ];
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Crear Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Nuevo Proveedor</h2>

        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" id="name" name="name" required />
                </div>
        
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" />
                </div>
        
                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="phone" name="phone" />
                </div>
        
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <textarea class="form-control" id="address" name="address"></textarea>
                </div>
        
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>

        </div>
    </div>



</body>
</html>
