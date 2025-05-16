<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $contrasena = $_POST["contrasena"];

    $sql = "INSERT INTO usuarios (nombre, email, fecha_nacimiento, contraseña) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $fecha_nacimiento, $contrasena);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al agregar usuario: " . $stmt->error;
    }
}