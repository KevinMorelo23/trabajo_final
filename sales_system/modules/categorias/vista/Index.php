
<!DOCTYPE html>
<html>
<head>
  <title>Categorías</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2>Lista de Categorías</h2>
  <a href="CategoryController.php?action=create" class="btn btn-success mb-3">Crear nueva</a>
  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>
    </thead>
    <tbody>
      <?php foreach ($categorias as $cat): ?>
        <tr>
          <td><?= htmlspecialchars($cat["id"]) ?></td>
          <td><?= htmlspecialchars($cat["nombre"]) ?></td>
          <td>
            <a href="CategoryController.php?action=show&id=<?= $cat["id"] ?>" class="btn btn-info btn-sm">Ver</a>
            <a href="CategoryController.php?action=edit&id=<?= $cat["id"] ?>" class="btn btn-primary btn-sm">Editar</a>
            <a href="CategoryController.php?action=delete&id=<?= $cat["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="../../../dashboard.php" class="btn btn-secondary mt-2">Volver al Dashboard</a>
</div>
</body>
</html>
