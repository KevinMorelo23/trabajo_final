
<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost:8001/index.php");
    exit;
}
?>
