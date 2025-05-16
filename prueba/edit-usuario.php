<?php
    require 'conexion.php';

    //editar usuario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $fecha_nacimiento = $_POST["fecha_nacimiento"];
        $contrasena = $_POST["contrasena"];

        $sql = "UPDATE usuarios SET nombre=?, email=?, fecha_nacimiento=?, contraseña=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $email, $fecha_nacimiento, $contrasena, $_GET['id']);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error al editar usuario: " . $stmt->error;
        }
    }

?>