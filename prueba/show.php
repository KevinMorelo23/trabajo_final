<?php

require "conexion.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4"> 
        <div class="card">
            <div class="card-header">
                <h4>Visualizar Usuario
                    <a href="index.php" class="btn btn-secondary float-end">Volver</a>
                </h4>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['id'])) {
                    $usurio_id = mysqli_real_escape_string($conn, $_GET['id']);
                    $sql = "SELECT * FROM usuarios WHERE id='$usurio_id'";
                    $resultado = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($resultado) > 0) {
                        $usuario = mysqli_fetch_assoc($resultado);
                    ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>" readonly>
                    </div>
                    
                <?php
                } else {
                    echo "<p class='text-danger'>No se ha proporcionado un ID de usuario.</p>";
                }
            }
                ?>
            </div>
        </div>
    </div>
    
</body>
</html>