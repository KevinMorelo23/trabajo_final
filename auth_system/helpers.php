
<?php
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function redirect_to_sales() {
    header("Location: " . SALES_SYSTEM_URL); exit;
}
?>
