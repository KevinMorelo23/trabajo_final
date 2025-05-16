<?php
require_once __DIR__ . '/../../../config.php';
require_once __DIR__ . '/../Controllers/CategoryController.php';

// Conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Instanciar el controlador
$categoryController = new CategoryController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $estado = isset($_POST['estado']) ? (int) $_POST['estado'] : 1;

    if (!empty($nombre)) {
        $resultado = $categoryController->createCategory($nombre, $descripcion, $estado);
        if ($resultado) {
            $_SESSION['mensaje'] = [
                'tipo' => 'success',
                'texto' => 'Categoría creada exitosamente.'
            ];
        } else {
            $_SESSION['mensaje'] = [
                'tipo' => 'danger',
                'texto' => 'Error al crear la categoría.'
            ];
        }
    } else {
        $_SESSION['mensaje'] = [
            'tipo' => 'warning',
            'texto' => 'El nombre es obligatorio.'
        ];
    }

    // Redirigir al index
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Categoría</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">

        <div class="card">
            <div class="card-header">Crear Nueva Categoría</div>
            <div class="card-body">
                <form method="POST" action="create.php">
                    <div class="mt-3">
  <label class="form-label">Nombre:</label><br>
                    <input type="text" name="nombre" class="form-control" required>

                    </div>
                    <div class="mt-3">
   <label class="form-label">Descripción:</label><br>
                    <textarea name="descripcion" class="form-control"></textarea>

                    </div>
                    <div class="mt-3">
<label class="form-label">Estado:</label><br>
                    <select name="estado" class="form-select">
                        <option value="1" selected>Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                    </div>
                    
                 
                    

                    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
                </form>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary mt-3">Volver</a>
    </div>
</body>
</html>
