
<?php
require_once "config.php";
require_once "db.php";
require_once "helpers.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM usuarios WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hash);
    if ($stmt->fetch() && password_verify($password, $hash)) {
        $_SESSION["user_id"] = $user_id;
        // Redireccionar al sistema de ventas
        header("Location: " . SALES_SYSTEM_URL);
        exit;
    } else {
        $error = "Usuario o contraseña incorrecta.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Login</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
    <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
    <button type="submit" class="btn btn-primary">Ingresar</button>
    <a href="index.php" class="btn btn-link">Volver</a>
  </form>
</div>
</body>
</html>
