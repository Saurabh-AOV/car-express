<?php
session_start();

// Unset session variables
unset($_SESSION['user_id']);
session_destroy();

// Remove user_id from cookies (set expiration time in the past)
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, "/"); // Expire the cookie
}

// Redirect to login page (change 'login.php' to your actual login page)
header("Location: login.php");
exit;
?>
