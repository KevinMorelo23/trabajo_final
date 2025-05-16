
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
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Product/Views/index.php?">Productos</a></div>
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Provider/Views/index.php?">Proveedores</a></div>
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Category/Views/index.php?">Categorías</a></div>
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Promociones/Views/index.php?">Promociones</a></div>
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Sale/Views/index.php?">Ventas</a></div>
    <div class="col"><a class="btn btn-dark w-100 mb-2" href="modules/Report/Views/index.php?">Reportes</a></div>
  </div>
  <a class="btn btn-danger mt-4 " href="http://localhost:8001/logout.php">
    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" /><path d="M15 12h-12l3 -3" /><path d="M6 15l-3 -3" /></svg> <Strong>Salir</Strong></a>
</div>
</body>
</html>
