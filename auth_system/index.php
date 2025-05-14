
<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Auth System - Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Login de usuario</h2>
  <form action="login.php" method="post" class="mb-3">
    <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
    <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
  </form>
  <p>¿Aún no tienes cuenta? <a href="register.php">Regístrate</a></p>
</div>
</body>
</html>
