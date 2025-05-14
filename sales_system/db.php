
<?php
require_once "config.php";
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Fallo la conexión: " . $conn->connect_error);
?>
