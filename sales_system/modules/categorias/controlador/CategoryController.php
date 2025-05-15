
<?php
require_once "../../../db.php";
require_once "../modelo/Category.php";
require_once "../../../auth_middleware.php";

$category = new Category($conn);

$action = $_GET["action"] ?? "index";
$id = $_GET["id"] ?? null;

if ($action === "index") {
    $categorias = $category->all();
    require("../vista/Index.php");
} elseif ($action === "show" && $id) {
    $item = $category->find($id);
    require("../vista/show.php");
} elseif ($action === "create") {
    $error = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"]);
        if ($nombre) {
            $category->create($nombre);
            header("Location: CategoryController.php?action=index");
            exit;
        } else {
            $error = "El nombre es requerido.";
        }
    }
    require("../vista/create.php");
} elseif ($action === "edit" && $id) {
    $item = $category->find($id);
    $error = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"]);
        if ($nombre) {
            $category->update($id, $nombre);
            header("Location: CategoryController.php?action=show&id=$id");
            exit;
        } else {
            $error = "El nombre es requerido.";
        }
    }
    require("../vista/edit.php");
} elseif ($action === "delete" && $id) {
    $category->delete($id);
    header("Location: CategoryController.php?action=index");
    exit;
}
?>
