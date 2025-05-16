<?php

require 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
 </head>
 <body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Lista Usuarios
                            <a href="create.php" class="btn btn-primary float-end">Agregar Usuario</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Contrasena</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM usuarios";
                                $usuarios = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($usuarios) > 0) {
                                    while ($usuario = mysqli_fetch_assoc($usuarios)) {
                                        echo "<tr>";
                                        echo "<td>" . $usuario['id'] . "</td>";
                                        echo "<td>" . $usuario['nombre'] . "</td>";
                                        echo "<td>" . $usuario['email'] . "</td>";
                                        echo "<td>" . $usuario['fecha_nacimiento'] . "</td>";
                                        echo "<td>
                                                <a href='show.php?id=" . $usuario['id'] . "' class='btn btn-secondary'>Visualizar</a>
                                                <a href='edit.php?id=" . $usuario['id'] . "' class='btn btn-warning'>Editar</a>
                                                <form action='delete.php' method='POST' class='d-inline'>
                                                    <button type='submit' class='btn btn-danger' value='" . $usuario['id'] . "' name='delete_usuario'>Eliminar</button>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No hay usuarios registrados.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </body>
 </html>