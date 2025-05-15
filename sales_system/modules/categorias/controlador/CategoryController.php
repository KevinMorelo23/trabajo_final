
<?php
require_once "../../../db.php";
require_once "../modelo/Category.php";
require_once "../../../auth_middleware.php";

$action = $_GET["action"] ?? "index";
$id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

// CRUD functions
function getCategories($conn) {
    $result = $conn->query("SELECT * FROM categorias");
    $categories = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = new Category($row["id"], $row["nombre"]);
        }
    }
    return $categories;
}

function getCategory($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM categorias WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        return new Category($row["id"], $row["nombre"]);
    }
    return null;
}
function createCategory($conn, $nombre) {
    $stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
    $stmt->bind_param("s", $nombre);
    return $stmt->execute();
}
function updateCategory($conn, $id, $nombre) {
    $stmt = $conn->prepare("UPDATE categorias SET nombre=? WHERE id=?");
    $stmt->bind_param("si", $nombre, $id);
    return $stmt->execute();
}
function deleteCategory($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM categorias WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Routing
if ($action === "index") {
    $categorias = getCategories($conn);

    // --- DEPURACIÓN: Descomenta la siguiente línea para ver el contenido de $categorias ---
    // var_dump($categorias); exit;

    if (!isset($categorias) || !is_array($categorias)) {
        $categorias = [];
    }
    require("../vista/Index.php");
} elseif ($action === "show" && $id) {
    $item = getCategory($conn, $id);
    require("../vista/show.php");
} elseif ($action === "create") {
    $error = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"]);
        if ($nombre) {
            createCategory($conn, $nombre);
            header("Location: CategoryController.php?action=index");
            exit;
        } else {
            $error = "El nombre es requerido.";
        }
    }
    require("../vista/create.php");
} elseif ($action === "edit" && $id) {
    $item = getCategory($conn, $id);
    $error = null;
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"]);
        if ($nombre) {
            updateCategory($conn, $id, $nombre);
            header("Location: CategoryController.php?action=show&id=$id");
            exit;
        } else {
            $error = "El nombre es requerido.";
        }
    }
    require("../vista/edit.php");
} elseif ($action === "delete" && $id) {
    deleteCategory($conn, $id);
    header("Location: CategoryController.php?action=index");
    exit;
}
?>
