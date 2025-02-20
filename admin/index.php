<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: authentication/login.php"); // Redirect to login if not logged in
    exit();
} else {
    header("Location: dashboard.php"); // Redirect to dashboard if logged in
    exit();
}
?>
