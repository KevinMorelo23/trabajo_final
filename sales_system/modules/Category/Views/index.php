<?php
require_once '../../../db.php';
require_once '../../../config.php';
require_once '../Model/Category.php';
require_once '../Controllers/CategoryController.php';

$controller = new CategoryController($conn);
$categorias = $controller->getCategories();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Categorías</title>
</head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<body>
    <div class="container mt-4">


<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['mensaje']['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']['texto']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4>Categorías
                    <a href="create.php" class="btn btn-primary float-end">Crear nueva categoría</a>
                </h4>
            </div>
            
            <div class="card-body">
                <p>Lista de categorías registradas en el sistema.</p>

                <?php if (!empty($categorias)) : ?>
                    <table class="table">
                        <tr class="table-light">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha de creación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                        <?php foreach ($categorias as $cat) : ?>
                            <tr> 
                                <td><?= $cat->id ?></td>
                                <td><?= $cat->nombre ?></td>
                                <td><?= $cat->descripcion ?></td>
                                <td><?= $cat->fecha_creacion ?></td>
                                <td><?= $cat->estado ?></td>
                                <td>
                                    <a href="show.php?id=<?= $cat->id ?>" class=" btn-outline-success"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
                                    <a href="edit.php?id=<?= $cat->id ?>" class=" btn-outline-warning"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
                                    <a href="delete.php?id=<?= $cat->id ?>" class=" btn-outline-danger"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-backspace"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" /><path d="M12 10l4 4m0 -4l-4 4" /></svg></a>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else : ?>
                    <p>No hay categorías registradas.</p>
                <?php endif; ?>
        </div>
        
    </div>
    <a href="../../../dashboard.php" class="btn btn-secondary mt-4">Volver</a>
</body>
</html>
