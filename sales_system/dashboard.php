
<?php
require_once "config.php";
require_once "auth_middleware.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Dashboard</h2>
  <p>Bienvenido al sistema de ventas.</p>
  <div class="row">
    <div class="col"><a class="btn btn-info w-100 mb-2" href="modules/productos/controlador/ProductoController.php?action=list">Productos</a></div>
    <div class="col"><a class="btn btn-info w-100 mb-2" href="#">Proveedores</a></div>
    <div class="col"><a class="btn btn-info w-100 mb-2" href="#">Categorías</a></div>
    <div class="col"><a class="btn btn-info w-100 mb-2" href="#">Promociones</a></div>
    <div class="col"><a class="btn btn-info w-100 mb-2" href="#">Ventas</a></div>
  </div>
  <a class="btn btn-outline-danger mt-4" href="http://localhost:8001/logout.php">Salir</a>
</div>
</body>
</html>
