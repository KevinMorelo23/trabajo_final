
<!DOCTYPE html>
<html>
<head>
  <title>Detalle Categoría</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2>Categoría #<?= htmlspecialchars($item->id) ?></h2>
  <p><strong>Nombre:</strong> <?= htmlspecialchars($item->nombre) ?></p>
  <a href="CategoryController.php?action=edit&id=<?= $item->id ?>" class="btn btn-primary">Editar</a>
  <a href="CategoryController.php?action=index" class="btn btn-secondary">Volver a la lista</a>
</div>
</body>
</html>
