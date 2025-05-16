
<!DOCTYPE html>
<html>
<head>
  <title>Crear Categoría</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2>Nueva Categoría</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" name="nombre" id="nombre" required>
    </div>
    <button type="submit" class="btn btn-success">Crear</button>
    <a href="CategoryController.php?action=index" class="btn btn-secondary">Volver</a>
  </form>
</div>
</body>
</html>
