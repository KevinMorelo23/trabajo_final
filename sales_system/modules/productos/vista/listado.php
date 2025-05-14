
<!DOCTYPE html>
<html>
<head>
  <title>Productos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2>Lista de productos</h2>
  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $prod): ?>
        <tr>
          <td><?= htmlspecialchars($prod['id']) ?></td>
          <td><?= htmlspecialchars($prod['nombre']) ?></td>
          <td><?= htmlspecialchars($prod['precio']) ?></td>
          <td><?= htmlspecialchars($prod['stock']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="../../../dashboard.php" class="btn btn-secondary mt-2">Volver al Dashboard</a>
</div>
</body>
</html>
